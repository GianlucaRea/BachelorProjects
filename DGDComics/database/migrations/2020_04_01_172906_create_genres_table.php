<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name_genre')->unique();
        });

        DB::table('genres')->insert([
            ['name_genre' => 'Avventura'],
            ['name_genre' => 'Fantascienza'],
            ['name_genre' => 'Fantasy'],
            ['name_genre' => 'Azione'],
            ['name_genre' => 'Umoristico'],
            ['name_genre' => 'Western'],
            ['name_genre' => 'Alternativo'],
            ['name_genre' => 'Supereroi'],
            ['name_genre' => 'Horror'],
            ['name_genre' => 'Thriller'],
            ['name_genre' => 'Giallo'],
            ['name_genre' => 'Disney'],
            ['name_genre' => 'Post Apocalittico']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genres');
    }
}
