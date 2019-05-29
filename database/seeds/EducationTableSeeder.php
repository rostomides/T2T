<?php

use Illuminate\Database\Seeder;

class EducationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = Array("No education", "Primary school", "Secondary school", "College", 
        "Bachelor degree", "Master degree", "PhD", "Engineering","Doctor", "Other");

        $i = 0;
        foreach($stats as $stat){
            \DB::table('education')->insert([
                'id' => $i + 1,
                'education' => $stats[$i],
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }
    }
}
