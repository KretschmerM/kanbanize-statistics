<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
use App\Modules\Statistic\Models\StatisticColumn;
use App\Modules\Statistic\Models\StatisticOptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Khill\Lavacharts\Laravel;
use Khill\Lavacharts\Lavacharts;
use Khill\Lavacharts\Options;
use Lava;

class AllController extends Controller
{
    /**
     * @var StatisticResultRepositoryContract
     */
    private $statisticResultRepository;

    public function __construct(StatisticResultRepositoryContract $statisticResultRepository)
    {
        $this->statisticResultRepository = $statisticResultRepository;
        #$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // load options

        // $period = zeitraum aus options


        // $data = $this->statisticResultRepository->getData($period);

        // z.B.
        // open = 'open', 'bug to feature'
        // doing = 'doing', 'review', 'rückfragen kunde'
        // done = 'done'

        // gruppiertes $data array bauen, $groupedData

        // $this->buildLineChart($groupedData);

        // $headers = ....

        // return view('welcome', ....)

        $statistic = $this->statisticResultRepository->getTableDataForToday();

        $headers = $this->statisticResultRepository->getTableHeader();

        $line = $this->buildLineChart();

        $statisticLineChart = $this->buildStatisticLineChart();

        $statisticPieChart = $this->buildStatisticPieChart();

//        return view('welcome', ['statistic' => $statistic, 'header' => $header]);

        return view('welcome', compact('statistic', 'headers', 'line', 'statisticLineChart', 'statisticPieChart'));
    }

    /**
     *
     * On button click fetch todays data
     *
     */
    public function loadDataOnButtonClick()
    {
        $this->statisticResultRepository->getKanbanizeDataForEachBoard();

        return $this->index();
    }

    public function openSettingsOnButtonClick($settingId)
    {
        $fetchTableData = $this->statisticResultRepository->openStatisticOptions($settingId);

//        dd($fetchTableData);

        $names = StatisticColumn::getQuery()->where('boardId', '=',
            (INT)$fetchTableData['data']['boardId'])->orderBy('name', 'ASC')->get();

        $periodSelection = $this->statisticResultRepository->getStatisticPeriod();

        $variationSelection = $this->statisticResultRepository->getStatisticVariation();

        $boardIds = $this->statisticResultRepository->getKanbanizeBoards();

        return view('settings',
            compact('fetchTableData', 'names', 'periodSelection', 'boardIds', 'settingId', 'variationSelection'));
    }

    public function saveSettingsOnButtonClick($settingId)
    {
        $request = request()->all();

//        dd($request);

        if ($settingId) {
            $this->statisticResultRepository->saveStatisticOptions($settingId, $request);
        }
        return $this->openSettingsOnButtonClick($settingId);
    }

    private function buildLineChart() // TODO löschen
    {
        $temperatures = Lava::DataTable();

        $temperatures->addDateColumn('Date')
            ->addNumberColumn('Max Temp')
            ->addNumberColumn('Mean Temp')
            ->addNumberColumn('Min Temp')
            ->addRow(['2014-10-1', 67, 65, 62])
            ->addRow(['2014-10-2', 68, 65, 61])
            ->addRow(['2014-10-3', 68, 62, 55])
            ->addRow(['2014-10-4', 72, 62, 52])
            ->addRow(['2014-10-5', 61, 54, 47])
            ->addRow(['2014-10-6', 70, 58, 45])
            ->addRow(['2014-10-7', 74, 70, 65])
            ->addRow(['2014-10-8', 75, 69, 62])
            ->addRow(['2014-10-9', 69, 63, 56])
            ->addRow(['2014-10-10', 64, 58, 52])
            ->addRow(['2014-10-11', 59, 55, 50])
            ->addRow(['2014-10-12', 65, 56, 46])
            ->addRow(['2014-10-13', 66, 56, 46])
            ->addRow(['2014-10-14', 75, 70, 64])
            ->addRow(['2014-10-15', 76, 72, 68])
            ->addRow(['2014-10-16', 71, 66, 60])
            ->addRow(['2014-10-17', 72, 66, 60])
            ->addRow(['2014-10-18', 63, 62, 62]);

        Lava::LineChart('Temps', $temperatures, [
            'title' => 'Weather in October'
        ]);
    }

    private function buildStatisticLineChart()
    {
        $statisticLineChart = Lava::DataTable();

        $period = [Carbon::today()->subWeek()->toDateString(), Carbon::today()->toDateString()];

        $open = 40;
        $doing = 50;
        $done = 35;

        $statisticLineChart->addDateColumn('Date')
            ->addNumberColumn('open')
            ->addNumberColumn('doing')
            ->addNumberColumn('done');

        foreach ($period as $column) {
            $statisticLineChart->addRow([$column, $open = $open + 10, $doing = $doing + 12, $done = $done + 16]);
        }

        Lava::LineChart('hi', $statisticLineChart, [
            'title' => 'test'
        ]);
    }

    private function buildStatisticPieChart()
    {
        $statisticPieChart = Lava::DataTable();

        $values = [
            'open' => 50,
            'doing' => 40,
            'done' => 30
        ];

        $sum = array_sum($values);

        $chart = [
            'open' => $values['open'] / $sum,
            'doing' => $values['doing'] / $sum,
            'done' => $values['done'] / $sum
        ];


        $statisticPieChart->addStringColumn('Statistic')
            ->addNumberColumn('Percent')
            ->addRow(['open', $chart['open']])
            ->addRow(['doing', $chart['doing']])
            ->addRow(['done', $chart['done']]);

        Lava::PieChart('Test', $statisticPieChart, [
            'title'  => 'Test',
            'is3D'   => true,
//            'slices' => [
//                ['offset' => 0.1],
//                ['offset' => 0.1],
//                ['offset' => 0.1]
//            ]
        ]);
    }
}
