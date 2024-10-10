<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_6;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_6Controller extends TransferController
{
    public function storeform36(Request $request)
    {


        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_6' => 'required|numeric',
                'comision3_6' => 'required|numeric',
                'comisionDict3_6' => 'required|numeric',
                'puntaje3_6' => 'required|numeric',
                'puntajeHoras3_6' => 'required|numeric',
                'obs3_6_1' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_6'])) {
                $validatedData['score3_6'] = 0;
            }
            $validatedData['obs3_6_1'] = $validatedData['obs3_6_1'] ?? 'sin comentarios';




            DictaminatorsResponseForm3_6::create($validatedData);
            $this->checkAndTransfer('DictaminatorsResponseForm3_6');
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
            ], 600);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 600);
        }
    }

    public function getFormData36(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_6::where('user_id', $request->query('user_id'))->first();
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
            ], 600);
        }

    }
}

