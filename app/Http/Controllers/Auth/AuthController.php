<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use File;
use Crypt;
use Input;
use Redirect;
use Session;
use Carbon\Carbon;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'image' => 'required|mimes:jpeg,jpg,png,bmp|max:50000',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $destinationPath =  'assets/images/'; // upload path
        $extension = $data['image']->getClientOriginalExtension(); // getting image extension
        $date = date("Ymdhis");
        $filename = $date.'-'.rand(111111,999999).'.'.$extension;
        if ($data['image']->isValid()) {
            $data['image']->move($destinationPath, $filename);
        }
               
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'txtPath' => $filename,
        ]);
    }

    protected $redirectPath = '/dashboard';
    protected $redirectAfterLogout = '/admin';
}
