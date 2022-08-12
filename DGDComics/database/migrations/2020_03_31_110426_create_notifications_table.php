<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('notification_text');
            $table->boolean('state');
            $table->timestamp('date')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('notification')->default('#');
            $table->integer('idLink')->nullable();
        });

        DB::table('notifications')->insert([
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '1'],
            ['user_id' => '3' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '0' , 'notification' => 'orderDetail' , 'idLink' => '1'],
            ['user_id' => '3' , 'notification_text' => 'Ehy, un tuo fumetto è stato confermato' , 'state' => '0' , 'notification' => 'orderDetail' , 'idLink' => '1'],
            ['user_id' => '3' , 'notification_text' => 'Un tuo commento ha ricevuto una risposta' , 'state' => '0' , 'notification' => 'blogDetail' , 'idLink' => '2'],
            ['user_id' => '2' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '1'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '2'],
            ['user_id' => '3' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '0' , 'notification' => 'orderDetail' , 'idLink' => '2'],
            ['user_id' => '3' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '0' , 'notification' => 'orderDetail' , 'idLink' => '2'],
            ['user_id' => '3' , 'notification_text' => 'Ehy, un tuo fumetto è stato confermato' , 'state' => '0' , 'notification' => 'orderDetail' , 'idLink' => '2'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '3'],
            ['user_id' => '3' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '3'],
            ['user_id' => '3' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '3'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '4'],
            ['user_id' => '6' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '4'],
            ['user_id' => '6' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '4'],
            ['user_id' => '2' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '4'],
            ['user_id' => '6' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '4'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '5'],
            ['user_id' => '6' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '5'],
            ['user_id' => '6' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '5'],
            ['user_id' => '6' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '5'],
            ['user_id' => '6' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '5'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '6'],
            ['user_id' => '7' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '6'],
            ['user_id' => '7' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '6'],
            ['user_id' => '2' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '6'],
            ['user_id' => '7' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '6'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '7'],
            ['user_id' => '7' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '7'],
            ['user_id' => '7' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '7'],
            ['user_id' => '7' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '7'],
            ['user_id' => '7' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '7'],
            ['user_id' => '2' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '8'],
            ['user_id' => '8' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '8'],
            ['user_id' => '8' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '8'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '8'],
            ['user_id' => '8' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '8'],
            ['user_id' => '1' , 'notification_text' => 'un utente ha effettuato un ordine!' , 'state' => '1' , 'notification' => 'orderDetailVendor' , 'idLink' => '9'],
            ['user_id' => '8' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '9'],
            ['user_id' => '8' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '9'],
            ['user_id' => '8' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '9'],
            ['user_id' => '8' , 'notification_text' => 'Ehy, un tuo fumetto è stato spedito' , 'state' => '1' , 'notification' => 'orderDetail' , 'idLink' => '9'],

            ['user_id' => '8' , 'notification_text' => 'Un tuo commento ha ricevuto una risposta' , 'state' => '1' , 'notification' => 'blogDetail' , 'idLink' => '1'],
            ['user_id' => '6' , 'notification_text' => 'Un tuo commento ha ricevuto una risposta' , 'state' => '1' , 'notification' => 'blogDetail' , 'idLink' => '2'],
            ['user_id' => '7' , 'notification_text' => 'Un tuo commento ha ricevuto una risposta' , 'state' => '1' , 'notification' => 'blogDetail' , 'idLink' => '2'],
            ['user_id' => '6' , 'notification_text' => 'Un tuo commento ha ricevuto una risposta' , 'state' => '1' , 'notification' => 'blogDetail' , 'idLink' => '2'],
            ['user_id' => '7' , 'notification_text' => 'Un tuo commento ha ricevuto una risposta' , 'state' => '1' , 'notification' => 'blogDetail' , 'idLink' => '2'],
            ['user_id' => '8' , 'notification_text' => 'Un tuo commento ha ricevuto una risposta' , 'state' => '1' , 'notification' => 'blogDetail' , 'idLink' => '2'],

        ]);
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
