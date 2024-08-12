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
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'horasActv2' => 'required|numeric',
                'puntajeEvaluar' => 'required|numeric', 
                'comision1' => 'required|numeric',
                'obs1' => 'nullable|string',
                'user_type' => 'required|in:user,dictaminator',
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
            $data = DictaminatorsResponseForm2::where('user_id', $request->query('user_id'))->first();

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
