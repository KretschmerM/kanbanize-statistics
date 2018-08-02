<?php
/**
 * Created by IntelliJ IDEA.
 * User: maxkretschmer
 * Date: 02.08.18
 * Time: 08:52
 */

namespace App\Modules\Statistic\Services;


class StatisticService
{
    public function buildStatistik($option) {

        $data = $this->statisticResultRepository->getTimePeriodForEachStatistic();

        

        return 'test';
    }
}
