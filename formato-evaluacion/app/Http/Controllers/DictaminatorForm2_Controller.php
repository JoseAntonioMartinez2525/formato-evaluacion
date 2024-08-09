<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DictaminatorsResponseForm2;
use Illuminate\Database\QueryException;
class DictaminatorForm2_Controller extends Controller
{
    public function storeform2(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'horasActv2' => 'required|numeric',
            'puntajeEvaluar' => 'required|numeric', // Allow nullable
            'comision1' => 'required|numeric',
            'obs1' => 'nullable|string',
            'user_type' => 'required|in:user,dictaminator',
        ]);

        // Assign a default value if puntajeEvaluar is not provided
        if (!isset($validatedData['puntajeEvaluar'])) {
            $validatedData['puntajeEvaluar'] = 0;
        }
        if (!isset($validatedData['obs1'])) {
            $validatedData['obs1'] = "sin comentarios";
        }

        try {
            DictaminatorsResponseForm2::create($validatedData);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json(['success' => true, 'message' => 'Received data', 'data' => $request->all()]);
    }

    public function getFormData2(Request $request)
    {

        $data = DictaminatorsResponseForm2::where('user_id', $request->query('user_id'))->first();
        return response()->json($data);
    }
}
