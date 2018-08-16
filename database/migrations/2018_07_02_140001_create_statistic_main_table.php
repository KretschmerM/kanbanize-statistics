<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticMainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanbanize_statistic_main', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('boardId');
            $table->integer('newBugs');

            $table->index(['date', 'boardId'], 'UKEY_date_boardId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kanbanize_statistic_main');
    }
}
