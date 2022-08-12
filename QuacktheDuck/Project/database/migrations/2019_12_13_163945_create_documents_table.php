<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('id_user_document');
            $table->foreign('id_user_document') ->references('id')->on('users');
            $table->String('title');
            $table->integer('highlighting')->default('0');
            $table->String('university');
            $table->String('course');
            $table->String('subject');
            $table->integer('value')->default('10');
            $table->String('source')->nullable();


        });
        DB::table('documents')->insert([
            ['id_user_document' => '1' , 'title' => 'appunti fisica 1' ,'university' => 'Univaq' , 'course' => 'Informatica','subject'=>'Informatica'],
            ['id_user_document' => '1' , 'title' => 'appunti database' ,'university' => 'Univaq' , 'course' => 'Informatica','subject'=>'Informatica'],
            ['id_user_document' => '3' , 'title' => 'appunti dante' ,'university' => 'Univaq' , 'course' => 'Letteratura','subject'=>'Letteratura'],
            ['id_user_document' => '2' , 'title' => 'appunti machine learning' ,'university' => 'Univaq' , 'course' => 'Informatica','subject'=>'IA'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
