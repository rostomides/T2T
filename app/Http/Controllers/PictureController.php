<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Picture;
use App\Profil;


class PictureController extends Controller
{
    public function add_picture(Request $request){

        // check how many pictures the user has already
        $n_picture = Picture::where("profil_id", auth()->user()->profile->id)->count();
        
        if($n_picture>5){
            return redirect()->route('get_profile', auth()->user()->profile->id)->with('error', 'You can upload a maximum of 5 pictures only!');
        }

        $request->validate([            
            'picture'=>'required|image|max:1999'
        ]);


        // Handle picture
        if($request->hasFile("picture")){
            $fileNameExt = $request->file("picture")->getClientOriginalName();
            
            // Get the name part of the file
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            
            // Get the extension part of the name
            $extension = $request->file("picture")->getClientOriginalExtension();
            
            // $fileNameToStore = $fileName."_".time().".". $extension;
            $fileNameToStore = "id_".auth()->user()->profile->id."_".time().".". $extension;
            
            // $path = $request->file("picture")->storeAs('/'. auth()->user()->id, $fileNameToStore, 'picture_uploads');
            $path = $request->file("picture")->storeAs('/',$fileNameToStore, 'picture_uploads');

        }else{
            $fileNameToStore = "no_image.png";
        }

        // Add the picture
        $picture = new Picture;
        $picture->profil_id = auth()->user()->profile->id;
        $picture->picture =  $fileNameToStore;
        $picture->is_main =  0;
        $picture->save();

        return redirect()->route('my_profile')->with('success', 'The picture has  been uploaded successfully!');


    }


    public function change_to_main_picture(Request $request){

        // Find the main picture
        $main_pict = Picture::where("profil_id", auth()->user()->profile->id)
                            ->where("is_main", 1)->update(["is_main"=> 0]);

        // Change the main picture
        $main_pict = Picture::where("profil_id", auth()->user()->profile->id)
                            ->where("id", $request['picture'])->update(["is_main"=> 1]);

        // // Change the main picture in the profile table
        // $profile = Profil::where('user_id', auth()->user()->id)->first();
        // $profile->main_picture_id = $request['picture'];
        // $profile->update();
        
        return redirect()->route('my_profile')->with('success', 'The main picture has been change sucessfully!');

    }

    public function delete_picture(Request $request){

        // Check if the picture is not the main picture
        $del_pict = Picture::where("profil_id", auth()->user()->profile->id)
                    ->where("id", $request['picture'])->first();
        
        if($del_pict->is_main){
            return redirect()->route('get_profile', auth()->user()->profile->id)->with('error', 'Operation not allowed!'); 
        }

        Storage::disk('picture_uploads')->delete($del_pict->picture);

        // Storage::disk('picture_uploads')->delete(auth()->user()->profile->id."/".$del_pict->picture);
        // Storage::delete('storage/pictures/'.$del_pict->picture);

        $del_pict->delete();

        return redirect()->route('my_profile')->with('success', 'The picture has been deleted successfully!'); 



    }

}
