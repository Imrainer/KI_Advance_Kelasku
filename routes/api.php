<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllers;
use App\Http\Controllers\SekolahControllers;
use App\Http\Controllers\TemanControllers;
use App\Http\Controllers\NotificationControllers;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//USER

Route::post('/register',[UserControllers::class, 'register']);
Route::post('/login',[UserControllers::class, 'login'])->middleware('guest');
Route::post('/logout',[UserControllers::class, 'logout']);
    
Route::post('data_user',[UserControllers::class,'data']);
Route::post('refresh',[UserControllers::class,'refresh']);
Route::get('/listuser',[UserControllers::class, 'index']);
Route::get('/myfriend',[UserControllers::class, 'myfriend']);
Route::get('/user/{user_id}',[UserControllers::class, 'byId']);
Route::post('/editprofile',[UserControllers::class, 'edit']);
Route::post('/editpassword',[UserControllers::class, 'editpassword']);
Route::delete('/deleteuser/{user_id}',[UserControllers::class, 'delete']);
Route::get('editprofile', function(){
    return app('files')->link(storage_path('app'), public_path('uploud'));
});

Route::post('/like/{user_id}', [UserControllers::class, 'like'])->name('like');
Route::post('/unlike/{user_id}', [UserControllers::class, 'unlike'])->name('unlike');

Route::post('getnotif',[UserControllers::class, 'getNotify']);

//SEKOLAH
Route::get('/listsekolah',[SekolahControllers::class, 'index']);
Route::post('/create/sekolah',[SekolahControllers::class, 'register']);

