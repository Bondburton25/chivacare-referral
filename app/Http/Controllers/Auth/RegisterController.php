<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\{
    AuthProvider,
    User
};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function registerEmployees()
    {
        return view('auth.register-employees');
    }

    public function registerLine(Request $request): RedirectResponse
    {
        // dd($request->role);
        $validatedData = $request->validate([
            'provider_id'  => 'required|unique:auth_providers',
            'phone_number' => 'required|unique:users',
            'first_name'   => 'required',
            'last_name'    => 'required',
            'name'         => 'required',
            'avatar'       => 'required',
            'role'         => 'required',
            // 'occupation'   => 'required',
            // 'affiliation'  => 'required',
        ]);

        $user = User::create($validatedData);

        // Create authentication provider
        AuthProvider::create(['user_id' => $user->id,'provider_id' => $request->provider_id]);

        // Send message to LINE
        $message["type"] = "text";
        $message["text"] = __('You have successfully registered');
        $lineMessage["messages"][0] = $message;
        $lineMessage["to"]          = $request->provider_id;
        $this->pushMessage($lineMessage,'push');

        // Send message to LINE Notify
        $messageToNotify = $user->name .' '.__('has registered as a').' '.__($request->role).'';
        $token = 'O4Y2v1Zw49FL9A40IuLXu35XRKyK1710p6wEf6C07C9';
        $this->lineNotify($messageToNotify, $token);

        $welcomeStickerJson = '{
            "type": "sticker",
            "packageId": "11537",
            "stickerId": "52002734"
        }';

        $welcomeStickerJsonCode = json_decode($welcomeStickerJson,true);
        $datas['url']   = "https://api.line.me/v2/bot/message/push";
        $messages['to'] = $request->provider_id;
        $messages['messages'][] = $welcomeStickerJsonCode;
        $encodeJson = json_encode($messages);
        $this->pushFlexMessage($encodeJson, $datas);

        // Login and redirect to homepage
        Auth::login($user);
        return redirect('/home');
    }
}
