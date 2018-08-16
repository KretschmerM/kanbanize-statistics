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
        $settings = $this->statisticResultRepository->getStatisticOptions();

        $id = $this->statisticResultRepository->getNewStatisticId();

        return view('welcome', compact( 'settings', 'id'));
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

    public function deleteStatisticOnButtonClick($settingId)
    {
        $this->statisticResultRepository->deleteStatistic($settingId);

        return $this->index();
    }

    public function openSettingsOnButtonClick($settingId)
    {
        $fetchTableData = $this->statisticResultRepository->openStatisticOptions($settingId);

        $names = StatisticColumn::getQuery()->where('boardId', '=',
            (INT)$fetchTableData['data']['boardId'])->orderBy('name', 'ASC')->get();

        $periodSelection = $this->statisticResultRepository->getStatisticPeriod();

        $variationSelection = $this->statisticResultRepository->getStatisticVariation();

        $boardIds = $this->statisticResultRepository->getKanbanizeBoards();

        $id = $this->statisticResultRepository->getNewStatisticId();

        return view('settings',
            compact('fetchTableData', 'names', 'periodSelection', 'boardIds', 'settingId', 'variationSelection', 'id'));
    }

    public function saveSettingsOnButtonClick($settingId)
    {
        $request = request()->all();

        $options = $this->statisticResultRepository->saveStatisticOptions($settingId, $request);

        if (($options['data']['time']) == null) {

            return $this->openSettingsOnButtonClick($settingId);

        } else {

            return $this->index();
        }
    }
}
