<?php

use Illuminate\Database\Seeder;

class DressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $stats = Array("Not Applicable","Niqab", "Hijab", "No hijab");

        $i = 0;
        foreach($stats as $stat){
            \DB::table('dresses')->insert([
                'id' => $i + 1,
                'dress' => $stats[$i],
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }


    }
}
