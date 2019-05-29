<?php

use Illuminate\Database\Seeder;

class StatusInCanadaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = Array("Canadian Citizen", "Permanent Resident", "International Student", "Refugee");

        $i = 0;
        foreach($stats as $stat){
            \DB::table('status_in_canadas')->insert([
                'id' => $i + 1,
                'status_in_canada' => $stats[$i],
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }
    }
}
