<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PuntajeMaximosController extends Controller
{
public function updatePuntajeMaximo(Request $request)
{
    try {
        $request->validate([
            'puntajeMaximo' => 'required|numeric|min:0',
        ]);

        DB::table('puntajes_maximos')->updateOrInsert(
            ['clave' => 'puntajeMaximo'],
            ['valor' => $request->puntajeMaximo]
        );

        return response()->json(['message' => 'Puntaje máximo actualizado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al actualizar el puntaje máximo: ' . $e->getMessage());
        return response()->json(['message' => 'Error al actualizar el puntaje máximo.'], 500);
    }
}

public function showForm3_8_1() {
    // Recupera el valor de puntajeMaximo
    $puntajeMaximo = DB::table('puntajes_maximo')
                        ->where('user_type', '')
                        ->id(1)
                        ->value('valor');


    // Pasa el valor a la vista
    return view('form3_8_1', compact('puntajeMaximo'));
}
}
