<?php

namespace App\Modules\Statistic\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StatisticColumn
 *
 * @property int $id
 * @property string $name
 * @property string $nameIntern
 * @property int $boardId
 */
class StatisticColumn extends Model
{
    protected $table = 'kanbanize_statistic_column';

    public function amount()
    {
        return $this->belongsTo(StatisticAmount::class, 'columnId', 'id');
    }

    protected $fillable = [
        'name',
        'nameIntern',
        'boardId'
    ];

    public $timestamps = false;
}
