<?php

namespace App\Modules\Statistic\Repositories;

use App\Modules;
use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
use App\Modules\Statistic\Models\Statistic;
use App\Modules\Statistic\Models\StatisticColumn;
use App\Modules\Statistic\Models\StatisticOptions;
use App\Modules\Statistic\Models\StatisticAmount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class StatisticResultRepository implements StatisticResultRepositoryContract
{
    /**
     * @param $boardId
     * @return mixed
     * @throws \Exception
     */
    public function findResultByBoardId($boardId)
    {

        if (Modules\Statistic\Models\Statistic::query()->where('date', '=', date('Y-m-d'))
            ->where('boardId', '=', $boardId)->count()) {
            return null;
        }

        $client = new \GuzzleHttp\Client();
        $url = env('KANBANIZE_URL') . "/api/kanbanize/get_all_tasks/format/json/";

        $response = $client->request("POST", $url,
            [
                'headers' => [
                    'apikey' => env('KANBANIZE_KEY'),
                    'content-type' => 'application/json'
                ],
                'json' => [
                    'boardid' => $boardId
                ]
            ]);

        $body = $response->getBody();

        $data = \GuzzleHttp\json_decode($body);

        $optimize = [];

        foreach ($data as $task) {
            if (!isset($optimize[$task->columnid])) {
                $optimize[$task->columnid] = [
                    'name' => $task->columnname,
                    'count' => 0,
                    'reporter' => [],
                    'nameIntern' => $task->columnid
                ];
            }
            $optimize[$task->columnid]['count']++;


            if (!isset($optimize[$task->columnid]['reporter'][$task->assignee])) {
                $optimize[$task->columnid]['reporter'][$task->assignee] = [
                    'name' => $task->assignee,
                    'count' => 0,
                ];
            }
            $optimize[$task->columnid]['reporter'][$task->assignee]['count']++;
        }

        $statistic = new Statistic([
            'boardId' => $boardId,
            'date' => Carbon::now()
        ]);

        $statistic->save();


        foreach ($optimize as $column) {

            $statisticColumn = StatisticColumn::updateOrCreate([
                'nameIntern' => $column['nameIntern'],
                'name' => $column['name'],
                'boardId' => $boardId
            ]);

            foreach ($column['reporter'] as $reporter) {

                $statisticAmount = new StatisticAmount([
                    'mainId' => $statistic->id,
                    'columnId' => $statisticColumn->id,
                    'count' => $reporter['count'],
                    'user' => $reporter['name']
                ]);

                $statisticAmount->save();
            }
        }
    }

    public function getTableDataForToday()
    {

        $getData = DB::table('kanbanize_statistic_main')
            ->whereBetween('date', [Carbon::today()->subWeek()->toDateString(), Carbon::today()->toDateString()])
            ->select([
                'date',
                'name',
                'nameIntern',
                \DB::raw('SUM(kanbanize_statistic_amount.count) as count'),
            ])
            ->join('kanbanize_statistic_amount', 'mainId', '=', 'kanbanize_statistic_main.id')
            ->join('kanbanize_statistic_column', 'columnId', '=', 'kanbanize_statistic_column.id')
            ->groupBy('columnId', 'mainId')
            ->orderBy('date', 'desc')
            ->orderBy('columnId', 'asc')
            ->get();


        $tableToday = [];

        foreach ($getData as $tableData) {

            $tableToday[$tableData->date][] = [
                'name' => $tableData->name,
                'count' => $tableData->count,
                'date' => $tableData->date
            ];
        }

        return $tableToday;
    }

    public function getTableHeader()
    {
        $getData = $getData = DB::table('kanbanize_statistic_main')
            ->whereBetween('date', [Carbon::today()->subWeek()->toDateString(), Carbon::today()->toDateString()])
            ->select([
                'name'
            ])
            ->join('kanbanize_statistic_amount', 'mainId', '=', 'kanbanize_statistic_main.id')
            ->join('kanbanize_statistic_column', 'columnId', '=', 'kanbanize_statistic_column.id')
            ->get();

        $tableHeader = [];

        foreach ($getData as $header) {

            if (!isset($tableHeader[$header->name])) {
                $tableHeader[$header->name] = [
                    'name' => $header->name
                ];
            }
        }
        return $tableHeader;
    }

    public function openStatisticOptions($settingId)
    {
        $dataSeleced = $options = [];
        try {
            $data = StatisticOptions::getQuery()->where('settingId', '=', $settingId)->first();
            $dataResult = json_decode($data->options, true);
            $dataSeleced = $dataResult['data'];
        } catch (\Exception $es) {
        }


        $options['data'] = [
            'name' => $dataSeleced['name'] ?? '',
            'open' => $dataSeleced['open'] ?? [],
            'doing' => $dataSeleced['doing'] ?? [],
            'done' => $dataSeleced['done'] ?? [],
            'boardId' => $dataSeleced['boardId'] ?? 0,
            'time' => $dataSeleced['time'] ?? '',
            'variation' => $dataSeleced['variation'] ?? 0,
        ];

        return $options;
    }

    public function saveStatisticOptions($settingId, $data)
    {

        $options['data'] = [
            'name' => $data['name'] ?? '',
            'open' => $data['open'] ?? [],
            'doing' => $data['doing'] ?? [],
            'done' => $data['done'] ?? [],
            'boardId' => $data['boardId'] ?? 0,
            'time' => $data['time'] ?? '',
            'variation' => $data['variation'] ?? 0,

        ];


        $json = json_encode($options);

        StatisticOptions::updateOrCreate(['settingId' => $settingId],
            ['boardId' => $options['data']['boardId'], 'options' => $json]);
    }

    public function getStatisticPeriod()
    {
        return [
            StatisticOptions::PERIOD_LIVE => 'today',
            StatisticOptions::PERIOD_LAST_WEEK => 'week',
            StatisticOptions::PERIOD_LAST_MONTH => 'month',
            StatisticOptions::PERIOD_LAST_YEAR => 'year',
        ];
    }

    public function getStatisticVariation()
    {
        return [
            StatisticOptions::STATISTIC_TABLE => 'table',
            StatisticOptions::STATISTIC_LINE_CHART => 'lineChart',
            StatisticOptions::STATISTIC_PIE_CHART => 'pieChart',
        ];
    }

    public function getKanbanizeBoards()
    {
        $client = new \GuzzleHttp\Client();
        $url = env('KANBANIZE_URL') . "/api/kanbanize/get_projects_and_boards/format/json/";

        $response = $client->request("POST", $url,
            [
                'headers' => [
                    'apikey' => env('KANBANIZE_KEY'),
                    'content-type' => 'application/json'
                ],
            ]);

        $body = $response->getBody();

        $data = \GuzzleHttp\json_decode($body);

        $boards = [];

        foreach ($data->projects as $project) {
            foreach ($project->boards as $board) {
                $boards[$board->id] = '(' . $project->name . ') ' . $board->name;
            }
        }

        return $boards;
    }

    public function getKanbanizeDataForEachBoard()
    {
        $boardIds = [];
        foreach ($this->getKanbanizeBoards() as $boardId => $boardName) {
            try {
                $boardIds[] = $this->findResultByBoardId($boardId);
            } catch (\GuzzleHttp\Exception\ClientException $exception) {
                if ($exception->getResponse()->getStatusCode() == 401) {

                } else {
                    throw $exception;
                }
            }
        }
    }
}
