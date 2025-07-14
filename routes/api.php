<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/new-post', [PostController::class, 'store']);
Route::post('/new-subscriber', [SubscriberController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



