<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name_author');
        });
        DB::table('authors')->insert([
            ['name_author' => 'Hiromu Arakawa' ],
            ['name_author' => 'Eiichiro Oda'],
            ['name_author' => 'Stan Lee'],
            ['name_author' => 'Walt Disney'],
            ['name_author' => 'Malcolm Wheeler'],
            ['name_author' => 'Michele Rech'],
            ['name_author' => 'Robert Kirkman'],
            ['name_author' => 'One'],
            ['name_author' => 'Hitoshi Iwaaki'],
            ['name_author' => 'Sui Ishida'],
            ['name_author' => 'Natsume Ono'],
            ['name_author' => 'Riyoko Ikeda'],
            ['name_author' => 'Akimi Yoshida'],
            ['name_author' => 'Leo Ortolani'],
            ['name_author' => 'Mirka Andolfo'],
            ['name_author' => 'Mattia Labadessa'],
            ['name_author' => 'Alan Moore'],
            ['name_author' => 'James O\'Barr'],
            ['name_author' => 'Gianluigi Bonelli'],
            ['name_author' => 'Toni Bruno'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
