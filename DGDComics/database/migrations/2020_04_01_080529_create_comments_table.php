<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->text('answer');
            $table->unsignedBigInteger('parent_comment')->default(0);
            $table->timestamp('date')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
        DB::table('comments')->insert([
            ['user_id' => '6', 'article_id' => '2', 'answer' => 'Dylan Dog è il mio fumetto preferito, ha uno stile unico. Ogni volta che lo leggo mi immergo dentro al fumetto', 'parent_comment' => '0'],
            ['user_id' => '7', 'article_id' => '2', 'answer' => 'Stessa cosa per me , ne ho letti almeno 200. Ogni volta mi emoziono sempre.', 'parent_comment' => '1'],
            ['user_id' => '8', 'article_id' => '2', 'answer' => 'Io ho la collezione completa dal 1994 al 2000. Gli anni d\'oro del grande Sclavi', 'parent_comment' => '1'],
            ['user_id' => '6', 'article_id' => '2', 'answer' => 'Pensa un po io ho la collezione dal 96 al 98', 'parent_comment' => '1'],
            ['user_id' => '3', 'article_id' => '2', 'answer' => 'Sclavi è stato unico nel genere Horror... le sue storie sono pazzesche!', 'parent_comment' => '0'],
            ['user_id' => '7', 'article_id' => '2', 'answer' => 'Concordo pienamente, personalmente l\'ho sempre definito il padre di questo genere in Italia', 'parent_comment' => '5'],
            ['user_id' => '8', 'article_id' => '1', 'answer' => 'Sinceramente secondo me One piece è fin troppo sopravvalutato', 'parent_comment' => '0'],
            ['user_id' => '6', 'article_id' => '1', 'answer' => 'Beh, non mi ritrovo d\'accordo... e con me molti altri visto che è il più venduto al mondo!', 'parent_comment' => '7'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
