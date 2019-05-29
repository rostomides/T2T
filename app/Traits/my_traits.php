<?php

namespace App\Traits;

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
use App\Interview;
use App\Matching;
use App\Message;



trait my_traits
{
   
   
   
    // protected function update_seen_matched_me(){
        
    //     $matched_me = \app\Matching::where('user_2','=',auth()->user()->profile->id)->pluck('user_1')->toArray();
    //     $both_matched = \app\Matching::whereIn('user_2', $matched_me)
    //                             ->where('user_1', '=', auth()->user()->profile->id)->pluck('user_2')->toArray();

    //     $matched_me_clean = array_diff($matched_me, $both_matched);
    //     \DB::table('matchings')->where('user_2','=', auth()->user()->profile->id)
    //                         ->whereIn('user_1', $matched_me_clean)
    //                         ->update(['seen'=>1]);
        
    // }

    protected function how_many_matched_me_not_seen(){
        // Get the matching where seen == 0
        $matched_me = Matching::where('user_2','=',auth()->user()->profile->id)
                    ->where("seen", 0)
                    ->pluck('user_1')->toArray();
        $both_matched = Matching::whereIn('user_2', $matched_me)
                                ->where('user_1', '=', auth()->user()->profile->id)->pluck('user_2')->toArray();

        $matched_me_clean = array_diff($matched_me, $both_matched);
        
        return $matched_me_clean;
    }


    protected function how_many_both_matched_not_seen(){
        // Get the matching where seen == 0
        $matched_me = Matching::where('user_2','=',auth()->user()->profile->id)
                                ->where("seen", 0)
                                ->pluck('user_1')->toArray();

        $my_matches = Matching::where('user_1','=', auth()->user()->profile->id)->pluck('user_2')->toArray();
        
        $both_matched = array_intersect($matched_me, $my_matches);
        
        return $both_matched;
    }

    protected function unread_messages(){
        // Get users that sent me messages that I did read yet
        $messages = Message::where('user_2', auth()->user()->profile->id)
                            ->where("seen", 0)
                            ->distinct("user_1")
                            ->pluck("user_1")
                            ->toArray();
        
        return $messages;
    }


}


