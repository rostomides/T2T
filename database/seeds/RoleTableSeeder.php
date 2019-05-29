<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->insert([
        	'id' => 1,
        	'role' => 'Administrator',
        	'created_at' => NOW(),
        	'updated_at' => NOW()
        ]);
        \DB::table('roles')->insert([
        	'id' => 2,
        	'role' => 'Operator',
        	'created_at' => NOW(),
        	'updated_at' => NOW()
        ]);
        \DB::table('roles')->insert([
        	'id' => 3,
        	'role' => 'Client',
        	'created_at' => NOW(),
        	'updated_at' => NOW()
        ]);
    }
}
