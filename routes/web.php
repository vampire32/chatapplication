<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/messages', [MessageController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/send-message', [MessageController::class, 'sendMessage']);
Route::post('/start-conversation', [MessageController::class, 'startConversation']);

Route::get('/get-messages', [MessageController::class, 'getMessages']);
