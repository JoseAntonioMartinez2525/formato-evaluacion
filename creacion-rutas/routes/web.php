<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/operaciones/{operacion}/{num1}/{num2}', function ($operacion, $num1, $num2) {
    switch ($operacion) {
        case 'suma':
            return $num1 + $num2;
        case 'resta':
            return $num1 - $num2;
        case 'multiplicacion':
            return $num1 * $num2;
        case 'division':
            if ($num2 != 0) {
                return $num1 / $num2;
            } else {
                return "Error: División por cero";
            }
        default:
            return "Operación no válida";
    }
})->where(['operacion' => '[a-z]+', 'num1' => '[0-9]+', 'num2' => '[0-9]+']);

Route::get('/saludo/{nombre}/{apellido?}', function ($nombre, $apellido = null) {
    if ($apellido) {
        return "user: " . $nombre . " " . $apellido;
    } else {
        return "Hola, $nombre";
    }
})->where(['nombre' => '[a-z]+', 'apellido' => '[a-z]*']);

Route::get('/vista/{nombre}', function ($nombre) {
    return view('Hola', ['nombre' => $nombre]);
})->where('nombre', '[a-z]+');

?>