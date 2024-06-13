<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\UsersResponseForm2_2;

class ResponseForm2_2Controller extends Controller
{
    public function store3(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'hours' => 'required|numeric',
            'actv2Comision' => 'required|numeric', 
            'obs2' => 'string',
            'obs2_2' => 'string',
        ]);

        // Assign a default value if puntajeEvaluar is not provided
        if (!isset($validatedData['puntajeEvaluar'])) {
            $validatedData['puntajeEvaluar'] = 0;
        }
        if (!isset($validatedData['obs2'])) {
            $validatedData['obs2'] = "sin comentarios";
        }
        if (!isset($validatedData['obs2_2'])) {
            $validatedData['obs2_2'] = "sin comentarios";
        }

        try {
            UsersResponseForm2_2::create($validatedData);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
        ]);
    }
}

