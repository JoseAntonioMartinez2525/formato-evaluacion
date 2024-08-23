<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersResponseForm3_10;
class ResponseForm3_10Controller extends Controller
{
    public function store310(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_10' => 'required|numeric',
                //'comision3_10' => 'required|numeric',
                'grupalesCant' => 'required|numeric',
                'evaluarGrupales' => 'required|numeric',
                'evaluarIndividual' => 'required|numeric',
                'individualCant' => 'required|numeric',
                'obsGrupal' => 'nullable|string',
                'obsIndividual' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',


            ]);

            // Assign default value if not provided
            $validatedData['obsGrupal'] = $validatedData['obsGrupal'] ?? 'sin comentarios';
            $validatedData['obsIndividual'] = $validatedData['obsIndividual'] ?? 'sin comentarios';


            // Create a new record using Eloquent ORM
            UsersResponseForm3_10::create($validatedData);

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

    public function getData310(Request $request)
    {
        try {
            $data = UsersResponseForm3_10::where('user_id', $request->query('user_id'))->first();
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
