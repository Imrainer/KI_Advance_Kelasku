<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Teman;

class TemanControllers extends Controller
{
    public function index ()
    {
        $user = Auth::user(); // Mendapatkan user saat ini
        $teman = $user->friends; // Mendapatkan daftar teman dari user saat ini
    
        return Api::createApi(200, 'success', $teman);
    }


    //BYID
    public function ById($teman_id)
{
    $teman = Teman::find($teman_id); // Mendapatkan informasi teman berdasarkan ID yang diberikan
    
    return response()->json(['teman' => $teman]);
}
    

    //ADD-FRIEND
    function addfriend(Request $request, Teman $teman) 
    {
        $user = Auth::user(); // Mendapatkan user saat ini
        $teman = User::find($request->teman_id); // Mendapatkan user yang akan dijadikan teman
        $user->teman()->attach($teman->id); // Menyimpan relasi pada tabel friends dengan menggunakan method attach()
        return Api::createApi(200, 'Friend added csuccessfully ');       
    }


    //<!---DELETE---!>

    function delete($teman_id){
    $user = Auth::user(); // Mendapatkan user saat ini
    $teman = User::find($request->teman_id); // Mendapatkan user yang akan dihapus sebagai teman
    
    $user->teman()->detach($teman->id); // Menghapus relasi pada tabel friends dengan menggunakan method detach()
    
    return response()->json(['message' => 'Friend removed successfully']);
  }

  //LIKE AND DISLIKE

  public function likeFriend(Request $request, Teman $teman)
{
    $user = Auth::user(); // Mendapatkan user saat ini
    
    if ($request->action == 'like') {
        $teman->likes += 1; // Menambah jumlah like pada teman
    } else if ($request->action == 'dislike') {
        $teman->likes -= 1; // Mengurangi jumlah like pada teman
    }
    
    $teman->save(); // Menyimpan perubahan pada kolom likes
    
    return response()->json(['message' => 'Action successful']);
}
}