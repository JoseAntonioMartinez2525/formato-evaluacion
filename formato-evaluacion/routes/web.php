<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('login');
});

Route::get('/', [SessionsController::class, 'index'])->name('login');
Route::post('/login', [SessionsController::class, 'login'])->name('login.post');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/welcome', [HomeController::class, 'showWelcome'])->name('welcome');
Route::get('/welcome', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
Route::get('rules', function () {
    return view('rules');
})->name('rules');

Route::post('/store', [ResponseController::class, 'store'])->name('store');

Route::get('/generate-json', [ResponseController::class, 'generateJson'])->name('generate-json');
