<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_12;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DictaminatorForm3_12Controller extends Controller
{
    public function storeform312(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_12' => 'required|numeric',
                'comision3_12' => 'required|numeric',
                'cantCientifico' => 'required|numeric',
                'subtotalCientificos' => 'required|numeric',
                'comisionCientificos' => 'required|numeric',
                'cantDivulgacion' => 'required|numeric',
                'subtotalDivulgacion' => 'required|numeric',
                'comisionDivulgacion' => 'required|numeric',
                'cantTraduccion' => 'required|numeric',
                'subtotalTraduccion' => 'required|numeric',
                'comisionTraduccion' => 'required|numeric',
                'cantArbitrajeInt' => 'required|numeric',
                'subtotalArbitrajeInt' => 'required|numeric',
                'comisionArbitrajeInt' => 'required|numeric',
                'cantArbitrajeNac' => 'required|numeric',
                'subtotalArbitrajeNac' => 'required|numeric',
                'comisionArbitrajeNac' => 'required|numeric',
                'cantSinInt' => 'required|numeric',
                'subtotalSinInt' => 'required|numeric',
                'comisionSinInt' => 'required|numeric',
                'cantSinNac' => 'required|numeric',
                'subtotalSinNac' => 'required|numeric',
                'comisionSinNac' => 'required|numeric',
                'cantAutor' => 'required|numeric',
                'subtotalAutor' => 'required|numeric',
                'comisionAutor' => 'required|numeric',
                'cantEditor' => 'required|numeric',
                'subtotalEditor' => 'required|numeric',
                'comisionEditor' => 'required|numeric',
                'cantWeb' => 'required|numeric',
                'subtotalWeb' => 'required|numeric',
                'comisionWeb' => 'required|numeric',
                'obsCientificos' => 'nullable|string',
                'obsDivulgacion' => 'nullable|string',
                'obsTraduccion' => 'nullable|string',
                'obsArbitrajeInt' => 'nullable|string',
                'obsArbitrajeNac' => 'nullable|string',
                'obsSinInt' => 'nullable|string',
                'obsSinNac' => 'nullable|string',
                'obsAutor' => 'nullable|string',
                'obsEditor' => 'nullable|string',
                'obsWeb' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            if (!isset($validatedData['score3_12'])) {
                $validatedData['score3_12'] = 0;
            }
            $validatedData['obsCientificos'] = $validatedData['obsCientificos'] ?? 'sin comentarios';
            $validatedData['obsDivulgacion'] = $validatedData['obsDivulgacion'] ?? 'sin comentarios';
            $validatedData['obsTraduccion'] = $validatedData['obsTraduccion'] ?? 'sin comentarios';
            $validatedData['obsArbitrajeInt'] = $validatedData['obsArbitrajeInt'] ?? 'sin comentarios';
            $validatedData['obsArbitrajeNac'] = $validatedData['obsArbitrajeNac'] ?? 'sin comentarios';
            $validatedData['obsSinInt'] = $validatedData['obsSinInt'] ?? 'sin comentarios';
            $validatedData['obsSinNac'] = $validatedData['obsSinNac'] ?? 'sin comentarios';
            $validatedData['obsAutor'] = $validatedData['obsAutor'] ?? 'sin comentarios';
            $validatedData['obsEditor'] = $validatedData['obsEditor'] ?? 'sin comentarios';
            $validatedData['obsWeb'] = $validatedData['obsWeb'] ?? 'sin comentarios';



            DictaminatorsResponseForm3_12::create($validatedData);
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

    public function getFormData312(Request $request)
    {
        try {
            $data = DictaminatorsResponseForm3_12::where('user_id', $request->query('user_id'))->first();
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

