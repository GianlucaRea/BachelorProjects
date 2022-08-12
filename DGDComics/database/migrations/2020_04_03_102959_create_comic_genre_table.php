<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comic_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comic_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');

            $table->unique(['comic_id','genre_id']);

        });

        DB::table('comic_genre')->insert([
            ['comic_id' => '1' , 'genre_id' => '1'],
            ['comic_id' => '1' , 'genre_id' => '2'],
            ['comic_id' => '1' , 'genre_id' => '3'],
            ['comic_id' => '2' , 'genre_id' => '8'],
            ['comic_id' => '3' , 'genre_id' => '12'],
            ['comic_id' => '4' , 'genre_id' => '12'],
            ['comic_id' => '5' , 'genre_id' => '8'],
            ['comic_id' => '6' , 'genre_id' => '8'],
            ['comic_id' => '7' , 'genre_id' => '8'],
            ['comic_id' => '8' , 'genre_id' => '1'],
            ['comic_id' => '8' , 'genre_id' => '3'],
            ['comic_id' => '9' , 'genre_id' => '1'],
            ['comic_id' => '9' , 'genre_id' => '3'],
            ['comic_id' => '10' , 'genre_id' => '1'],
            ['comic_id' => '10' , 'genre_id' => '3'],
            ['comic_id' => '11' , 'genre_id' => '1'],
            ['comic_id' => '11' , 'genre_id' => '3'],
            ['comic_id' => '12' , 'genre_id' => '1'],
            ['comic_id' => '12' , 'genre_id' => '3'],
            ['comic_id' => '13' , 'genre_id' => '8'],
            ['comic_id' => '14' , 'genre_id' => '8'],
            ['comic_id' => '15' , 'genre_id' => '5'],
            ['comic_id' => '16' , 'genre_id' => '12'],
            ['comic_id' => '17' , 'genre_id' => '12'],
            ['comic_id' => '18' , 'genre_id' => '12'],
            ['comic_id' => '19' , 'genre_id' => '9'],
            ['comic_id' => '19' , 'genre_id' => '13'],
            ['comic_id' => '20' , 'genre_id' => '9'],
            ['comic_id' => '20' , 'genre_id' => '13'],
            ['comic_id' => '21' , 'genre_id' => '9'],
            ['comic_id' => '21' , 'genre_id' => '13'],
            ['comic_id' => '22' , 'genre_id' => '9'],
            ['comic_id' => '22' , 'genre_id' => '13'],
            ['comic_id' => '23' , 'genre_id' => '9'],
            ['comic_id' => '23' , 'genre_id' => '13'],
            ['comic_id' => '24' , 'genre_id' => '9'],
            ['comic_id' => '24' , 'genre_id' => '13'],
            ['comic_id' => '25' , 'genre_id' => '8'],
            ['comic_id' => '26' , 'genre_id' => '8'],
            ['comic_id' => '27' , 'genre_id' => '8'],
            ['comic_id' => '28' , 'genre_id' => '8'],
            ['comic_id' => '29' , 'genre_id' => '8'],
            ['comic_id' => '30' , 'genre_id' => '8'],
            ['comic_id' => '31' , 'genre_id' => '8'],
            ['comic_id' => '32' , 'genre_id' => '8'],
            ['comic_id' => '32' , 'genre_id' => '4'],
            ['comic_id' => '32' , 'genre_id' => '2'],
            ['comic_id' => '33' , 'genre_id' => '2'],
            ['comic_id' => '33' , 'genre_id' => '9'],
            ['comic_id' => '34' , 'genre_id' => '9'],
            ['comic_id' => '34' , 'genre_id' => '10'],
            ['comic_id' => '34' , 'genre_id' => '2'],
            ['comic_id' => '35' , 'genre_id' => '9'],
            ['comic_id' => '35' , 'genre_id' => '10'],
            ['comic_id' => '35' , 'genre_id' => '2'],
            ['comic_id' => '36' , 'genre_id' => '7'],
            ['comic_id' => '37' , 'genre_id' => '7'],
            ['comic_id' => '38' , 'genre_id' => '10'],
            ['comic_id' => '38' , 'genre_id' => '11'],
            ['comic_id' => '39' , 'genre_id' => '1'],
            ['comic_id' => '39' , 'genre_id' => '4'],
            ['comic_id' => '40' , 'genre_id' => '1'],
            ['comic_id' => '40' , 'genre_id' => '3'],
            ['comic_id' => '41' , 'genre_id' => '5'],
            ['comic_id' => '42' , 'genre_id' => '5'],
            ['comic_id' => '43' , 'genre_id' => '5'],
            ['comic_id' => '44' , 'genre_id' => '5'],
            ['comic_id' => '45' , 'genre_id' => '1'],
            ['comic_id' => '45' , 'genre_id' => '2'],
            ['comic_id' => '45' , 'genre_id' => '10'],
            ['comic_id' => '46' , 'genre_id' => '2'],
            ['comic_id' => '46' , 'genre_id' => '4'],
            ['comic_id' => '46' , 'genre_id' => '10'],
            ['comic_id' => '47' , 'genre_id' => '4'],
            ['comic_id' => '47' , 'genre_id' => '6'],
            ['comic_id' => '48' , 'genre_id' => '4'],
            ['comic_id' => '48' , 'genre_id' => '6'],
            ['comic_id' => '49' , 'genre_id' => '4'],
            ['comic_id' => '49' , 'genre_id' => '6'],
            ['comic_id' => '50' , 'genre_id' => '1'],
            ['comic_id' => '50' , 'genre_id' => '4'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comic_genre');
    }
}
