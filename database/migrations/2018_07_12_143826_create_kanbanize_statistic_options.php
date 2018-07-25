<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKanbanizeStatisticOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanbanize_statistic_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('boardId')->unique();
            $table->text('options');
            $table->integer('settingId');
            $table->string('statisticVariation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kanbanize_statistic_options');
    }
}
