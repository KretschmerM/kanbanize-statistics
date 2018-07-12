<?php
//namespace App\Modules\Statistic\Controllers;
//use App\Http\Controllers\Controller;
//use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
//use Illuminate\Http\Request;
//
//class StatisticResultController extends Controller
//{
//    /**
//     * @var StatisticResultRepositoryContract
//     */
//    private $statisticResultRepository;
//
//    public function __construct(StatisticResultRepositoryContract $statisticResultRepository)
//    {
//        $this->statisticResultRepository = $statisticResultRepository;
//        #$this->middleware('auth');
//    }
//
//    /**
//     * Show the application dashboard.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function home()
//    {
//        $statistic = $this->statisticResultRepository->getTableDataForToday();
//
//        $headers = $this->statisticResultRepository->getTableHeader();
//
//        return view('welcome', ['statistic' => $statistic, 'header' => $header]);
//
//        return view('welcome', compact('statistic', 'headers'));
//    }
//
//    /**
//     *
//     * On button click fetch todays data
//     *
//     */
//    public function loadDataOnButtonClick($boardId)
//    {
//        $getBoardData = $this->statisticResultRepository->findResultByBoardId($boardId);
//
//        return view('welcome', compact('getBoardData'));
//    }
//
//    /**
//     * On button click save options
//     */
//    public function saveSettingsOnButtonClick()
//    {
//        dd(request()->all());
//
//        return view('/settings' );
//    }
//
//}
