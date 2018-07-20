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

    const PERIOD_LIVE       =   'live';
    const PERIOD_LAST_WEEK  =   'week';
    const PERIOD_LAST_MONTH =   'month';
    const PERIOD_LAST_YEAR  =   'year';

    public $timestamps = false;

//    protected $casts = [
//        'options' => 'json'
//    ];
}
