<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('users', [App\Http\Controllers\UserController::class, 'index']);
Route::post('sessions', [App\Http\Controllers\SessionController::class, 'store']);
Route::get('sessions/{session}/chats', [App\Http\Controllers\ChatController::class, 'index']);
Route::post('sessions/{session}/chats', [App\Http\Controllers\ChatController::class, 'store']);
Route::get('sessions/{session}/read', [App\Http\Controllers\ChatController::class, 'read']);
Route::delete('sessions/{session}/clear', [App\Http\Controllers\ChatController::class, 'clear']);
Route::patch('sessions/{session}/block', [App\Http\Controllers\BlockController::class, 'block']);
Route::patch('sessions/{session}/unblock', [App\Http\Controllers\BlockController::class, 'unblock']);
