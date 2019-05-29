<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \DB::table('users')->insert([
        	'id' => 1,
            'name' => 'Nora',
            'email' => 'tayeboon2tayebat@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
            'status_id' =>10,
            
        	'created_at' => NOW(),
        	'updated_at' => NOW()
        ]);
        

    }
}
