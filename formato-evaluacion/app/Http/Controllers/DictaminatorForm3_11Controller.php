<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_11;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_11Controller extends Controller
{
    public function storeform311(Request $request)
    {


        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_11' => 'required|numeric',
                'comision3_11' => 'required|numeric',
                'cantAsesoria' => 'required|numeric',
                'cantServicio' => 'required|numeric',
                'cantPracticas' => 'required|numeric',
                'subtotalAsesoria' => 'required|numeric',
                'subtotalServicio' => 'required|numeric',
                'subtotalPracticas' => 'required|numeric',
                'comisionAsesoria' => 'required|numeric',
                'comisionServicio' => 'required|numeric',
                'comisionPracticas' => 'required|numeric',
                'obsAsesoria' => 'nullable|string',
                'obsServicio' => 'nullable|string',
                'obsPracticas' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_11'])) {
                $validatedData['score3_11'] = 0;
            }
            $validatedData['obsAsesoria'] = $validatedData['obsAsesoria'] ?? 'sin comentarios';
            $validatedData['obsServicio'] = $validatedData['obsServicio'] ?? 'sin comentarios';
            $validatedData['obsPracticas'] = $validatedData['obsPracticas'] ?? 'sin comentarios';



            DictaminatorsResponseForm3_11::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Data successfully saved',
                'data' => $validatedData,
            ], 1100);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 41111);
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

    public function getFormData311(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_11::where('user_id', $request->query('user_id'))->first();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ], 1100);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving data: ' . $e->getMessage(),
            ], 500);
        }

    }
}

