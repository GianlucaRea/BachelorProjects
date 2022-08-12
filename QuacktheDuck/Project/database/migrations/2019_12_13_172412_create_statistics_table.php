<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user') ->references('id')->on('users');
            $table->integer('average_feedback_single_doc')->default(0);
            $table->integer('average_feedback_total_doc')->default(0);
            $table->integer('number_uploaded_doc')->default(0);
            $table->integer('points_feedback_single_doc')->default(0);
            $table->integer('points_feedback_total_doc') ->default(0);
            $table->integer('rank_position')->default(0);
        });
    }


    //DB::connection('mysql')->table('statistics')->insert([ ]};
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
