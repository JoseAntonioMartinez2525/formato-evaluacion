<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm3_12;
use Illuminate\Http\Request;

class ResponseForm3_12Controller extends Controller
{
    public function store312(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_12' => 'required|numeric',
                'comision3_12' => 'required|numeric',
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

            ]);

            // Assign default value if not provided
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
            


            // Create a new record using Eloquent ORM
            UsersResponseForm3_12::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Form submitted successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            \Log::error('Validation error: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log other errors
            \Log::error('Error submitting form: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error submitting form: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getData312(Request $request)
    {
        try {
            $data = UsersResponseForm3_12::where('user_id', $request->query('user_id'))->first();
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error retrieving data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
