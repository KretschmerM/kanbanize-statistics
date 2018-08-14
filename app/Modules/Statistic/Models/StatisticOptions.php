<?php

namespace App\Modules\Statistic\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StatisticOptions
 *
 * @property int $id
 * @property int $boardId
 */
class StatisticOptions extends Model
{
    protected $table = 'kanbanize_statistic_options';

    protected $fillable = [
        'options',
        'boardId',
        'settingId',
    ];

    const PERIOD_LIVE = 'Live';
    const PERIOD_LAST_WEEK = 'Week';
    const PERIOD_TWO_WEEKS = 'Two Weeks';
    const PERIOD_LAST_MONTH = 'Month';
    const PERIOD_LAST_YEAR = 'Year';

    const STATISTIC_TABLE = 'Table';
    const STATISTIC_LINE_CHART = 'Line Chart';
    const STATISTIC_PIE_CHART = 'Pie Chart';

    public $timestamps = false;

//    protected $casts = [
//        'options' => 'json'
//    ];
}
