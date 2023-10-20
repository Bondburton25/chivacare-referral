<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Socialite;
use Auth;
use Gate;
use Exception;
use App\Models\{
    AuthProvider,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectToLine() {
        return Socialite::driver('line')->redirect();
    }

    public function handleLineCallback()
    {
        try {
            $user = Socialite::driver('line')->user();
            $findUser = AuthProvider::where('provider', 'line')->where('provider_id', $user->id)->first();
            if ($findUser) {
                $user = User::find($findUser->user_id);
                Auth::login($user);
                return redirect('/home');
            } else {
                return redirect('/register');
            }
        }
        catch(Exception $error) {
            Log::error($error->getMessage());
            return redirect()->intended();
        }
    }
}
