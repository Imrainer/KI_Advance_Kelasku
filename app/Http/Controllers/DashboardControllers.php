<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Sekolah;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage; 

class DashboardControllers extends Controller
{

public function index ()
{
    $data = User::all();
  $sekolah = Sekolah::all();
   return view('pages/Dashboard',['data'=>$data],['sekolah'=>$sekolah]);

}

public function sekolah ()
{
    $data = Sekolah::all();
  
   return view('pages/Sekolah',['data'=>$data]);

}


function register(Request $request) {

    $validator = $request->validate([
    'nama' => 'required',
    'sekolah_id'=> 'required',
    'nomor_telepon' => 'required',
    'password'=>'required',
    'foto' => 'nullable|image|file'
    ],[
    'nama|required' => 'Nama Harus Diisi',
    'sekolah_id|required'=> 'Nama Sekolah Harus Diiisi',
    'nomor_telepon|required' => 'Nomor Telepon Harus Diisi',
    'password|required'=>'Password Harus Diisi']);


    $data = [
        'nama'=>$request->nama,
        'sekolah_id'=>$request->sekolah_id,
        'nomor_telepon'=>$request->nomor_telepon,
        'password'=>Hash::make($request->password),
      
    ];
    
    User::create($data);    
    return redirect('/dashboard');

}

function editpage($user_id)
{   
    $data = User::find($user_id);
    $sekolah = Sekolah::all();
    return view('/pages/EditUser',compact(['data']),['sekolah'=>$sekolah]);
}

function edit($user_id, Request $request) {
    

    $data = User::find($user_id);
      
    $data->update([
    'nama' =>($request->input('nama')),
    'sekolah_id' =>($request->input('sekolah_id')),
    'foto' =>( $request->file('foto'))
    ]);
    
    if($request->file('foto')) {
      $data['foto'] =  $request->file('foto')->store('foto_profil');
    }
   
    return redirect('/dashboard');
}


function delete($user_id)
{
    $data= User::find($user_id);
    $data->delete($user_id);
    return redirect('/dashboard');
}


function logpage()
{   
    $sekolah = Sekolah::all();
    return view('/pages/login',['sekolah'=>$sekolah]);
}

//<!----lOGIN---->

function login (request $request){

    $credentials = $request->only('nomor_telepon', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        $user->api_token = $token;
        $user->save();
        return redirect('/dashboard')->with('success', 'Login successful');
    }

    return redirect()->route('login')->with('error', 'Invalid credentials');
}

// <!----LOGOUT----!>
function logout() 
{
    auth()->logout(); 
    return redirect('/')->with('Berhasil Logout');
}

}
