<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKanbanizeStatisticAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanbanize_statistic_amount', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mainId');
            $table->integer('columnId');
            $table->integer('count');
            $table->string('user');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kanbanize_statistic_amount');
    }
}
