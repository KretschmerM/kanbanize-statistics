<?php

namespace App\Modules\Statistic\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Statistic
 *
 * @property int $id
 * @property string $date
 * @property int $boardId
 */
class Statistic extends Model
{
    protected $table = 'kanbanize_statistic_main';

    public function evaluation()
    {
        return $this->hasMany(StatisticAmount::class, 'mainId', 'id');
    }

    public function options()
    {
        return $this->hasOne(StatisticOptions::class,'boardId', 'id');
    }

    protected $casts = [
        'date' => 'date'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'boardId',
        'date',
    ];

    public $timestamps = false;
}
