<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_17;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_17Controller extends TransferController
{
    public function storeform317(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_17' => 'required|numeric',
                'comision3_17' => 'required|numeric',
                'cantDifusionExt' => 'required|numeric',
                'cantDifusionInt' => 'required|numeric',
                'cantRepDifusionExt' => 'required|numeric',
                'cantRepDifusionInt' => 'required|numeric',
                'subtotalDifusionExt' => 'required|numeric',
                'subtotalDifusionInt' => 'required|numeric',
                'subtotalRepDifusionExt' => 'required|numeric',
                'subtotalRepDifusionInt' => 'required|numeric',
                'comisionDifusionExt' => 'required|numeric',
                'comisionDifusionInt' => 'required|numeric',
                'comisionRepDifusionExt' => 'required|numeric',
                'comisionRepDifusionInt' => 'required|numeric',
                'obsDifusionExt' => 'nullable|string',
                'obsDifusionInt' => 'nullable|string',
                'obsRepDifusionExt' => 'nullable|string',
                'obsRepDifusionInt' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_17'])) {
                $validatedData['score3_17'] = 0;
            }
            $validatedData['obsDifusionExt'] = $validatedData['obsDifusionExt'] ?? 'sin comentarios';
            $validatedData['obsDifusionInt'] = $validatedData['obsDifusionInt'] ?? 'sin comentarios';
            $validatedData['obsRepDifusionExt'] = $validatedData['obsRepDifusionExt'] ?? 'sin comentarios';
            $validatedData['obsRepDifusionInt'] = $validatedData['obsRepDifusionInt'] ?? 'sin comentarios';




            DictaminatorsResponseForm3_17::create($validatedData);
            $this->checkAndTransfer('DictaminatorsResponseForm3_17');
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
            ], 500); 
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500); 
        }

    }

    public function getFormData317(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_17::where('user_id', $request->query('user_id'))->first();
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

