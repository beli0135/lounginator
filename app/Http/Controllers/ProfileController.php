<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Intervention\Image\Facades\Image;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function store(UpdateProfileRequest $request)
    {   
        //for all images
        //$newImageName =time().'-'.$request->input('name').'.'.$request->image->guessClientExtension();
        //for profile images just one filename ?
        
        $newImageName='';
        if ($request->image) {
            $newImageName = 'profile_' . auth()->user()->username . '.' . $request->image->guessClientExtension();
            
            $storagePath = "storage/users/" . auth()->user()->username.'/';
            $request->image->move(public_path($storagePath), $newImageName);
            $imgpathtostore = asset($storagePath).'/'.$newImageName;
        }
        
        $array = array(
            'bio' => $request->input('bio'),
            'url' => $request->input('url'),
            'location' => $request->input('location'),
            'birthday' => $request->input('birthday')
        );

        if ($newImageName != '') {
            $array['image'] = $imgpathtostore;
        }

        DB::table('profiles')->where('user_id',auth()->user()->id)->update($array);
        DB::table('users')->where('id',auth()->user()->id)->update(
            array(
            'name'=>$request->input('name'),
            )
        );

        //finally
        return redirect()->route('profile')->with('message','Profile saved successfully');
    }
}
