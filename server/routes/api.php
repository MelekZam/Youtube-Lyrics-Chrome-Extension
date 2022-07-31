<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LyricsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your A...middleware) { }PI!
|
*/

Route::prefix('auth')->group(function() {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::put('activate', [AuthController::class, 'activate']);
        Route::get('resend', [AuthController::class, 'resend']);
    });
});


Route::get('get-lyrics', [LyricsController::class, 'getLyrics']);
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('post-lyrics', [LyricsController::class, 'postLyrics']);
})
;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
