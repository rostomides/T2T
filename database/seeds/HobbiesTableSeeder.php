<?php

use Illuminate\Database\Seeder;

class HobbiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($file = fopen(storage_path()."\\Hobbies_interests.txt", "r")){ 
            $count = 1;            
            while(!feof($file)) {
                $line = fgets($file);                
                $line = trim($line);                          
                $line= explode("\t",$line);
                // dd($line[0])                ;

                \DB::table('hobbies')->insert([
                    'id' => $count,
                    'hobby' => $line[0],
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]);

                $count ++;
            } 
        }
    }
}
