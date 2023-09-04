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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToLine() {
        return Socialite::driver('line')->redirect();
    }

    public function handleLineCallback()
    {
        try {
            $user     = Socialite::driver('line')->user();
            $findUser = AuthProvider::where('provider', 'line')->where('provider_id', $user->id)->first();
            if ($findUser) {
                $user = User::find($findUser->user_id);
                Auth::login($user);
                return redirect('/home');
            } else {
                $newUser             = new User;
                $newUser->name       = $user->name;
                $newUser->first_name = $user->name;
                $newUser->avatar     = $user->avatar;
                $newUser->role       = 'general_user';
                $newUser->save();
                AuthProvider::create(['user_id' => $newUser->id, 'provider_id' => $user->id]);
                Auth::login($newUser);
                // Send message to LINE
                $message["type"] = "text";
                $message["text"] = __('You have already registered');
                $line_msg["messages"][0] = $message;
                $line_msg["to"] = $user->id;
                $this->pushMessage($line_msg,'push');

                // Sending Line Notify
                // $messageToNotify = $user->name .' '.__('has registered user').'';
                // $this->sendLineNotify($messageToNotify);
                return redirect('/home');
                // return redirect()->intended();
            }
        }

        catch(Exception $error) {
            Log::error($error->getMessage());
            return redirect()->intended();
        }
    }
}
