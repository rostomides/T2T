<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Status;
use App\Sex;
use App\Profil;
use App\StatusInCanada;
use App\Location;
use App\MaritalStatus;
use App\HowManyChildren;
use App\ChildrenWithYou;
use App\Education;
use App\BodyType;
use App\Dress;
use App\Profession;
use App\SelfDescription;
use App\LookingFor;
use App\Ethnicity;
use App\CountryGrewUp;
use App\Hobby;
use App\Language;
use App\Picture;

class SeedWholeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        

        $number_to_generate = 600;
        $i=1;
        
        while($i<= $number_to_generate){
        
            $faker = Faker::create();

            // Create dates of subscription and dates of end
            $date_start = date(date_format($faker->dateTimeBetween($startDate = '-3 years', $endDate = '2019-12-31', $timezone = null), "Y-m-d"));
           
            $date = strtotime($date_start);
            

            $date_end = strtotime('+ 1 year', $date);
            $date_end = date("Y-m-d", $date_end);

            
            // Create user
           
            $gender = $faker->randomElements(['male', 'female']);   
            $sex ="";
            if($gender[0] == 'male'){
                $sex = 1;
            }else{
                $sex = 2;
            }
            
            $user = new User;
            $user->name = $faker->firstName($gender);
            $user->email= $faker->email;
            $user->password= Hash::make("12345678");
            $user->role_id= 3; //correspond to customer
            if(strtotime($date_end)< strtotime(date("Y-m-d H:i:s"))){
                $user->status_id= 4;// corresponds to the status of expired
            }else{
                $user->status_id= random_int(1,3);// corresponds to the status of registerd
            }
            
            $user->save(); 

            // Create profile  
            $profil = new Profil;
            $s =  random_int(1,50);
            // $profil->picture = "cat.$s.jpg";
            $profil->id = $user->id;
            $profil->user_id = $user->id;
            $profil->birthday = $faker->date($format = 'Y-m-d', $max = 'now');
            $profil->sex_id = $sex;  
            $h_feet= random_int(4,6);  
            $h_inch= random_int(0,11);       
            $profil->height = $h_feet.'.'.$h_inch;
            $profil->relocate = random_int(1,2);
            $profil->haschildren = random_int(0,1);
            if($profil->haschildren == 1){
                $profil->howmanychildren_id = 1;
                $profil->childrenwithyou_id =1;
            }else{
                $profil->howmanychildren_id = random_int(2,4);
                $profil->childrenwithyou_id = random_int(2, $profil->howmanychildren_id);
            }
            
            $profil->volunteering = random_int(0,1);
            $profil->statusincanada_id = random_int(1,3);
            $profil->location_id = random_int(1,20);;
            $profil->maritalstatus_id = random_int(1,3);;
            
            $profil->education_id = random_int(1,6);;
            $profil->bodytype_id = random_int(1,3);;
            $profil->dress_id = random_int(1,3);;
            $profil->profession_id = random_int(1,100);
            $profil->phone = $faker->e164PhoneNumber;
            $profil->ethnicity_id = random_int(1,100);
            $profil->countrygrewup_id = random_int(1,100);

            

            $profil->membership_start = $date_start;
            $profil->membership_end =  $date_end;
            $profil->save();


            // create pictures
            $random_pict =  random_int(1,5);
            for($p=1;$p<=$random_pict; $p++){
                $s =  random_int(1,50);
                // $profil->picture = "cat.$s.jpg";

                // Add the picture
                $picture = new Picture;
                $picture->profil_id = $profil->id;
                $picture->picture =  "cat.$s.jpg";
                if($p == 1){
                    $picture->is_main =  1;
                }else{
                    $picture->is_main =  0;
                }
                
                $picture->save();

            }
            



            // Add description
            $description = new SelfDescription;
            $description->profil_id  = $profil->id;
            $description->description  = $faker->paragraphs($nb = 5, $asText = true) ;
            $description->save();
            // Add What you are looking for
            $lookingfor =  new lookingFor;
            $lookingfor->profil_id  = $profil->id;
            $lookingfor->what_want  = $faker->paragraphs($nb = 5, $asText = true) ;
            $lookingfor->save();
            // Add the hobbies and the Languages
            $values = array();
            for ($s=0; $s < 5; $s++) {            
            // get a random digit, but always a new one, to avoid duplicates
                $values []= $faker->unique()->numberBetween($min = 1, $max = 50);
            }
            $profil->hobbies()->sync($values, true);
            $profil->languages()->sync($values, true);

            $i++;
            if($i>$number_to_generate){
                break;
            }

        }     

        
    }
}
