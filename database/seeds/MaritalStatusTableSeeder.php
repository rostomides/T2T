<?php

use Illuminate\Database\Seeder;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = Array("Never married", "Divorced", "Widowed", "Other");

        $i = 0;
        foreach($stats as $stat){
            \DB::table('marital_statuses')->insert([
                'id' => $i + 1,
                'marital_status' => $stats[$i],
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }
    }
}
