<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicBoughtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comic_boughts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comic_id')->cascadeOnDelete();
            $table->String('name');
            $table->String('vendor');
            $table->integer('quantity');
            $table->double('price');
            $table->String('state');
            $table->timestamp('date')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::table('comic_boughts')->insert([
            ['comic_id' => '26' , 'name' => 'Spider-Man 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '4' , 'price' => '4.51' , 'state' => 'spedito'],
            ['comic_id' => '28' , 'name' => 'Batman: Io Sono Gotham' , 'vendor' => 'DGDcomics official' , 'quantity' => '3' , 'price' => '4.40' , 'state' => 'confermato'],
            ['comic_id' => '34' , 'name' => 'Tokyo Ghoul 1' , 'vendor' => 'MangaMania' , 'quantity' => '3' , 'price' => '4.93' , 'state' => 'ordinato'],
            ['comic_id' => '13' , 'name' => 'Hulk 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '4.5' , 'state' => 'spedito'],
            ['comic_id' => '14' , 'name' => 'Thor 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '2' , 'price' => '4.5' , 'state' => 'spedito'],
            ['comic_id' => '2' , 'name' => 'Io sono Iron Man' , 'vendor' => 'DGDcomics official' , 'quantity' => '3' , 'price' => '4.05' , 'state' => 'confermato'],
            ['comic_id' => '25' , 'name' => 'Superior Iron Man' , 'vendor' => 'DGDcomics official' , 'quantity' => '2' , 'price' => '5' , 'state' => 'ordinato'],
            ['comic_id' => '3' , 'name' => 'Topolino 3219' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '5.81' , 'state' => 'spedito'],
            ['comic_id' => '16' , 'name' => 'Topolino 3286' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '4.5' , 'state' => 'spedito'],
            ['comic_id' => '26' , 'name' => 'Spider-Man 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '4' , 'price' => '4.51' , 'state' => 'spedito'],
            ['comic_id' => '28' , 'name' => 'Batman: Io Sono Gotham' , 'vendor' => 'DGDcomics official' , 'quantity' => '3' , 'price' => '4.40' , 'state' => 'spedito'],
            ['comic_id' => '34' , 'name' => 'Tokyo Ghoul 1' , 'vendor' => 'MangaMania' , 'quantity' => '3' , 'price' => '4.93' , 'state' => 'spedito'],
            ['comic_id' => '13' , 'name' => 'Hulk 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '4.5' , 'state' => 'spedito'],
            ['comic_id' => '14' , 'name' => 'Thor 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '2' , 'price' => '4.5' , 'state' => 'spedito'],
            ['comic_id' => '2' , 'name' => 'Io sono Iron Man' , 'vendor' => 'DGDcomics official' , 'quantity' => '3' , 'price' => '4.05' , 'state' => 'spedito'],
            ['comic_id' => '25' , 'name' => 'Superior Iron Man' , 'vendor' => 'DGDcomics official' , 'quantity' => '2' , 'price' => '5' , 'state' => 'spedito'],
            ['comic_id' => '26' , 'name' => 'Spider-Man 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '4' , 'price' => '4.51' , 'state' => 'spedito'],
            ['comic_id' => '28' , 'name' => 'Batman: Io Sono Gotham' , 'vendor' => 'DGDcomics official' , 'quantity' => '3' , 'price' => '4.40' , 'state' => 'spedito'],
            ['comic_id' => '34' , 'name' => 'Tokyo Ghoul 1' , 'vendor' => 'MangaMania' , 'quantity' => '3' , 'price' => '4.93' , 'state' => 'spedito'],
            ['comic_id' => '13' , 'name' => 'Hulk 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '4.5' , 'state' => 'spedito'],
            ['comic_id' => '14' , 'name' => 'Thor 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '2' , 'price' => '4.5' , 'state' => 'spedito'],
            ['comic_id' => '2' , 'name' => 'Io sono Iron Man' , 'vendor' => 'DGDcomics official' , 'quantity' => '3' , 'price' => '4.05' , 'state' => 'spedito'],
            ['comic_id' => '25' , 'name' => 'Superior Iron Man' , 'vendor' => 'DGDcomics official' , 'quantity' => '2' , 'price' => '5' , 'state' => 'spedito'],
            ['comic_id' => '1' , 'name' => 'FMA 1' , 'vendor' => 'MangaMania' , 'quantity' => '1' , 'price' => '4.05' , 'state' => 'spedito'],
            ['comic_id' => '35' , 'name' => 'Tokyo Ghoul 2' , 'vendor' => 'MangaMania' , 'quantity' => '1' , 'price' => '4.93' , 'state' => 'spedito'],
            ['comic_id' => '30' , 'name' => 'Lanterna Verde' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '5.94' , 'state' => 'spedito'],
            ['comic_id' => '5' , 'name' => 'Superman 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '6.83' , 'state' => 'spedito'],
            ['comic_id' => '6' , 'name' => 'Batman 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '6.83' , 'state' => 'spedito'],
            ['comic_id' => '7' , 'name' => 'Flash 1' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '6.83' , 'state' => 'spedito'],
            ['comic_id' => '45' , 'name' => 'V per Vendetta' , 'vendor' => 'DGDcomics official' , 'quantity' => '1' , 'price' => '13.50' , 'state' => 'spedito'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comic_boughts');
    }
}
