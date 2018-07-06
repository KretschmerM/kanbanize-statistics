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
}
