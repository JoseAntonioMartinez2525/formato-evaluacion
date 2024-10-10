<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_16;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_16Controller extends TransferController
{
    public function storeform316(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_16' => 'required|numeric',
                'comision3_16' => 'required|numeric',
                'cantArbInt' => 'required|numeric',
                'cantArbNac' => 'required|numeric',
                'cantPubInt' => 'required|numeric',
                'cantPubNac' => 'required|numeric',
                'cantRevInt' => 'required|numeric',
                'cantRevNac' => 'required|numeric',
                'cantRevista' => 'required|numeric',
                'subtotalArbInt' => 'required|numeric',
                'subtotalArbNac' => 'required|numeric',
                'subtotalPubInt' => 'required|numeric',
                'subtotalPubNac' => 'required|numeric',
                'subtotalRevInt' => 'required|numeric',
                'subtotalRevNac' => 'required|numeric',
                'subtotalRevista' => 'required|numeric',
                'comisionArbInt' => 'required|numeric',
                'comisionArbNac' => 'required|numeric',
                'comisionPubInt' => 'required|numeric',
                'comisionPubNac' => 'required|numeric',
                'comisionRevInt' => 'required|numeric',
                'comisionRevNac' => 'required|numeric',
                'comisionRevista' => 'required|numeric',
                'obsArbInt' => 'nullable|string',
                'obsArbNac' => 'nullable|string',
                'obsPubInt' => 'nullable|string',
                'obsPubNac' => 'nullable|string',
                'obsRevInt' => 'nullable|string',
                'obsRevNac' => 'nullable|string',
                'obsRevista' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_16'])) {
                $validatedData['score3_16'] = 0;
            }
            $validatedData['obsArbInt'] = $validatedData['obsArbInt'] ?? 'sin comentarios';
            $validatedData['obsArbNac'] = $validatedData['obsArbNac'] ?? 'sin comentarios';
            $validatedData['obsPubInt'] = $validatedData['obsPubInt'] ?? 'sin comentarios';
            $validatedData['obsPubNac'] = $validatedData['obsPubNac'] ?? 'sin comentarios';
            $validatedData['obsRevInt'] = $validatedData['obsRevInt'] ?? 'sin comentarios';
            $validatedData['obsRevNac'] = $validatedData['obsRevNac'] ?? 'sin comentarios'; 
            $validatedData['obsRevista'] = $validatedData['obsRevista'] ?? 'sin comentarios';


            DictaminatorsResponseForm3_16::create($validatedData);
            $this->checkAndTransfer('DictaminatorsResponseForm3_16');
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

    public function getFormData316(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_16::where('user_id', $request->query('user_id'))->first();
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

