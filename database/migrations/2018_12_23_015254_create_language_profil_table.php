<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageProfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_profil', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();

            $table->integer('language_id');
            $table->integer('profil_id');            
            $table->primary(['language_id','profil_id' ]);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_profil');
    }
}
