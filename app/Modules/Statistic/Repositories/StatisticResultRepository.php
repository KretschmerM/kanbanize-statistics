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

//    private $cacheBoardIds = [];

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
        $newBugs = 0;

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

            $test = Carbon::createFromFormat('Y-m-d H:i:s', $task->createdat);

            if ($test->gte(Carbon::now()->subDays(1))) {
                $newBugs += 1;
            }
        }

        $statistic = new Statistic([
            'boardId' => $boardId,
            'date' => Carbon::now(),
            'newBugs' => $newBugs
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
        $getData = DB::table('kanbanize_statistic_main')
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
            'interval' => $dataSeleced['interval'] ?? 0,
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
            'interval' => $data['interval'] ?? 0
        ];


        $json = json_encode($options);

        StatisticOptions::updateOrCreate(['settingId' => $settingId],
            ['boardId' => $options['data']['boardId'], 'options' => $json]);

        return $options;
    }

    public function getStatisticPeriod()
    {
        return [
            StatisticOptions::PERIOD_LIVE => 'Live',
            StatisticOptions::PERIOD_LAST_WEEK => 'Week',
            StatisticOptions::PERIOD_TWO_WEEKS => 'Two Weeks',
            StatisticOptions::PERIOD_LAST_MONTH => 'Month',
            StatisticOptions::PERIOD_LAST_YEAR => 'Year',
        ];
    }

    public function getStatisticVariation()
    {
        return [
            StatisticOptions::STATISTIC_TABLE => 'Table',
            StatisticOptions::STATISTIC_LINE_CHART => 'Line Chart',
            StatisticOptions::STATISTIC_PIE_CHART => 'Pie Chart',
        ];
    }

    public function getStatisticInterval()
    {
        return [
            StatisticOptions::INTERVAL_DAILY => 'Daily',
            StatisticOptions::INTERVAL_WEEKLY => 'Weekly',
            StatisticOptions::INTERVAL_SPRINT_TWO_WEEKS => 'Sprint 2 Weeks',
            StatisticOptions::INTERVAL_MONTHLY => 'Monthly',
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

    public function deleteStatistic($settingId)
    {
        DB::table('kanbanize_statistic_options')->where('settingId', '=', $settingId)->delete();
    }

    public function getStatisticData($option)
    {
        $date = [];
        $statistic = \GuzzleHttp\json_decode($option['options'], 'true');
        switch ($statistic['data']['time']) {
            case $statistic['data']['time'] === 'Year':

                $from = Carbon::today()->subYear()->toDateString();
                $to = Carbon::today()->toDateString();

                $date = $this->buildDataArray($from, $to, $statistic, $option['boardId']);

                break;

            case $statistic['data']['time'] === 'Month':

                $from = Carbon::today()->subMonth()->toDateString();
                $to = Carbon::today()->toDateString();

                $date = $this->buildDataArray($from, $to, $statistic, $option['boardId']);

                break;

            case $statistic['data']['time'] === 'Two Weeks':

                $from = Carbon::today()->subWeeks(2)->toDateString();
                $to = Carbon::today()->toDateString();

                $date = $this->buildDataArray($from, $to, $statistic, $option['boardId']);

                break;

            case $statistic['data']['time'] === 'Week':

                $from = Carbon::today()->subWeek()->toDateString();
                $to = Carbon::today()->toDateString();

                $date = $this->buildDataArray($from, $to, $statistic, $option['boardId']);

                break;

            case $statistic['data']['time'] === 'Live':

                $from = Carbon::today()->toDateString();
                $to = Carbon::today()->toDateString();

                $date = $this->buildDataArray($from, $to, $statistic, $option['boardId']);

                break;
        }

        return $date;
    }

    public function getDataForStatistic($boardId, $from, $to)
    {

        $getData = DB::table('kanbanize_statistic_main')
            ->whereBetween('date', [$from, $to])
            ->where('kanbanize_statistic_main.boardId', '=', $boardId)
            ->select([
                'nameIntern',
                'date',
                'newBugs',
                \DB::raw('SUM(kanbanize_statistic_amount.count) as count'),

            ])->distinct()
            ->leftJoin('kanbanize_statistic_amount', 'mainId', '=', 'kanbanize_statistic_main.id')
            ->leftJoin('kanbanize_statistic_column', 'columnId', '=', 'kanbanize_statistic_column.id')
            ->groupBy('columnId', 'date', 'newBugs')
            ->get();

//        $this->cacheBoardIds[$boardId] = $getData;

        return $getData;
    }

    protected function buildDataArray($from, $to, $statistic, $boardId)
    {
        $date = [];

        $totalLastDate = 0;
        $totalCurrentDate = 0;
        $currentDate = '';
        $amount = $this->getDataForStatistic($boardId, $from, $to);

        foreach ($amount as $count) {
            if (!array_key_exists($count->date, $date)) {
                $date[$count->date] = [
                    'open' => 0,
                    'doing' => 0,
                    'done' => 0,
                    'newBugs' => 0,
                ];
            }

            if ($currentDate != $count->date) {
                $date[$count->date]['newBugs'] = $totalCurrentDate - $totalLastDate;

                $totalLastDate = $totalCurrentDate;
                $totalCurrentDate = 0;
                $currentDate = $count->date;
            }

            if (in_array($count->nameIntern, $statistic['data']['open'])) {
                $date[$count->date]['open'] += (int)$count->count;
            }
            if (in_array($count->nameIntern, $statistic['data']['doing'])) {
                $date[$count->date]['doing'] += (int)$count->count;
            }
            if (in_array($count->nameIntern, $statistic['data']['done'])) {
                $date[$count->date]['done'] += (int)$count->count;
            }
            $date[$count->date]['newBugs'] = $count->newBugs;
        }

        $interval = key($date);
        $data = [];
        $newBugs = 0;

        if ($statistic['data']['interval'] != 'Daily') {
            foreach ($date as $day => $values) {
                $newBugs += $values['newBugs'];
                if ($statistic['data']['interval'] === 'Weekly') {
                    if (Carbon::parse($interval) == Carbon::parse($day)) {
                        $data[$day] = [
                            'open' => $values['open'],
                            'doing' => $values['doing'],
                            'done' => $values['done'],
                            'newBugs' => $values['newBugs'],
                        ];
                        $values['newBugs'] = $newBugs;
                        $newBugs = 0;
                        $interval = Carbon::parse($interval)->addWeek();
                        $interval = $interval->toDateString();
                    }
                } elseif ($statistic['data']['interval'] === 'Sprint 2 Weeks') {
                    if (Carbon::parse($interval) == Carbon::parse($day)) {
                        $data[$day] = [
                            'open' => $values['open'],
                            'doing' => $values['doing'],
                            'done' => $values['done'],
                            'newBugs' => $values['newBugs'],
                        ];
                        $values['newBugs'] = $newBugs;
                        $newBugs = 0;
                        $interval = Carbon::parse($interval)->addWeeks(2);
                        $interval = $interval->toDateString();
                    }
                } elseif ($statistic['data']['interval'] === 'Monthly') {
                    if (Carbon::parse($interval) == Carbon::parse($day)) {
                        $data[$day] = [
                            'open' => $values['open'],
                            'doing' => $values['doing'],
                            'done' => $values['done'],
                            'newBugs' => $values['newBugs'],
                        ];
                        $values['newBugs'] = $newBugs;
                        $newBugs = 0;
                        $interval = Carbon::parse($interval)->addMonth();
                        $interval = $interval->toDateString();
                    }
                }
            }
            $date = $data;
        }

        return $date;
    }

    public function getStatisticOptions()
    {
        $data = $options = StatisticOptions::getQuery()->select('settingId', 'options', 'boardId')->get();

        $options = [];

        foreach ($data as $option) {
            $options[] = [
                'settingId' => $option->settingId,
                'boardId' => $option->boardId,
                'options' => $option->options
            ];
        }

        return $options;
    }

    public function getNewStatisticId()
    {
        $settingIds = DB::table('kanbanize_statistic_options')
            ->select([
                'settingId'
            ])
            ->max('settingId');

        $id = $settingIds + 1;

        return $id;
    }

}
