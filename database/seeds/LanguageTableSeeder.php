<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($file = fopen(storage_path()."\\languages.txt", "r")){ 
            $count = 1;            
            while(!feof($file)) {
                $line = fgets($file);                
                $line = trim($line);                          
                $line= explode("\t",$line);
                // dd($line[0])                ;

                \DB::table('languages')->insert([
                    'id' => $count,
                    'language' => $line[0],
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]);

                $count ++;
            } 
        }
    }
}
