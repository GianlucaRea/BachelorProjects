<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_document');
            $table->foreign('id_document') ->references('id')->on('documents');
            $table->String('tag_name');
        });
        DB::table('tags')->insert([
            ['id_document'=> '1','tag_name'=>'fisica'],['id_document'=> '1','tag_name'=>'meccanica'],
            ['id_document'=> '2','tag_name'=>'database'],['id_document'=> '2','tag_name'=>'query'],
            ['id_document'=> '3','tag_name'=>'divina commedia'],['id_document'=> '3','tag_name'=>'alighieri'],
            ['id_document'=> '4','tag_name'=>'Machine Learning'],['id_document'=> '4','tag_name'=>'alexa'],
            ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
