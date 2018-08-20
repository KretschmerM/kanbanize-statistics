<?php

namespace App\Modules\Statistic\Contracts;

interface StatisticResultRepositoryContract
{
    /**
     * @param $boardId
     * @return mixed
     */
    public function findResultByBoardId($boardId);

    public function getTableDataForToday();

    public function getTableHeader();

    public function saveStatisticOptions($settingId, $data);

    public function openStatisticOptions($settingId);

    public function getStatisticPeriod();

    public function getStatisticVariation();

    public function getStatisticInterval();

    public function getKanbanizeBoards();

    public function getKanbanizeDataForEachBoard();

    public function getDataForStatistic($boardId, $from, $to);

    public function getStatisticOptions();

    public function getStatisticData($option);

    public function deleteStatistic($settingId);

    public function getNewStatisticId();
}
