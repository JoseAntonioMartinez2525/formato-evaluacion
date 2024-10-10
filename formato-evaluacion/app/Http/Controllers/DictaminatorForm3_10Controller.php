<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_10;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_10Controller extends TransferController
{
    public function storeform310(Request $request)
    {


        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_10' => 'required|numeric',
                'comision3_10' => 'required|numeric',
                'comisionGrupal' => 'required|numeric',
                'comisionIndividual' => 'required|numeric',
                'grupalesCant' => 'required|numeric',
                'evaluarGrupales' => 'required|numeric',
                'evaluarIndividual' => 'required|numeric',
                'individualCant' => 'required|numeric',
                'obsGrupal' => 'nullable|string',
                'obsIndividual' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_10'])) {
                $validatedData['score3_10'] = 0;
            }
            $validatedData['obsGrupal'] = $validatedData['obsGrupal'] ?? 'sin comentarios';
            $validatedData['obsIndividual'] = $validatedData['obsIndividual'] ?? 'sin comentarios';
            



            DictaminatorsResponseForm3_10::create($validatedData);
            $this->checkAndTransfer('DictaminatorsResponseForm3_10');
            
            return response()->json([
                'success' => true,
                'message' => 'Data successfully saved',
                'data' => $validatedData,
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
            ], 500); // Cambiado de 1000 a 500
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500); // Cambiado de 1000 a 500
        }

    }

    public function getFormData310(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_10::where('user_id', $request->query('user_id'))->first();
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
            ], 1000);
        }

    }
}

