<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Admin;
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

function edit(request $request) {

    $data = Auth::user();
    // dd($data);
    $data->update([
        'nama' =>($request->input('nama')),
        'sekolah_id' =>($request->input('sekolah_id')),
        'foto' => ($request->file('foto'))
    ]);

    if($request->file('foto')) {
        $data['foto'] =  $request->file('foto')->store('foto_profil');
        User::where('user_id',$data['user_id'])->update(['foto'=>$data['foto']]);
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
    return view('/pages/login');
}

//<!----lOGIN---->

function login (request $request){

    $credentials = $request->validate([
    'nomor_telepon'=>'required|email',
    'password'=>'required', 
    ], [
      'nomor_telepon.required' => 'Nomor Telepon harus diisi',
      'password.required' => 'Password harus diisi',
    ]);
      
    
    if(Auth::guard('admin')->attempt($credentials)){
        return redirect('/dashboard')->with('Berhasil Login');
      } else {
      return redirect('/')->withErrors('Email dan Password Invalid');
      }
  }


// <!----LOGOUT----!>
function logout() 
{
    auth()->logout(); 
    return redirect('/')->with('Berhasil Logout');
}

}
