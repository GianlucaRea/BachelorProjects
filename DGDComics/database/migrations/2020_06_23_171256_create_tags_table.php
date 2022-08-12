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
            $table->id();
            $table->string('tag_name')->unique();
        });

        DB::table('tags')->insert([
            ['tag_name' => 'Novità'],
            ['tag_name' => 'Illustrazioni'],
            ['tag_name' => 'Digital Art'],
            ['tag_name' => 'Fan Art'],
            ['tag_name' => 'Manga'],
            ['tag_name' => 'Marvel'],
            ['tag_name' => 'DC'],
            ['tag_name' => 'Italiano'],
            ['tag_name' => 'Cosplay'],
            ['tag_name' => 'Humor'],
            ['tag_name' => 'Comiccon'],
            ['tag_name' => 'Design'],
            ['tag_name' => 'Animation'],
            ['tag_name' => 'Original Character']
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
