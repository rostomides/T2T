<?php

use Illuminate\Database\Seeder;

class StatustableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()     
    {

        $stats = Array("Regitered", "Waiting for an interview", "Active", "Not active","Banned");

        $i = 1;
        foreach($stats as $stat){
            \DB::table('statuses')->insert([
                'id' => $i,
                'status' => $stat,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }

        \DB::table('statuses')->insert([
            'id' => 10,
            'status' => 'Active admin',
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);

        \DB::table('statuses')->insert([
            'id' => 11,
            'status' => 'Non active admin',
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);
    }
}
