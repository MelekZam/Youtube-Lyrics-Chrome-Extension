<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LyricsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::put('activate', [AuthController::class, 'activate']);
        Route::get('resend', [AuthController::class, 'resend']);
    });
});

Route::group(['middleware' => 'verify_video_id'], function() {
    Route::get('get-lyrics', [LyricsController::class, 'getLyrics'])->middleware('verify_video_id');
    Route::get('get-translation', [LyricsController::class, 'getTranslation']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('post-lyrics', [LyricsController::class, 'postLyrics']);
        Route::post('post-translation', [LyricsController::class, 'postTranslation']);
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
