<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('service_id')->constrained();
        });

        DB::table('group_service')->insert([
            ['group_id' => '1', 'service_id' => '1'], //gruppo user servizi user
            ['group_id' => '2', 'service_id' => '1'], //gruppo venditori servizi user (sarebbe bello se quando fa operazioni da user semplice possa farli col nome da user e non dell'azienda, o ancora meglio che possa decidere (esempio, recensione).
            ['group_id' => '2', 'service_id' => '2'], //gruppo venditori servizi venditori
            ['group_id' => '3', 'service_id' => '3'], //gruppo admin servizi admin
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_service');
    }
}
