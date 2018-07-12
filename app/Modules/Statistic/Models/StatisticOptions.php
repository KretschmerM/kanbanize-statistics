<?php

namespace App\Modules\Statistic\Models;

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
    ];

    public $timestamps = false;
}
