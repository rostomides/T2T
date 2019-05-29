<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        
        $this->call(BodyTypeTableSeeder::class);
        $this->call(ChildrenWithYouTableSeeder::class);
        $this->call(CountryGrewUpTableSeeder::class);
        $this->call(DressTableSeeder::class);
        $this->call(EducationTableSeeder::class);
        $this->call(EthnicityTableSeeder::class);
        $this->call(HobbiesTableSeeder::class);
        $this->call(HowManyChildrenTableSeeder::class);
        $this->call(LanguageTableSeeder::class);        
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(ProfessionTableSeeder::class);
        $this->call(RoleTableSeeder::class);        
        $this->call(SextableSeeder::class);
        $this->call(StatusInCanadaTableSeeder::class);
        $this->call(StatustableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(AdminActionsTableSeeder::class);

        // $this->call(SeedWholeDatabaseSeeder::class);
        
        $this->call(LocationSeederTable::class);
        
       
        
    }




    // php artisan db:seed --class=ArticleTableSeeder
}
