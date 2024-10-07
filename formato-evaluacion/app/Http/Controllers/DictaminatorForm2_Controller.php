<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DictaminatorsResponseForm2;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm2_Controller extends Controller
{
    public function storeform2(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'dictaminador_id'=>'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'horasActv2' => 'required|numeric',
                'puntajeEvaluar' => 'required|numeric', 
                'comision1' => 'required|numeric',
                'obs1' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            // Default values for optional fields
            if (!isset($validatedData['puntajeEvaluar'])) {
                $validatedData['puntajeEvaluar'] = 0;
            }
            if (!isset($validatedData['obs1'])) {
                $validatedData['obs1'] = "sin comentarios";
            }

            DictaminatorsResponseForm2::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Data successfully saved',
                'data' => $validatedData
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getFormData2(Request $request)
    {
        try {
 
            // Check if dictaminador_id is present in the request
            if (!$request->has('dictaminador_id')) {
                return response()->json(['error' => 'dictaminador_id is required'], 400);
            }
            
            $data = DictaminatorsResponseForm2::where('dictaminador_id', $request->query('dictaminador_id'))->first();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving data: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getConvocatoria($user_id)
    {
        // Obtener el registro de dictaminators_response_form2 por el dictaminador_id
        $dictaminatorResponse = DictaminatorsResponseForm2::where('user_id', $user_id)->first();

        if (!$dictaminatorResponse) {
            return response()->json(['error' => 'No se encontró la respuesta para el dictaminador'], 404);
        }

        // Obtener la convocatoria a través de la relación con UsersResponseForm1
        $convocatoria = $dictaminatorResponse->UsersResponseForm1->convocatoria ?? 'No hay convocatoria';

        // Devolver los datos en la respuesta o pasarlos a la vista
        return view('resumen_comision', compact('convocatoria'));
    }
}
