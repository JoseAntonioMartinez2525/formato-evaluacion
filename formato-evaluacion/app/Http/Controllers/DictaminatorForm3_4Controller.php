<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_4;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_4Controller extends Controller
{
    public function storeform34(Request $request)
    {


        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_4' => 'required|numeric',
                'comision3_4' => 'required|numeric',
                'cantInternacional' => 'required|numeric',
                'cantNacional' => 'required|numeric',
                'cantidadRegional' => 'required|numeric',
                'cantPreparacion' => 'required|numeric',
                'cantInternacional2' => 'required|numeric',
                'cantNacional2' => 'required|numeric',
                'cantidadRegional2' => 'required|numeric',
                'cantPreparacion2' => 'required|numeric',
                'comInternacional' => 'required|numeric',
                'comNacional' => 'required|numeric',
                'comRegional' => 'required|numeric',
                'comPreparacion' => 'required|numeric',
                'obs3_4_1' => 'nullable|string',
                'obs3_4_2' => 'nullable|string',
                'obs3_4_3' => 'nullable|string',
                'obs3_4_4' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_4'])) {
                $validatedData['score3_4'] = 0;
            }
            $validatedData['obs3_4_1'] = $validatedData['obs3_4_1'] ?? 'sin comentarios';
            $validatedData['obs3_4_2'] = $validatedData['obs3_4_2'] ?? 'sin comentarios';
            $validatedData['obs3_4_3'] = $validatedData['obs3_4_3'] ?? 'sin comentarios';
            $validatedData['obs3_4_4'] = $validatedData['obs3_4_4'] ?? 'sin comentarios';


            DictaminatorsResponseForm3_4::create($validatedData);
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

    public function getFormData34(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_4::where('user_id', $request->query('user_id'))->first();
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

