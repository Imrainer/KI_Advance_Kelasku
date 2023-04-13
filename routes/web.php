<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardControllers;
use App\Http\Controllers\ViewControllers;
use App\Http\Controllers\UserControllers;
use App\Http\Controllers\SekolahControllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/',[DashboardControllers::class, 'logpage'])->name('login');
Route::post('/login',[DashboardControllers::class, 'login'])->middleware('guest');
Route::get('/logout', function (Request $request) {
$request->user()->token()->revoke();
    return response()->json([
        'message' => 'Successfully logged out' ]);})->middleware('auth:api');
        
// Route::middleware('auth')->group(function () {
Route::get('/dashboard',[DashboardControllers::class, 'index']);
Route::post('/register',[DashboardControllers::class, 'register']);
Route::get('/edit/{user_id}',[DashboardControllers::class, 'editpage']);
Route::put('/editprofile/{user_id}',[DashboardControllers::class, 'edit']);
Route::get('/deleteuser/{user_id}',[DashboardControllers::class, 'delete']);
Route::get('/sekolah',[DashboardControllers::class, 'sekolah']);
Route::post('/create-store',[ViewControllers::class, 'register']);
Route::get('/editsekolah/{sekolah_id}',[ViewControllers::class, 'editpage']);
Route::put('/editstore/{sekolah_id}',[ViewControllers::class, 'edit']);
Route::get('/deletesekolah/{sekolah_id}',[ViewControllers::class, 'delete']);
//  });
Route::get('link', function(){
    return app('files')->link(storage_path('app'), public_path('uploud'));
});

Route::get('/images/{filename}', function ($filename)
{
    $path = storage_path('app/public/foto_profil' . $filename);
 
    if (!File::exists($path)) {
        abort(404);
    }
 
    $file = File::get($path);
    $type = File::mimeType($path);
 
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
 
    return $response;
});