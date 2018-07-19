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
use Monolog\Handler\StreamHandler;
use PhpParser\Node\Stmt\Foreach_;


class StatisticResultRepository implements StatisticResultRepositoryContract
{
//    public function getTableHeader($boardId)
//    {
//        $client = new \GuzzleHttp\Client();
//        $url  = env('KANBANIZE_URL') . "/api/kanbanize/get_board_structure/format/json";
//
//
//    }

    /**
     * @param $boardId
     * @return mixed
     * @throws \Exception
     */
    public function findResultByBoardId($boardId)
    {

        if (Modules\Statistic\Models\Statistic::query()->where('date', '=', date('Y-m-d'))->count()) {
            return null;
        }

        $client = new \GuzzleHttp\Client();
        $url  = env('KANBANIZE_URL') . "/api/kanbanize/get_all_tasks/format/json/";

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

            $statisticColumn = StatisticColumn::firstOrCreate(
                ['nameIntern' => $column['nameIntern']],
                ['name' => $column['name']]);

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



//        dd($tableToday);
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

//        dd($getData);

        foreach ($getData as $header) {

            if (!isset($tableHeader[$header->name])) {
                $tableHeader[$header->name] = [
                    'name' => $header->name];
            }
        }
        return $tableHeader;
    }

    public function openStatisticOptions($options   )
    {


//        dd($options);

//        dd($options['data']['name']);

        return $options;
    }

    public function saveStatisticOptions($data)
    {
        $options['data'] = [
            'name' => $data['name'] ?? '',
            'open' => $data['open'] ?? [],
            'doing' => $data['doing'] ?? [],
            'done' => $data['done'] ?? [],
            'time' => $data['time'] ?? [],
        ];

            $json = json_encode($options);

        $options =  StatisticOptions::updateOrCreate(['boardId' => 50], ['options' => $json]);
    }
}
