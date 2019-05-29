<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHobbyProfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobby_profil', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();

            $table->integer('hobby_id');
            $table->integer('profil_id');            
            $table->primary(['hobby_id','profil_id' ]);




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobby_profil');
    }
}
