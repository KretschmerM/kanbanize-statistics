<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
use App\Modules\Statistic\Controllers\StatisticResultController;
use Illuminate\Http\Request;
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
        $statistic = $this->statisticResultRepository->getTableDataForToday();

        $headers = $this->statisticResultRepository->getTableHeader();

//        return view('welcome', ['statistic' => $statistic, 'header' => $header]);

        return view('welcome', compact('statistic', 'headers'));
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
        $fetchTableDate = $this->statisticResultRepository->openStatisticOptions();

        return view('settings');
    }

    public function saveSettingsOnButtonClick()
    {
        $data = request()->all();

        $saveTableData = $this->statisticResultRepository->saveStatisticOptions($data);

        return view('settings');
    }
}
