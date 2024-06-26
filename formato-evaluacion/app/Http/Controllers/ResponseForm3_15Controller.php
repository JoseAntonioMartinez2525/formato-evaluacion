<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm3_15;
use Illuminate\Http\Request;

class ResponseForm3_15Controller extends Controller
{
    public function store315(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_15' => 'required|numeric',
                'comision3_15' => 'required|numeric',
                'obsPatentes' => 'nullable|string',
                'obsPrototipos' => 'nullable|string',


            ]);

            // Assign default value if not provided
            $validatedData['obsPatentes'] = $validatedData['obsPatentes'] ?? 'sin comentarios';
            $validatedData['obsPrototipos'] = $validatedData['obsPrototipos'] ?? 'sin comentarios';


            // Create a new record using Eloquent ORM
            UsersResponseForm3_15::create($validatedData);

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

    public function getData315(Request $request)
    {
        try {
            $data = UsersResponseForm3_15::where('user_id', $request->query('user_id'))->first();
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
