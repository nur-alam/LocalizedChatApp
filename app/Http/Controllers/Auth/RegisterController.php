<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

use \Storage;
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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        //dd($request->all());exit();
        $this->validator($request->all())->validate();
        $file = $request->file('profile_image');
        $realfilename = $file->getClientOriginalName();
        $ext = explode(".", $realfilename);
        $destination = "img/".$ext[0].time().".".end($ext);

        event(new Registered($user = $this->create([
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'password'=> $request->password,
                    'profile_image'=> $destination,
                    'area'=> $request->area
                ])
            )
        );

        $uploaded = Storage::put($destination,file_get_contents($file));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        $allowed = config('app.allowed');
        $maxfilesize = config('app.file_size');
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'profile_image' => "required|mimes:{$allowed}|max:{$maxfilesize}",
            'area'=> "required"
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_image' => $data['profile_image'],
            'area'=> $data['area']
        ]);
    }
}
