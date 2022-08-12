<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared('
            CREATE TRIGGER triggerPuntiRecensione AFTER INSERT ON `reviews` FOR EACH ROW
                BEGIN
                    UPDATE users SET points = points + NEW.stars_number WHERE id = (select documents.id_user_document from documents WHERE id = NEW.id_document_reviewed);
                END'
            );

            //        DB::table('users')->where('id','id_user_document')->increment('points' , 5 );
        DB::unprepared('
            CREATE TRIGGER triggerPuntiDocumento AFTER INSERT ON `documents` FOR EACH ROW
                BEGIN
                    UPDATE users SET points = points + 5 WHERE id = (select documents.id_user_document from documents WHERE id = NEW.id);
                END'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger');
    }
}
