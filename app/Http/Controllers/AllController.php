<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
use App\Modules\Statistic\Models\StatisticColumn;
use App\Modules\Statistic\Models\StatisticOptions;
use Illuminate\Http\Request;
use Khill\Lavacharts\Laravel;
use Khill\Lavacharts\Lavacharts;
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

//        return view('welcome', ['statistic' => $statistic, 'header' => $header]);

        return view('welcome', compact('statistic', 'headers', 'line'));
    }

    /**
     *
     * On button click fetch todays data
     *
     */
    public function loadDataOnButtonClick($boardId)
    {
        $getBoardData = $this->statisticResultRepository->findResultByBoardId($boardId);

        return $this->index();
    }

    public function openSettingsOnButtonClick()
    {
//        return view('settings');

        $data  = StatisticOptions::firstOrFail()->options;
        $names = StatisticColumn::getQuery()->where('boardId','=',50)->orderBy('name','ASC')->get();

        $options = json_decode($data, true);

        $fetchTableData = $this->statisticResultRepository->openStatisticOptions($options);

      //  dd($fetchTableData['data']['open'], $names);

        return view('settings', compact('fetchTableData', 'names'));
    }

    public function saveSettingsOnButtonClick()
    {
        $data = StatisticOptions::firstOrFail()->options;

        $names = StatisticColumn::all();

        $options = json_decode($data, true);

        $fetchTableData = $this->statisticResultRepository->openStatisticOptions($options);



        $data = request()->all();

        $saveTableData = $this->statisticResultRepository->saveStatisticOptions($data);

        return view('settings', compact('fetchTableData', 'names'));

//        return view('settings');
    }

    private function buildLineChart()
    {
        $temperatures = Lava::DataTable();

        $temperatures->addDateColumn('Date')
            ->addNumberColumn('Max Temp')
            ->addNumberColumn('Mean Temp')
            ->addNumberColumn('Min Temp')
            ->addRow(['2014-10-1',  67, 65, 62])
            ->addRow(['2014-10-2',  68, 65, 61])
            ->addRow(['2014-10-3',  68, 62, 55])
            ->addRow(['2014-10-4',  72, 62, 52])
            ->addRow(['2014-10-5',  61, 54, 47])
            ->addRow(['2014-10-6',  70, 58, 45])
            ->addRow(['2014-10-7',  74, 70, 65])
            ->addRow(['2014-10-8',  75, 69, 62])
            ->addRow(['2014-10-9',  69, 63, 56])
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

}
