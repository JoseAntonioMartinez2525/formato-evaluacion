<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ResponseJson;
use App\Http\Controllers\ResponseForm2Controller;
use App\Http\Controllers\ResponseForm2_2Controller;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
Route::post('/store2', [ResponseForm2Controller::class, 'store2'])->name('store2');
Route::post('/store3', [ResponseForm2_2Controller::class, 'store3'])->name('store3');


Route::get('/generate-json', [ResponseController::class, 'generateJson'])->name('generate-json');
Route::get('/json-generator', [ResponseJson::class, 'jsonGenerator'])->name('json-generator');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');


