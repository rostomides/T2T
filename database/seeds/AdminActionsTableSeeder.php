<?php

use Illuminate\Database\Seeder;

class AdminActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = Array("Created free account for", //1
                    'Changed status to ACTIVE', //2
                    'Changed status to BANNED', //3
                    'Changed status to EXPIRED',//4
                    'Removed account of',//5
                    'Changed status to Waiting for interview',//6
                    'Confirmed Report',//7
                    'Created a new Operator',//8
                    'Created a new Super User',//9
                    'Visited the account of', //10
                    'Signed in',//11
                    'Signed OUT', //12


                );

        $i = 0;
        foreach($stats as $stat){
            \DB::table('admin_actions')->insert([
                'id' => $i + 1,
                'action' => $stats[$i],
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);

            $i++;

        }
    }
}
