<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArticleImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_images', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->text('image_name');
        });

        DB::table('article_images')->insert([
            ['article_id' => '1' , 'image_name' => 'OnePieceBlog.jpg'],
            ['article_id' => '2' , 'image_name' => 'DylanDogBlog.jpg'],
            ['article_id' => '3' , 'image_name' => 'FMABlog.jpg'],
            ['article_id' => '4' , 'image_name' => 'supermanBlog.jpg'],
            ['article_id' => '5' , 'image_name' => 'ironmanBlog.jpg'],
            ['article_id' => '6' , 'image_name' => 'topolinoBlog.jpg'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
