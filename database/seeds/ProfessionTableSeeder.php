<?php

use Illuminate\Database\Seeder;

class ProfessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($file = fopen(storage_path()."\\occupations.csv", "r")){ 
            $count = 1;            
            while(!feof($file)) {
                $line = fgets($file);                
                $line = trim($line);                          
                $line= explode("\t",$line);
                // dd($line[0])                ;

                \DB::table('professions')->insert([
                    'id' => $count,
                    'profession' => $line[0],
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]);

                $count ++;
            } 
        }
    }
}
