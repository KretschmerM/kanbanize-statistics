<?php
/**
 * Created by IntelliJ IDEA.
 * User: maxkretschmer
 * Date: 02.08.18
 * Time: 08:52
 */

namespace App\Modules\Statistic\Services;

use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
use Lava;


class StatisticService
{
    private $statisticResultRepository;

    public function __construct(StatisticResultRepositoryContract $statisticResultRepository)
    {
        $this->statisticResultRepository = $statisticResultRepository;
    }

    public function buildStatistik($option)
    {

        $data = $this->statisticResultRepository->getStatisticData($option);

        $options = json_decode($option['options'], true);

        switch ($options['data']['variation']) {

            case ($options['data']['variation'] === 'Line Chart'):

                $this->buildStatisticLineChart($data, $option['settingId']);

                return view('layouts.lineChart', compact('options', 'data', 'option'));
                break;
            case ($options['data']['variation'] === 'Pie Chart'):

                $this->buildStatisticPieChart($data, $option['settingId'], $options['data']['time']);

                return view('layouts.pieChart', compact('options', 'data', 'option'));
                break;
            case ($options['data']['variation'] === 'Table'):

                return view('layouts.table', compact('options', 'data', 'option'));
                break;
        }

        return 'something went wrong';
    }

    private function buildStatisticLineChart($data, $settingId)
    {
        $statisticLineChart = Lava::DataTable();

        $statisticLineChart->addDateColumn('Date')
            ->addNumberColumn('open')
            ->addNumberColumn('doing')
            ->addNumberColumn('done')
            ->addNumberColumn('newBugs');

        foreach ($data as $date => $values) {
            $statisticLineChart->addRow([
                $date,
                $values['open'],
                $values['doing'],
                $values['done'],
                $values['newBugs']
            ]);
        }

        Lava::LineChart('lineChart_' . $settingId, $statisticLineChart, [
        ]);
    }

    private function buildStatisticPieChart($data, $settingId, $time)
    {
        $statisticPieChart = Lava::DataTable();

        $pie = end($data);

        if ($time !== 'Live') {
            $pie['newBugs'] = 0;
            foreach ($data as $day){
                $pie['newBugs'] += $day['newBugs'];
            }
        }

        $chart = [
            'open' => $pie['open'],
            'doing' => $pie['doing'],
            'done' => $pie['done'],
            'newBugs' => $pie['newBugs'],
        ];

        $statisticPieChart->addStringColumn('Statistic')
            ->addNumberColumn('Percent')
            ->addRow(['open', $chart['open']])
            ->addRow(['doing', $chart['doing']])
            ->addRow(['done', $chart['done']]);

        Lava::PieChart('pieChart_' . $settingId, $statisticPieChart, [
            'is3D' => true,
            'title' => $chart['newBugs'] . ' ' . 'Neue Bugs im Zeitraum: ' . $time
        ]);
    }
}
