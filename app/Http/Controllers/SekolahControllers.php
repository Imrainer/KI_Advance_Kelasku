<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\helpers\Api;
use App\Models\Sekolah;
class SekolahControllers extends Controller
{
    public function index ()
    {
        $data = Sekolah::all();
    
        if($data){
            return Api::createApi(200, 'success', $data);
        } else {
            return Api::createApi(400, 'failed');
        }
    }


    function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'sekolah' => 'required|unique:sekolah,sekolah',
            ],[
            'sekolah.required' => 'Nama Harus Diisi',
             'sekolah.unique' => 'Sekolah sudah terdaftar, Silahkan daftarkan Sekolah lain'
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

        $data = [
          'sekolah'=>$request->sekolah
        ];

        Sekolah::create($data);    
    if($data) {
        return Api::createApi(200, 'successfully created', $data, );
    } else {
        return Api::createApi(400, 'failed');
    }}

    function edit($sekolah_id, request $request) {
    
        $data = Auth::user();
        $validator = $request->validate([
           'sekolah' => 'required'
        ]);
      
        $data->update($request->except(['_token','submit']));
        return Api::createApi(200, 'successfully updated', $data);
        }
    



    function delete($sekolah_id){
        $data= Sekolah::find($sekolah_id);
        $data->delete($sekolah_id);
        return Api::createApi(200, 'successfully deleted', $data);
    }
    
}
