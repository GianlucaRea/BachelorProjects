<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_list_of_user');
            $table->foreign('id_list_of_user') ->references('id')->on('users');
            $table->unsignedBigInteger('id_list_document');
            $table->foreign('id_list_document') ->references('id')->on('documents');
            $table->boolean('notification')->default(false);
            $table->boolean('bookmark')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lists');
    }
}
