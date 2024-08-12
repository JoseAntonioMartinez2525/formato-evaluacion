<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DictaminatorsResponseForm2_2;
use Illuminate\Database\QueryException;

class DictaminatorForm2_2Controller extends Controller
{
    public function storeform22(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'hours' => 'required|numeric',
            'horasPosgrado' => 'required|numeric', // Allow nullable
            'horasSemestre' => 'required|numeric',
            'dse' => 'required|numeric',
            'dse2' => 'required|numeric',
            'comision1' => 'required|numeric',
            'obs2' => 'nullable|string',
            'obs2_2' => 'nullable|string',
            'user_type' => 'required|in:user,docente,dictaminator',
        ]);

        if (!isset($validatedData['hours'])) {
            $validatedData['hours'] = 0;
        }
        $validatedData['obs2'] = $validatedData['obs2'] ?? 'sin comentarios';
        $validatedData['obs2_2'] = $validatedData['obs2_2'] ?? 'sin comentarios';

        try {
            DictaminatorsResponseForm2_2::create($validatedData);
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

    public function getFormData22(Request $request)
    {

        $data = DictaminatorsResponseForm2_2::where('user_id', $request->query('user_id'))->first();
        return response()->json($data);
    }
}
