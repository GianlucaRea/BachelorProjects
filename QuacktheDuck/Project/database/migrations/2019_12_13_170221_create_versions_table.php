<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_document');
            $table->foreign('id_document') ->references('id')->on('documents');
            $table->integer('version_number');
        });
        DB::table('versions')->insert([
            ['id_document'=>'1','version_number'=> '1'],
            ['id_document'=>'2','version_number'=> '1'],
            ['id_document'=>'3','version_number'=> '1'],
            ['id_document'=>'4','version_number'=> '1'],
            ['id_document'=>'4','version_number'=> '2'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versions');
    }
}
