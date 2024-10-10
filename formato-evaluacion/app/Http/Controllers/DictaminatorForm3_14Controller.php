<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_14;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_14Controller extends TransferController
{
    public function storeform314(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_14' => 'required|numeric',
                'comision3_14' => 'required|numeric',
                'cantCongresoInt' => 'required|numeric',
                'subtotalCongresoInt' => 'required|numeric',
                'comisionCongresoInt' => 'required|numeric',
                'cantCongresoNac' => 'required|numeric',
                'subtotalCongresoNac' => 'required|numeric',
                'comisionCongresoNac' => 'required|numeric',
                'cantCongresoLoc' => 'required|numeric',
                'subtotalCongresoLoc' => 'required|numeric',
                'comisionCongresoLoc' => 'required|numeric',
                'obsCongresoInt' => 'nullable|string',
                'obsCongresoNac' => 'nullable|string',
                'obsCongresoLoc' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_14'])) {
                $validatedData['score3_14'] = 0;
            }
            $validatedData['obsCongresoInt'] = $validatedData['obsCongresoInt'] ?? 'sin comentarios';
            $validatedData['obsCongresoNac'] = $validatedData['obsCongresoNac'] ?? 'sin comentarios';
            $validatedData['obsCongresoLoc'] = $validatedData['obsCongresoLoc'] ?? 'sin comentarios';
 

            DictaminatorsResponseForm3_14::create($validatedData);
            $this->checkAndTransfer('DictaminatorsResponseForm3_14');
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
            ], 500); // Cambiado de 1200 a 500
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500); // Cambiado de 1200 a 500
        }

    }

    public function getFormData314(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_14::where('user_id', $request->query('user_id'))->first();
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
}

