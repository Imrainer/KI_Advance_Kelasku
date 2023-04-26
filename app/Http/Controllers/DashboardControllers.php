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

public function index (request $request)
{   $admin = session('admin_id');
    $admin = Admin::where('admin_id', $admin)->first();

    if($request->has('search')){
        $data = User::where('nama', 'LIKE', '%' .$request->search.'%')->paginate(5);
    } else {
         $data = User::paginate(5);
    }

  $sekolah = Sekolah::all();
   return view('pages/Dashboard',compact(['admin','data','sekolah']));
}

public function sekolah (request $request)
{   $admin = session('admin_id');
    $admin = Admin::where('admin_id', $admin)->first();

    if($request->has('search')){
        $data = Sekolah::where('sekolah', 'LIKE', '%' . $request->search. '%')->paginate(5);
    } else {
        $data = Sekolah::paginate(5);
    }
  
   return view('pages/Sekolah',compact(['admin','data']));

}


function register(Request $request) {

    $validator = $request->validate([
    'nama' => 'required',
    'sekolah_id'=> 'required',
    'nomor_telepon' => 'required|unique:users,nomor_telepon',
    'password'=>'required',
    'foto' => 'nullable|image|file'
    ],[
    'nama|required' => 'Nama Harus Diisi',
    'sekolah_id.required'=> 'Nama Sekolah Harus Diiisi',
    'nomor_telepon.required' => 'Nomor Telepon Harus Diisi',
    'nomor_telepon.unique'=> 'Nomer Telepon sudah terdaftar, Silahkan gunakan Nomor Telepon lain',
    'password.required'=>'Password Harus Diisi']);


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

function edit(request $request, $user_id) {

    $data = User::find($user_id);
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

function profilepage()
{  $data = session('admin_id');

  $data = Admin::where('admin_id', $data)->first();
    return view('/pages/profil',compact(['data']));
}

function editprofile(request $request) {

    $data = session('admin_id');

    $data = Admin::where('admin_id', $data)->first();
    $data->update([
        'nama' =>($request->input('nama')),
        'email' =>($request->input('email')),
        'nomor_telepon' =>($request->input('nomor_telepon')),
    ]);

    return redirect('/profil')->with('Profil berhasil diperbarui');
}

function editphoto(request $request) {

    $data = session('admin_id');

    $data = Admin::where('admin_id', $data)->first();
    // dd($request->all());
    $data->update([
        'foto' => ($request->file('foto'))
    ]);

    if($request->file('foto')) {
        $data['foto'] =  $request->file('foto')->store('foto_profil');
        Admin::where('admin_id',$data['admin_id'])->update(['foto'=>$data['foto']]);
    }
   
    return redirect('/profil')->with('Profil berhasil diperbarui');
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

    $validator = $request->validate([
        'nomor_telepon' => 'required',
        'password'=>'required',
        ],[
        'nomor_telepon.required' => 'Nomor Telepon Harus Diisi',
        'password.required'=>'Password Harus Diisi']);


    $nomor_telepon = $request->input('nomor_telepon');
    $password = $request->input('password');

    $admin = Admin::where('nomor_telepon', $nomor_telepon)->first();

    if ($admin && password_verify($password, $admin->password)) {
        session()->put('admin_id',[
            'admin_id' => $admin->admin_id,
            'admin_nama' => $admin->nama,
            'admin_email'=>$admin->email,
            'admin_nomor_telepon' => $admin->nomor_telepon,
            'admin_foto'=>$admin->foto,
        ]);

        return redirect('/dashboard')->with('success','Selamat Datang Kembali Admin');
    } else {
        return redirect('/')->with('error', 'Invalid email or password');
    }
  }


// <!----LOGOUT----!>
function logout()
{
    session()->flush();
    // session()->flush('admin_nama');
    // session()->flush('admin_nomor_telepon');
    
    return redirect('/')->with('success','Berhasil Logout');
}

}
