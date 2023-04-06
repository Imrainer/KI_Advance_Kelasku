<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Sekolah;

class ViewControllers extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function sekolah ()
    {
        $data = Sekolah::all();
    
       return view('pages/schoolcreate',['data'=>$data]);
    
    }

    function register(Request $request) {

        $validator = $request->validate([
        'sekolah' => 'required'
        ],[
        'sekolah|required' => 'Sekolah Harus Diisi']);
    
        $data = [
            'sekolah'=>$request->sekolah,
        ];
    
        Sekolah::create($data);    
        return redirect('/sekolah');
    }

    function editpage($sekolah_id)
    {   
        $data = Sekolah::find($sekolah_id);
        return view('/pages/EditSekolah',compact(['data']));
    }
    
    function edit($sekolah_id, request $request) {
    
        // $data = Auth::user();
        $validator = $request->validate([
           'sekolah' => 'required'
        ]);
        $data = Sekolah::find($sekolah_id);
        $data->update($request->except(['_token','submit']));
        return redirect('/sekolah');
        }
    



    function delete($sekolah_id){
        $data= Sekolah::find($sekolah_id);
        $data->delete($sekolah_id);
        return redirect('/sekolah');
    }
}
