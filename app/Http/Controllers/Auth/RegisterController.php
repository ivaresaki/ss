<?php

namespace Org\Jvhsa\Surgiscript\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Org\Jvhsa\Surgiscript\Http\Controllers\Controller;
use Org\Jvhsa\Surgiscript\Mail\UserRegistered;
use Org\Jvhsa\Surgiscript\User;

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
    protected $redirectTo = '/';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Org\Jvhsa\Surgiscript\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // 'email_token' => str_random(40),
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        // confirm uri
        // $confirm_uri = ""
        // generate email
        Mail::to($user)->send(new UserRegistered($user));

        return redirect()->route('login')
                         ->with('status', 'Please check your email to confirm your registration');
        // return $this->registered($request, $user)
        //                 ?: redirect($this->redirectPath());
    }

    /**
     * Confirms email for the user
     * @param  String $email_token User email token
     * @return Redirect            Redirects user to login page
     */
    public function confirmEmail(Request $request)
    {
        $user = User::where('email_token', '=', $request->email_token)
            ->firstOrFail()
            ->confirmEmail();

        return redirect()->route('login')->with('status', 'Thank you for confirming your email. You may now login.');
    }
}
