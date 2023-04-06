<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Notifications\MyClassNotification;

class UserControllers extends Controller
{

public function __construct()
{
   $this->middleware('auth:api', ['except' => ['login','register','getNotify']]);
}


public function index ()
{
    $data = User::all();

    if($data){
        return Api::createApi(200, 'success', $data);
    } else {
        return Api::createApi(400, 'failed');
    }

}

public function byId ($user_id)
{
    $data = User::find($user_id);

    if($data){
        return Api::createApi(200, 'success', $data);
    } else {
        return Api::createApi(400, 'failed');
    }

}


    //<!------CREATE----!>

function register(Request $request) {

    $validator = $request->validate([
    'nama' => 'required',
    'sekolah_id'=> 'required',
    'nomor_telepon' => 'required',
    'password'=>'required',
    'foto' => 'image|file'
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


if($data) {
    return Api::createApi(200, 'successfully created', $data);
} else {
    return Api::createApi(400, 'failed');
}

}

//<!-----UPDATE----!>


function edit(request $request) {

    $data = Auth::user();
    $data->update([
        'nama' =>($request->input('nama')),
        'sekolah_id' =>($request->input('sekolah_id')),
        'foto' => ($request->file('foto'))
    ]);

    if($request->file('foto')) {
        $data['foto'] =  $request->file('foto')->store('foto_profil');
    }
    return Api::createApi(200, 'successfully updated', $data);
    }


function editpassword(request $request) {
    $data = auth()->user()->user_id;
    // $validator = $request->validate([
    //     'current_password' => 'required',
    //     'new_password' => 'required|string|min:5|confirmed'
    //     ]);
    
    //    dd($request->all());
       
        $user = User::where('user_id', $data)->first();
        $user['password'] = Hash::make($request->new_password);
        $user->save();

        return Api::createApi(200, 'successfully updated password');
        }

//<!---DELETE---!>

function delete($user_id){
    $data= User::find($user_id);
    $data->delete($user_id);
    return Api::createApi(200, 'successfully deleted');
}

//<!----lOGIN---->

function login (request $request){

$credentials = request(['nomor_telepon','password']);

if (! $token = auth()->attempt($credentials)) {
    return response()->json(['error' => 'Unauthorized'], 401);
}
return $this->respondWithToken($token);
}
  
  // <!----LOGOUT----!>
  function logout() 
  {
    auth()->logout();
        return Api::createApi(200, 'successfully logout');
  }

  public function data()
    {
        return response()->json( auth()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


  protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 200,
            'message'=> 'successfully login',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    //LIKE AND POST 

    function getNotify (Request $request) {
  
    $deviceToken = $request->header('to');

    $data = [
        'title' => $request->header('title'),
        'body' => $request->header('body'),
    ];

    $headers = [
        'Authorization: key=' . $request->header('Authorization'),
        'Content-Type: application/json',
    ];

    $options = [
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode([
            'to' => $deviceToken,
            'notification' => $data,
        ]),
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);

    $response = curl_exec($ch);

    curl_close($ch);

    return'terkirim';
     
     }

     
 public function likeFriend(Request $request,$user_id)
    {
        $user = Auth::user(); // Mendapatkan user saat ini
        $user = User::find($user_id);
        if ($request->action == 'like') {
            // $user->likeByYou = true;
            // $user->likes += 1; // Menambah jumlah like pada teman
        } else if ($request->action == 'dislike') {
            $user->likeByYou = false;
            $user->likes -= 1; // Mengurangi jumlah like pada teman
        }
        
    
        $user->save(); // Menyimpan perubahan pada kolom likes
        return response()->json(['message' => 'Action successful']);
    }



}
