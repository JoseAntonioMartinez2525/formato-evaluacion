<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ResponseJson;
use App\Http\Controllers\ResponseForm2Controller;
use App\Http\Controllers\ResponseForm2_2Controller;
use App\Http\Controllers\ResponseForm3_1Controller;
use App\Http\Controllers\ResponseForm3_2Controller;
use App\Http\Controllers\ResponseForm3_3Controller;
use App\Http\Controllers\ResponseForm3_4Controller;
use App\Http\Controllers\ResponseForm3_5Controller;
use App\Http\Controllers\ResponseForm3_6Controller;
use App\Http\Controllers\ResponseForm3_7Controller;
use App\Http\Controllers\ResponseForm3_8Controller;
use App\Http\Controllers\ResponseForm3_9Controller;
use App\Http\Controllers\ResponseForm3_10Controller;
use App\Http\Controllers\ResponseForm3_11Controller;
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
Route::get('rules', function () {return view('rules'); })->name('rules');
Route::get('docencia', function () {return view('docencia'); })->name('docencia');
Route::get('resumen', function () {return view('resumen'); })->name('resumen');

//POST formularios
Route::post('/store', [ResponseController::class, 'store'])->name('store');
Route::post('/store2', [ResponseForm2Controller::class, 'store2'])->name('store2');
Route::post('/store3', [ResponseForm2_2Controller::class, 'store3']);
Route::post('/store31', [ResponseForm3_1Controller::class, 'store31']);
Route::post('/store32', [ResponseForm3_2Controller::class, 'store32']);
Route::post('/store33', [ResponseForm3_3Controller::class, 'store33']);
Route::post('/store34', [ResponseForm3_4Controller::class, 'store34']);
Route::post('/store35', [ResponseForm3_5Controller::class, 'store35']);
Route::post('/store36', [ResponseForm3_6Controller::class, 'store36']);
Route::post('/store37', [ResponseForm3_7Controller::class, 'store37']);
Route::post('/store38', [ResponseForm3_8Controller::class, 'store38']);
Route::post('/store39', [ResponseForm3_9Controller::class, 'store39']);
Route::post('/store310', [ResponseForm3_10Controller::class, 'store310']);
Route::post('/store311', [ResponseForm3_11Controller::class, 'store311']);

//GET formularios
Route::get('/get-data2', [ResponseForm2Controller::class, 'getData2'])->name('getData2');
Route::get('/get-data22', [ResponseForm2_2Controller::class, 'getData22'])->name('getData22');
Route::get('/get-data-31', [ResponseForm3_1Controller::class, 'getData31'])->name('getData31');
Route::get('/get-data-32', [ResponseForm3_2Controller::class, 'getData32'])->name('getData32');
Route::get('/get-data-33', [ResponseForm3_3Controller::class, 'getData33'])->name('getData33');
Route::get('/get-data-34', [ResponseForm3_4Controller::class, 'getData34'])->name('getData34');
Route::get('/get-data-35', [ResponseForm3_5Controller::class, 'getData35'])->name('getData35');
Route::get('/get-data-36', [ResponseForm3_6Controller::class, 'getData36'])->name('getData36');
Route::get('/get-data-37', [ResponseForm3_7Controller::class, 'getData37'])->name('getData37');
Route::get('/get-data-38', [ResponseForm3_8Controller::class, 'getData38'])->name('getData38');
Route::get('/get-data-39', [ResponseForm3_9Controller::class, 'getData39'])->name('getData39');
Route::get('/get-data-310', [ResponseForm3_10Controller::class, 'getData310'])->name('getData310');
Route::get('/get-data-311', [ResponseForm3_11Controller::class, 'getData311'])->name('getData311');

Route::get('/generate-json', [ResponseController::class, 'generateJson'])->name('generate-json');
Route::get('/json-generator', [ResponseJson::class, 'jsonGenerator'])->name('json-generator');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');


