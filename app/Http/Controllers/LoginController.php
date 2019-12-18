<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Admin;
use App\Owner;
use App\Staff;
use Validator;
use Hash;

class LoginController extends Controller
{
	public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin');
        $this->middleware('guest:staff');
        $this->middleware('guest:owner');
    }
    public function login(Request $request){
    	if($request->jabatan == 1){
	    	if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
	            return redirect()->intended('/home');
	        }
	    }elseif($request->jabatan == 2){
	    	if (Auth::guard('staff')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
	            return redirect()->intended('/home');
	        }
	    }elseif($request->jabatan == 3){
	    	if (Auth::guard('owner')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
	            return redirect()->intended('/home');
	        }
	    }
        return back()->withInput($request->only('email', 'remember'));
    }
    public function register(Request $r){
        $r->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    	if($r->jabatan == 1){
	    	$in = new Admin();
	    }elseif($r->jabatan == 2){
	    	$in = new Staff();
	    }elseif($r->jabatan == 3){
	    	$in = new Owner();
	    }
    	$in->name = $r->name;
    	$in->email = $r->email;
    	$in->password = Hash::make($r->password);
    	$in->save();
    	if($in){
    		Session::flash('sukses', 'Berhasil Registrasi!');
    	}else{
    		Session::flash('gagal', 'Gagal Registrasi!');
    	}
    	return back();
    }
}
