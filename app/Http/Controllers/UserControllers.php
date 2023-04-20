<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Like;
use App\Notifications\MyClassNotification;

class UserControllers extends Controller
{

public function __construct()
{
   $this->middleware('auth:api', ['except' => ['login','register','getNotify']]);
}


public function index ()
{
    
    $users = User::all();

    foreach ($users as $user) {
        if ($user->foto) {
            $user->foto = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_Kelasku/public/storage/' . $user->foto;
        }
    }

   return Api::createApi(200, 'success', $users);

}

public function myfriend ()
{   
    $authenticatedUserId = Auth::id();
    $users = User::whereNotIn('user_id',[ $authenticatedUserId])->get();
    foreach ($users as $user) {
        $total_likes = Like::where('liked_by',$authenticatedUserId)->count();
        $like = Like::where('user_id',$user->user_id)->where('liked_by',$authenticatedUserId)->first();
        // dd($like);
        if(!$like) {
            $like_by_you = false;
        } else {
            $like_by_you = true;
        }
        
        if ($user->foto) {
            $user->foto = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_Kelasku/public/storage/' . $user->foto;
        }
    
        // Menambahkan properti like_by_you ke setiap objek pengguna
        $user->like_by_you = $like_by_you;
    }

    return response()->json([
        'status' => '200',
        'data' => $users,
    ], 200);
}

public function byId ($user_id)
{   
    $authenticatedUserId = Auth::id();
    $user = User::find($user_id);

    $total_likes = Like::where('liked_by',$authenticatedUserId)->count();
        $like = Like::where('user_id',$user->user_id)->where('liked_by',$authenticatedUserId)->first();
        // dd($like);
        if(!$like) {
            $like_by_you = false;
        } else {
            $like_by_you = true;
        }

    if ($user && $user->foto) {
        $user->foto = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_Kelasku/public/storage/' . $user->foto;
    }

    $user->total_likes = Like::where('liked_by',$user)->count();
    $user->like_by_you = $like_by_you;


    if ($user) {
        return Api::createApi(200, 'success', $user);
    } else {
        return Api::createApi(400, 'failed');
    }

}
    //<!------CREATE----!>

function register(Request $request) {

    $validator = Validator::make($request->all(), [
    'nama' => 'required',
    'sekolah_id'=> 'required',
    'nomor_telepon' => 'required|unique:users,nomor_telepon',
    'password'=>'required',
    'foto' => 'image|file'
    ],[
    'nama.required' => 'Nama Harus Diisi',
    'sekolah_id.required'=> 'Nama Sekolah Harus Diiisi',
    'nomor_telepon.required' => 'Nomor Telepon Harus Diisi',
    'nomor_telepon.unique'=> 'Nomer Telepon sudah terdaftar, Silahkan gunakan Nomor Telepon lain',
    'password.required'=>'Password Harus Diisi']);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
        ], 422);
    }


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
    // dd($data);
    $data->update([
        'nama' =>($request->input('nama')),
        'sekolah_id' =>($request->input('sekolah_id')),
        'foto' => ($request->file('foto'))
    ]);

    if($request->file('foto')) {
        // $fileName = time().$request->File('foto')->getClientOriginalName();
        $data['foto'] =  $request->file('foto')->store('foto_profil');
        User::where('user_id',$data['user_id'])->update(['foto'=>$data['foto']]);
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

public function login(Request $request)
{
    $credentials = $request->only('nomor_telepon','password');

    if (! $token = auth()->attempt($credentials)) {
        return response()->json([
            'status' => 401,
            'message' => 'Invalid Nomor Telepon dan Password'
        ], 401);
    }

    // Simpan device token ke dalam database
    $user = auth()->user();
    $user->device_token = $request->input('device_token');
    $user->save();

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
        $id =  auth()->user()->user_id;
            $data = User::where('user_id',$id)->first();
    
            if($data['foto']) {
                $data->foto = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_Kelasku/public/storage/'.$data['foto'];
            } else {
                $data->foto = null;
            }

            $data->total_likes = Like::where('liked_by',$id)->count();
    
             return response()->json([
                'status' => 200,
                'data' => $data],
                200
            );    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


  protected function respondWithToken($token)
    {   $credentials = request(['nomor_telepon','password','device_token']);

        return response()->json([
            'status' => 200,
            'message'=> 'successfully login',
            'data' => $credentials,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    //LIKE AND POST 

    function getNotify (Request $request) {
  
    $deviceToken = $request->input('to');

    $data = [
        'title' => $request->input('title'),
        'body' => $request->input('body'),
    ];

    $headers = [
        'Authorization: key=AAAAylmGvBQ:APA91bGw39t-VqLdjYcypirGqdvNnzQD_XRlNdSSVr6zEI8CGQPwB-vNN_yUE8dp3g81dv7zVMKMY3pGtz5Hp8J_Vb1Yg89RPMWIuCLjN-OG0vZaexQHSi162v72eg2Yg-yV-Suu8848',
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
    if ($response === false) {
        die('cURL error: ' . curl_error($ch));
    }

    $responseData = json_decode($response, true);

    if (isset($responseData['error'])) {
        die('FCM API error: ' . $responseData['error']);
    }
    return Api::createApi(200, 'successfully sent', $data);;
     
     }

public function like($user_id)
{
    $likedBy = Auth::user()->user_id;

    $like = Like::firstOrCreate([
        'user_id' => $user_id,
        'liked_by' => $likedBy,
    ]);

    return Api::createApi(200, 'success', 'You have Liked ' .$user_id);
}

public function unlike($user_id)
{
    $likedBy = Auth::user()->user_id;

    $like = Like::where([
        'user_id' => $user_id,
        'liked_by' => $likedBy,
    ])->delete();

    return Api::createApi(200, 'success', 'You have Unliked ' . $user_id);
}


}

