<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('university');
            $table->string('course');
            $table->boolean('subscription')->default(false);
            $table->integer('points')->default(10);
            $table->rememberToken();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        DB::table('users')->insert([
            ['name' => 'matteo' ,'surname' => 'riei' , 'email'=>'emailcasuale1@qualcosa.com','password' =>'password1','university'=>'Univaq','course'=>'informatica'],
            ['name' => 'giovanni' ,'surname' => 'ribbi' , 'email'=>'emailcasuale2@qualcosa.com','password' =>'password2','university'=>'Univaq','course'=>'informatica'],
            ['name' => 'luca' ,'surname' => 'inno' , 'email'=>'emailcasuale3@qualcosa.com','password' =>'password3','university'=>'Univaq','course'=>'informatica'],
            ['name' => 'giuseppe' ,'surname' => 'cognome' , 'email'=>'emailcasuale4@qualcosa.com','password' =>'password4','university'=>'Univaq','course'=>'informatica'],

        ]);




    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
