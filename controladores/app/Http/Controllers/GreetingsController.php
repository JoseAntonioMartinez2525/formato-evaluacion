<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GreetingsController extends Controller
{
    public function saludar($nombre)
    {
        return view('saludo', ['nombre' => $nombre]);
    }
}
