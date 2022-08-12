<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->text('service_description');
        });

        DB::table('services')->insert([
            ['service_description' => 'servizi di base: gestire la propria area personale, usufruire dei servizi base messi a disposizione dal sito, quali comprare fumetti, recensirli, usare il blog, eccetra'],
            ['service_description' => 'servizi venditore: gli stessi servizi offerti agli user con in aggiunta la possibilità di vendere prodotti sul nostro sito e di gestirli sotto il nome della attività che rappresentano'],
            ['service_description' => 'servizi amministratore: gestire e moderare gli utenti, controllare che i venditori seguano il regolamento, gestire tutti i prodotti messi in vendita'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
