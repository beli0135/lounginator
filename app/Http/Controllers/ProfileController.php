<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Intervention\Image\Facades\Image;
use App\Models\User;

class ProfileController extends Controller
{
    public function store(UpdateProfileRequest $request)
    {
        //$user
        //$this->authorize('update', $user->profile);
        //update user data
        auth()->user()->update($request->only('name'));

        //proceed with profile update


        //finally
        return redirect()->route('profile')->with('message','Profile saved successfully');
    }
}
