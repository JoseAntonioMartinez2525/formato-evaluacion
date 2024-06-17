<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\UsersResponseForm3_1;

class ResponseForm3_1Controller extends Controller
{
    public function store31(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'score3_1' => 'required|numeric',
            'actv3Comision' => 'required|numeric',
            'obs3_1_1' => 'string',
            'obs3_1_2' => 'string',
            'obs3_1_3' => 'string',
            'obs3_1_4' => 'string',
            'obs3_1_5' => 'string',

        ]);

        // Assign a default value if puntajeEvaluar is not provided
        if (!isset($validatedData['puntajeEvaluar'])) {
            $validatedData['puntajeEvaluar'] = 0;
        }
        if (!isset($validatedData['obs3_1_1']) || !isset($validatedData['obs3_1_2']) || !isset($validatedData['obs3_1_3']) ||
         !isset($validatedData['obs3_1_4']) || !isset($validatedData['obs3_1_5'])) {
            $validatedData['obs3_1_1'] = "sin comentarios";
            $validatedData['obs3_1_2'] = "sin comentarios";
            $validatedData['obs3_1_3'] = "sin comentarios";
            $validatedData['obs3_1_4'] = "sin comentarios";
            $validatedData['obs3_1_5'] = "sin comentarios";
        }


        try {
            UsersResponseForm3_1::create($validatedData);
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
