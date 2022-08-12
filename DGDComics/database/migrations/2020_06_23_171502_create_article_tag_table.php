<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();

            $table->unique(['article_id','tag_id']);
        });

        DB::table('article_tag')->insert([
            ['article_id' => '1','tag_id' => '5'],
            ['article_id' => '1','tag_id' => '13'],
            ['article_id' => '2','tag_id' => '8'],
            ['article_id' => '2','tag_id' => '14'],
            ['article_id' => '3','tag_id' => '5'],
            ['article_id' => '3','tag_id' => '13'],
            ['article_id' => '4','tag_id' => '7'],
            ['article_id' => '4','tag_id' => '14'],
            ['article_id' => '5','tag_id' => '6'],
            ['article_id' => '5','tag_id' => '14'],
            ['article_id' => '6','tag_id' => '8'],
            ['article_id' => '6','tag_id' => '10'],
            ['article_id' => '6','tag_id' => '13'],
            ['article_id' => '6','tag_id' => '14'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_tag');
    }
}
