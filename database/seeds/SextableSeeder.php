<?php

use Illuminate\Database\Seeder;

class SextableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sexes')->insert([
        	'id' => 1,
        	'sex' => 'Male',
        	'created_at' => NOW(),
        	'updated_at' => NOW()
        ]);
        \DB::table('sexes')->insert([
        	'id' => 2,
        	'sex' => 'Female',
        	'created_at' => NOW(),
        	'updated_at' => NOW()
        ]);
    }
}
