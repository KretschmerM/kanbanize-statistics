<?php

namespace App\Modules\Statistic\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class StatisticAmount
 *
 * @property int $id
 * @property int $mainId
 * @property int $columnId
 * @property int $count
 * @property string $user
 */
class StatisticAmount extends Model
{
    protected $table = 'kanbanize_statistic_amount';

    public function summaryTasks()
    {
        return $this->belongsTo(Statistic::class, 'id', 'mainId');
    }

    public function summarynames()
    {
        return $this->belongsTo(StatisticColumn::class, 'id', 'columnId');
    }

    public function column()
    {
        return $this->hasMany('app/Modules/Statistic/Models/');
    }

    protected $fillable = [
        'mainId',
        'columnId',
        'count',
        'user',
    ];

    public $timestamps = false;


}
