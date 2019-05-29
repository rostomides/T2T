<?php

use Illuminate\Database\Seeder;

class BodyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = Array("Skinny","Athletic", "Normal", "Few extra pounds");

        $i = 0;
        foreach($stats as $stat){
            \DB::table('body_types')->insert([
                'id' => $i + 1,
                'body_type' => $stats[$i],
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }
    }
}
