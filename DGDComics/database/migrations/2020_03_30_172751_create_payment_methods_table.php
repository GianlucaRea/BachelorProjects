<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('payment_type');
            $table->boolean('favourite');
            $table->date('data_scadenza');
            $table->String('cardNumber')->unique();
            $table->string('intestatario');
            $table->String('CVV')->unique();

        });
        DB::table('payment_methods')->insert([
            ['user_id' => '3', 'payment_type' => 'FakePayment', 'favourite' => '1', 'data_scadenza'=>'2021-08-28', 'cardNumber'=>'1234123412341234', 'intestatario'=>'pinco', 'CVV'=>Hash::make('123')],
            ['user_id' => '3', 'payment_type' => 'FakePayment 2.0', 'favourite' => '0', 'data_scadenza'=>'2019-08-28', 'cardNumber'=>'1235123412341234', 'intestatario'=>'pallo', 'CVV'=>Hash::make('321')],
            ['user_id' => '3', 'payment_type' => 'FakePayment 3.0', 'favourite' => '0', 'data_scadenza'=>'2020-06-28', 'cardNumber'=>'1236123412341234', 'intestatario'=>'pallino', 'CVV'=>Hash::make('523')],
            ['user_id' => '4', 'payment_type' => 'FakePayment ', 'favourite' => '0', 'data_scadenza'=>'2020-06-28', 'cardNumber'=>'4326123412341234', 'intestatario'=>'gianluca', 'CVV'=>Hash::make('723')],
            ['user_id' => '6', 'payment_type' => 'Banca Unicredit', 'favourite' => '1', 'data_scadenza'=>'2022-09-28', 'cardNumber'=>'1234123412341567', 'intestatario'=>'Aldo Baglio', 'CVV'=>Hash::make('123')],
            ['user_id' => '7', 'payment_type' => 'Banca Unicredit', 'favourite' => '1', 'data_scadenza'=>'2021-12-12', 'cardNumber'=>'1234123412341765', 'intestatario'=>'Giovanni Storti', 'CVV'=>Hash::make('123')],
            ['user_id' => '8', 'payment_type' => 'Banca Unicredit', 'favourite' => '1', 'data_scadenza'=>'2023-08-21', 'cardNumber'=>'1234123412341897', 'intestatario'=>'Giacomo Poretti', 'CVV'=>Hash::make('123')],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }



}
