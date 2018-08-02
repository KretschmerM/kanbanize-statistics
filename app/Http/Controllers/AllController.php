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
        $statistic = $this->statisticResultRepository->getTableDataForToday();      // Muss wahrscheinlich nicht an die View gegeben werden.
        // Lädt die Daten vom heutigen Tag und Speicher diese ab

//        $headers = $this->statisticResultRepository->getTableHeader();              // lädt alle table headers
//                                                                                    // muss angepasst werden bzw komplett ersetzt

        $data = $this->statisticResultRepository->getTimePeriodForEachStatistic();  // lädt mir alle Relevenaten daten für die Charts und gibt diese Weiter

        $statisticLineChart = $this->buildStatisticLineChart($data);                // erstellt die LineChart

        $statisticPieChart = $this->buildStatisticPieChart($data);                  // erstellt die PieCharts

        return view('welcome', compact('statistic', 'statisticLineChart', 'statisticPieChart', 'data'));
    }

//    public function buildCharts()
//    {
//        $graph = $this->statisticResultRepository->buildStatisticChart();
//
//        return view('statisticBox', compact('graph'));
//    }

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

    private function buildStatisticLineChart($data)
    {
        $statisticLineChart = Lava::DataTable();

        $statisticLineChart->addDateColumn('Date')
            ->addNumberColumn('open')
            ->addNumberColumn('doing')
            ->addNumberColumn('done');

        foreach ($data as $option) {
            foreach ($option as $date => $values) {
                $statisticLineChart->addRow([$date, $values['open'], $values['doing'], $values['done']]);
            }
        }
        Lava::LineChart('hi', $statisticLineChart, [
            'title' => 'test'
        ]);
    }

    private function buildStatisticPieChart($data)
    {
        $statisticPieChart = Lava::DataTable();

        foreach ($data as $option) {
            $pie = end($option);
        }

        $sum = array_sum($pie);

        $chart = [
            'open' => $pie['open'] / $sum,
            'doing' => $pie['doing'] / $sum,
            'done' => $pie['done'] / $sum
        ];


        $statisticPieChart->addStringColumn('Statistic')
            ->addNumberColumn('Percent')
            ->addRow(['open', $chart['open']])
            ->addRow(['doing', $chart['doing']])
            ->addRow(['done', $chart['done']]);

        Lava::PieChart('Test', $statisticPieChart, [
            'title' => 'Test',
            'is3D' => true,
        ]);
    }
}
