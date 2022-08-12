<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_doc');
            $table->foreign('id_doc') ->references('id')->on('documents');
            $table->String('type');
            $table->String('file');
        });
        DB::table('contents')->insert([
            ['id_doc'=>'1','type'=> 'pdf','file'=>'appuntifisica1.pdf'],
            ['id_doc'=>'2','type'=> 'pdf','file'=>'appuntidatabase.pdf'],
            ['id_doc'=>'3','type'=> 'pdf','file'=>'appuntidante.pdf'],
            ['id_doc'=>'4','type'=> 'pdf','file'=>'appuntimachinelearning.pdf'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
