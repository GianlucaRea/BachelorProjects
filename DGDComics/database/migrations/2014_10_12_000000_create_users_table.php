<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('username')->unique();
            $table->integer('age');
            $table->string('partitaIva')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('date')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('attivita')->nullable();
        });

        DB::table('users')->insert([
            ['name' => 'Davide' , 'surname' => 'Ricci' , 'username' => 'DGDcomics official' , 'age' => '22' , 'partitaIva' => '14631260859' , 'phone_number' => '323456789' , 'email' => 'dgdComicsOfficial@dgdcomics.com', 'password' => Hash::make('dgdcomics'), 'attivita' => 'DGDcomics'],
            ['name' => 'Mario' , 'surname' => 'Rossi' , 'username' => 'MangaMania' , 'age' => '33' , 'partitaIva' => '66604080490' , 'phone_number' => '321654987' , 'email' => 'mario.rossi@gmail.com', 'password' => Hash::make('password3'), 'attivita' => 'MangaMania'],
        ]);

        DB::table('users')->insert([
            ['name' => 'Daniele' , 'surname' => 'Fossemò' , 'username' => 'DanieleF198' , 'age' => '22' , 'phone_number' => '3209104523' , 'email' => 'daniele.fossemo@outlook.it', 'password' => Hash::make('password')],
        ]);

        DB::table('users')->insert([
            ['name' => 'Gianluca' , 'surname' => 'Rea' , 'username' => 'gianrea' , 'age' => '22' , 'email' => 'reagianluca97@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'Admin' , 'surname' => 'Admin' , 'username' => 'admin' , 'age' => '50', 'email' => 'admin@dgdcomics.com', 'password' => Hash::make('admin')],
        ]);

        DB::table('users')->insert([
            ['name' => 'Aldo' , 'surname' => 'Baglio' , 'username' => 'AldoBaglio' , 'age' => '20' , 'phone_number' => '3209104525' , 'email' => 'Aldo.Baglio@outlook.it', 'password' => Hash::make('Sforza10')],
            ['name' => 'Giovanni' , 'surname' => 'Storti' , 'username' => 'Giovanni10' , 'age' => '21' , 'phone_number' => '3209104623' , 'email' => 'Giovanni.Storti@outlook.it', 'password' => Hash::make('Sforza11')],
            ['name' => 'Giacomo' , 'surname' => 'Poretti' , 'username' => 'Giacomo5' , 'age' => '23' , 'phone_number' => '3209104323' , 'email' => 'Giacomo.Poretti@outlook.it', 'password' => Hash::make('Gambapersa92')],
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
