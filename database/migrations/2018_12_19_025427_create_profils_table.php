<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer("user_id")->unsigned();
            // $table->integer("main_picture_id")->unsigned();
            $table->text("phone");
            $table->date("birthday");
            $table->integer("sex_id")->unsigned();
            $table->integer("statusincanada_id")->unsigned(); 
            $table->integer("relocate")->unsigned();            
            $table->integer("haschildren")->unsigned();
            // $table->float("height")->unsigned();
            $table->string("height");
            $table->string("volunteering")->nullable();
            $table->integer("location_id")->unsigned();     
            $table->integer("maritalstatus_id")->unsigned(); 
            $table->integer("howmanychildren_id")->unsigned(); 
            $table->integer("childrenwithyou_id")->unsigned();
            $table->integer("education_id")->unsigned();
            $table->integer("bodytype_id")->unsigned();
            $table->integer("dress_id")->unsigned();
            $table->integer("profession_id")->unsigned();
            $table->integer("ethnicity_id")->unsigned();
            $table->integer("countrygrewup_id")->unsigned();

            $table->date("membership_start");
            $table->date("membership_end")->nullable();
            
                     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profils');
    }
}
