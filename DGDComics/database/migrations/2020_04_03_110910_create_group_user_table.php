<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });

        DB::table('group_user')->insert([
            ['group_id' => '2' , 'user_id' => '1'],
            ['group_id' => '2' , 'user_id' => '2'],
            ['group_id' => '1' , 'user_id' => '3'],
            ['group_id' => '3' , 'user_id' => '4'],
            ['group_id' => '3' , 'user_id' => '5'],
            ['group_id' => '1' , 'user_id' => '6'],
            ['group_id' => '1' , 'user_id' => '7'],
            ['group_id' => '1' , 'user_id' => '8'],
        ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
    }
}
