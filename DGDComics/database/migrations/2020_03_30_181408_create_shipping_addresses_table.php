<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('via');
            $table->integer('civico');
            $table->string('città');
            $table->integer('post_code');
            $table->text('other_info')->nullable();
            $table->boolean('favourite');
            $table->string('sede')->default(false);
        });
        DB::table('shipping_addresses')->insert([
            ['user_id' => '3', 'via' => 'le mani dal naso', 'civico' => '123', 'città' => 'Pescara', 'post_code' => '65123', 'other_info' => 'nothing', 'favourite' => '1'],
            ['user_id' => '3', 'via' => 'le mani dal nasino', 'civico' => '124', 'città' => 'Roma', 'post_code' => '65125', 'other_info' => 'test', 'favourite' => '0'],
            ['user_id' => '5', 'via' => 'a caso', 'civico' => '32', 'città' => 'Arpino', 'post_code' => '03033', 'other_info' => 'Mi piace', 'favourite' => '0'],
            ['user_id' => '6', 'via' => 'Roma', 'civico' => '12', 'città' => 'Arpino', 'post_code' => '03033','other_info' => 'nothing' ,'favourite' => '1'],
            ['user_id' => '7', 'via' => 'Garibaldi', 'civico' => '35', 'città' => 'Arpino', 'post_code' => '03033','other_info' => 'nothing','favourite' => '1'],
            ['user_id' => '8', 'via' => 'De Gasperi', 'civico' => '21', 'città' => 'Arpino', 'post_code' => '03033','other_info' => 'nothing','favourite' => '1'],
        ]);

        DB::table('shipping_addresses')->insert([
            ['user_id' => '1', 'via' => 'via Luigi Gordigiani', 'civico' => '32', 'città' => 'Firenze', 'post_code' => '50127', 'other_info' => 'numero civico 32 Nord', 'favourite' => '1', 'sede' => '1'],
            ['user_id' => '2', 'via' => 'via nazionale adriatica nord', 'civico' => '348', 'città' => 'Pescara', 'post_code' => '65123', 'other_info' => 'Official store DGDcomics', 'favourite' => '1', 'sede' => '1']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_addresses');
    }
}
