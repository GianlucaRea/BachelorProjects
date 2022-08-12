<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicBoughtOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comic_bought_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comic_bought_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
        });
        DB::table('comic_bought_order')->insert([
            ['comic_bought_id' => '1', 'order_id' => '1'],
            ['comic_bought_id' => '2', 'order_id' => '1'],
            ['comic_bought_id' => '3', 'order_id' => '1'],
            ['comic_bought_id' => '4', 'order_id' => '2'],
            ['comic_bought_id' => '5', 'order_id' => '2'],
            ['comic_bought_id' => '6', 'order_id' => '2'],
            ['comic_bought_id' => '7', 'order_id' => '2'],
            ['comic_bought_id' => '8', 'order_id' => '3'],
            ['comic_bought_id' => '9', 'order_id' => '3'],
            ['comic_bought_id' => '10', 'order_id' => '4'],
            ['comic_bought_id' => '11', 'order_id' => '4'],
            ['comic_bought_id' => '12', 'order_id' => '4'],
            ['comic_bought_id' => '13', 'order_id' => '5'],
            ['comic_bought_id' => '14', 'order_id' => '5'],
            ['comic_bought_id' => '15', 'order_id' => '5'],
            ['comic_bought_id' => '16', 'order_id' => '5'],
            ['comic_bought_id' => '17', 'order_id' => '6'],
            ['comic_bought_id' => '18', 'order_id' => '6'],
            ['comic_bought_id' => '19', 'order_id' => '6'],
            ['comic_bought_id' => '20', 'order_id' => '7'],
            ['comic_bought_id' => '21', 'order_id' => '7'],
            ['comic_bought_id' => '22', 'order_id' => '7'],
            ['comic_bought_id' => '23', 'order_id' => '7'],
            ['comic_bought_id' => '24', 'order_id' => '8'],
            ['comic_bought_id' => '25', 'order_id' => '8'],
            ['comic_bought_id' => '26', 'order_id' => '8'],
            ['comic_bought_id' => '27', 'order_id' => '9'],
            ['comic_bought_id' => '28', 'order_id' => '9'],
            ['comic_bought_id' => '29', 'order_id' => '9'],
            ['comic_bought_id' => '30', 'order_id' => '9'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comic_bought_order');
    }
}
