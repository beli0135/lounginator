<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Providers\RouteServiceProvider;
use App\Rules\InvitationCodeRule;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $invcode = $request->invcode;
        $request->validate([
            'name' => 'required|string|max:20|min:4',
            'username' => 'required|string|max:12|min:5|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'invcode' => ['required', new InvitationCodeRule($invcode)],
        ]);

        $invited_by = '';
        $envcode = env('CUSTOM_ADMIN_AUTH_CODE','');
        if ($envcode == $invcode) {
            $invited_by = 'ANNOUNCED';
        }

        $user = User::create([
            'name' => ucwords($request->name),
            'username' => strtolower($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'invited_by' => $invited_by,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $userProfile = Profile::create([
            'user_id' => $user->id,
        ]);

        DB::table('role_user')->insert(
            array(
                   'role_id' =>   1, 
                   'user_id' => $user->id,
            )
        );

        return redirect(RouteServiceProvider::HOME);
    }
}
