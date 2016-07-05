<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DynamicField AS DynamicField;
use App\User AS User;
use Validator;
use DB;
use Redirect;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class userController extends Controller
{
  
    public function index(){
        $Users = DB::table('users')->where('blDelete', '=', 0)->get();
        return view('Users.index', ['Users' => $Users, 'intCounter'=>0]);
    } 
    public function profile(Request $request){
        $id = $request->input('id');
        $user = DB::table('users')->where('id', $id)->get();
        
        return view('Users.userProfile', ['user' => $user]);
    } 
    public function edit(Request $request){
        $id = $request->input('id');
        $user = DB::table('users')->where('id', $id)->get();
        
        return view('Users.userEdit', ['user' => $user]);
        
    }
    public function create(){
        $user = DB::table('users')->get();
        return view('Users.userAdd', ['user' => $user]);
        
    }
    public function add(Request $request){
        $user = DB::table('users')->get();
        $rules = array(
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp|max:10000',
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
        
        //redirect
        $request->session()->flash('message', 'Successfully deleted.');  
        return Redirect::back();
    }

    public function update(Request $request){
        $rules = array(
            'password' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $User = User::find($request->input('id'));
            $User->password = $request->input(Hash::make('password'));
            
            $request->session()->flash('message', "Successfully Updated"); 
            $User->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back();
        }
        //redirect
       
        $User = DB::table('users')->get();
        return Redirect::back();
    }
}
