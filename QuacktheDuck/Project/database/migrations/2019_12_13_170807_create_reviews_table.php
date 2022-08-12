<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('id_review_by_user');
            $table->foreign('id_review_by_user') ->references('id')->on('users');
            $table->unsignedBigInteger('id_document_reviewed');
            $table->foreign('id_document_reviewed') ->references('id')->on('documents');
            $table->integer('stars_number');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
}
