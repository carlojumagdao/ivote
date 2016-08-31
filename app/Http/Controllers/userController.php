<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DynamicField AS DynamicField;
use App\User AS User;
use Validator;
use DB;
use App\GenSet AS GenSet;
use Hash;
use Redirect;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Input;
use Auth;
use Crypt;

class userController extends Controller
{
  
    public function index(){
        $GenSet = GenSet::find(1);
        $start = date_create($GenSet->datSetStart);
        $end = date_create($GenSet->datSetEnd);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        if(($now >= $start) & ($now <= $end)){
            $ongoing = 1;
        }
        else{
            $ongoing = 0;
        }

        $Users = DB::table('users')->where('blDelete', '=', 0)->get();
        return view('Users.index', ['Users' => $Users, 'intCounter'=>0, 'electionStatus' =>$ongoing]);
    } 
    public function profile(Request $request){
        $id = $request->input('id');
        $user = DB::table('users')->where('id', $id)->get();
        
        return view('Users.userProfile', ['user' => $user]);
    } 
    public function view($id){
        $users = DB::table('users')->where('id', $id)->get();
        foreach ($users as $user) {
            $name = $user->name;
            $img = $user->txtPath;
            $email = $user->email;
        }
        return view('Users.userView', ['users' => $users,'name'=>$name,'img'=>$img,'email'=>$email]);
    } 
    public function editUser($id){
        $users = DB::table('users')->where('id', $id)->get();
        foreach ($users as $user) {
            $name = $user->name;
            $img = $user->txtPath;
            $email = $user->email;
        }
        return view('Users.EditUser', ['users' => $users,'name'=>$name,'img'=>$img,'email'=>$email,'id'=>$id]);
    } 
    public function edit(Request $request){
        $id = $request->input('id');
        $user = DB::table('users')->where('id', $id)->get();
        
        return view('Users.userEdit', ['user' => $user]);
        
    }
    public function create(){
        $GenSet = GenSet::find(1);
        $start = date_create($GenSet->datSetStart);
        $end = date_create($GenSet->datSetEnd);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        $user = DB::table('users')->get();
        
        if(($now >= $start) & ($now <= $end)){
            return view('election-page-disabled');
        }
        else{
            return view('Users.userAdd', ['user' => $user]);
        }
        
    }
    public function add(Request $request){
        $user = DB::table('users')->get();
        $rules = array(
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp|max:10000',
            'confirmpassword' => 'required|same:password',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The email is already taken.',
        ];
        $niceNames = array(
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'image' => 'Image',
            'confirmpassword' => 'Confirm Password'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            
            $destinationPath =  'assets/images/'; // upload path
            $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
            $date = date("Ymdhis");
            $filename = $date.'-'.rand(111111,999999).'.'.$extension;
            
            if ($request->file('image')->isValid()) {
                $request->file('image')->move($destinationPath, $filename);
                $imgPath = $filename;
            }
            
            User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'txtPath' => $imgPath,
            'password' => bcrypt($request['password']),
            ]);
           
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            //return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully added.');
        $Users = DB::table('users')->where('blDelete', '=', 0)->get();
        return view('Users.index', ['Users' => $Users, 'intCounter'=>0]);
    }

    public function delete(Request $request){
        $id = $request->input("id");
        $user = DB::table('users')->where('id', '=', $id)->get();
        $User = User::find($id);
        $User->blDelete = 1;
        $User->save();
        
        $request->session()->flash('message', 'Successfully deleted.');  
        return Redirect::back();
    }

        public function updatePassword(Request $request){
        $userPass = Auth::user()->password;
        $oldpass = Hash::make(Input::get('oldpassword'));
        $validator = Validator::make(Input::all(),
            array(
                'oldpassword' => 'required',
                'newpassword' => 'required|min:6',
                'confirmpassword' => 'required|same:newpassword',
            )
        );
        $niceNames = array(
            'oldpassword' => 'Password',
            'newpassword' => 'New Password',
            'confirmpassword' => 'Confirm Password',
        );
        $validator->setAttributeNames($niceNames); 
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
            } 
        try{
            $userId = session('id'); 
            $oldpassword = Input::get('oldpassword');
            $newpassword = Input::get('newpassword');

            if (Hash::check($oldpassword, $userPass)){
                $user = DB::table('users')
                        ->where('id', $userId)
                        ->update(['password' => bcrypt($request['newpassword'])]);
                $request->session()->flash('message', "Password Successfully Updated");   
            }else{
                $request->session()->flash('error', "Incorrect Password!");
            }      
               
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
        }
        return Redirect::back();
    }
    
    public function updateProfile(Request $request){
        $validator = Validator::make(Input::all(),
            array(
            )
        );
        $niceNames = array(
            'image' => 'Image',
        );
        $validator->setAttributeNames($niceNames); 
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
            } 
        try{
            $userId = session('id'); 
            $User = User::find($userId);
            
            if ($request->hasFile('image')){

                $destinationPath =  'assets/images/'; // upload path
                $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                $date = date("Ymdhis");
                $filename = $date.'-'.rand(111111,999999).'.'.$extension;
                    if ($request->file('image')->isValid()) {
                    $request->file('image')->move($destinationPath, $filename);
                    $User->txtPath = $filename;
                }
            }          
            $User->save();
            $request->session()->flash('message', "Profile Successfully Updated");   
               
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
        }
        return Redirect::back();
    }
    public function updateUser(Request $request){
        $validator = Validator::make(Input::all(),
            array(
                'name' => 'required',
                'email' => 'required',
                'image' => 'mimes:jpeg,jpg,png,bmp|max:50000'
            )
        );
        $niceNames = array(
            'image' => 'Image',
            'name' => 'Name',
            'email' => 'Email',
        );
        $validator->setAttributeNames($niceNames); 
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
            } 
        try{
            $id = $request->input('id');
            $User = User::find($id);
            $User->name = $request->input('name');
            $User->email = $request->input('email');
            
            if ($request->hasFile('image')){

                $destinationPath =  'assets/images/'; // upload path
                $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                $date = date("Ymdhis");
                $filename = $date.'-'.rand(111111,999999).'.'.$extension;
                    if ($request->file('image')->isValid()) {
                    $request->file('image')->move($destinationPath, $filename);
                    $User->txtPath = $filename;
                }
            }          
            $User->save();
            $request->session()->flash('message', "User Successfully Updated");   
               
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
        }
        return Redirect::back();
    }


}
