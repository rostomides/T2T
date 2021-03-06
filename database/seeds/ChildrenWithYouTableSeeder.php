<?php

use Illuminate\Database\Seeder;

class ChildrenWithYouTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $stats = Array("None","1", "2", "3", "More than 3");

        $i = 0;
        foreach($stats as $stat){
            \DB::table('children_with_yous')->insert([
                'id' => $i + 1,
                'number_of_children_with_you' => $stats[$i],
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }




    }
}
