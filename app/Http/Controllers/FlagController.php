<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flag;
use App\Profil;

class FlagController extends Controller
{


    // Flagging is not restricted to matched persons ie if a user is using bad language in his profile or a non descent picture
    public function flag(Request $request){               

        $request->validate([
            'report_description' => 'required',
            'current_user_id'=>'required|integer'       
        ])  ;      
        
        if(auth()->user()->profile->id != $request['current_user_id']){
            $flag = new Flag;
            $flag->flagging = auth()->user()->profile->id;
            $flag->flagged = $request['current_user_id'];
            $flag->description = $request['report_description'];
            $flag->admin_check = 0; //As it is created the admin didn't checked it 
            $flag->save();

            $flagging_user = Profil::find(auth()->user()->profile->id)->user->name;
            $flagged_user = Profil::find($request['current_user_id'])->user->name;

            $title =  "Alert, a user has been flagged.";
            $content = $request['report_description'];
            \Mail::send('mail.flagging', ['title' => $title, 'flagging_user'=>$flagging_user, 
            'flagged_user'=>$flagged_user,
            'content' => $content], function ($message) use($title)
            {
                $message->from('me@gmail.com', 'Tayeboon2tayebat admin');
                $message->subject('Tayeboon2tayebat: '.$title);
                $message->to('tayeboon2tayebat@gmail.com'); 
            });

            return redirect()->back()->with('success', 'Report sent successfully');
        }
        return redirect()->back()->with('success', 'Unauthorized action!');
        
    }


    // Unflag function
    public function unflag(Request $request){
        $request->validate([            
            'current_user_id'=>'required|integer'       
        ])  ;

        if(auth()->user()->profile->id != $request['current_user_id']){
            $flag = Flag::where('flagging', auth()->user()->profile->id)
                        ->where('flagged', $request['current_user_id'])->first();

            $flag->delete();
            return redirect()->back()->with('success', 'Report removed successfully');
        }
        return redirect()->back()->with('success', 'Unauthorized action!');
    }
    
}
