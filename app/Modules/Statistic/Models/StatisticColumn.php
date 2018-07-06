<?php

namespace App\Modules\Statistic\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StatisticColumn
 *
 * @property int $id
 * @property string $name
 * @property string $nameIntern
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
    ];

    public $timestamps = false;
}
