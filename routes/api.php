<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\MainDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::get('local/{path}', function (string $path){
    $link = Storage::disk('private')->path($path);
    $img = Image::make($link)->resize(320, 240);
    return $img->response('jpg');
})->name('local.temp');


Route::middleware('auth:sanctum')->group( function () {
    Route::get('/get_records/page/{id}', [MainDataController::class , 'getRecordsByPage'] );
    Route::get('data', [MainDataController::class , 'index'] );
    Route::post('data', [MainDataController::class , 'store']);
    Route::get('/get_record/{id}', [MainDataController::class , 'getRecord'] );
    Route::get('files/temp/{path}', function (string $path){
        return Storage::disk('private')->get($path) ;
    });


});
