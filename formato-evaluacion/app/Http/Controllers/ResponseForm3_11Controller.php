<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersResponseForm3_11;
class ResponseForm3_11Controller extends Controller
{
    public function store311(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_11' => 'required|numeric',
                'comision3_11' => 'required|numeric',
                'obs3_11_1' => 'nullable|string',
                'obs3_11_2' => 'nullable|string',
                'obs3_11_3' => 'nullable|string',


            ]);

            // Assign default value if not provided
            $validatedData['obs3_11_1'] = $validatedData['obs3_11_1'] ?? 'sin comentarios';
            $validatedData['obs3_11_2'] = $validatedData['obs3_11_2'] ?? 'sin comentarios';
            $validatedData['obs3_11_3'] = $validatedData['obs3_11_3'] ?? 'sin comentarios';


            // Create a new record using Eloquent ORM
            UsersResponseForm3_11::create($validatedData);

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

    public function getData311(Request $request)
    {
        try {
            $data = UsersResponseForm3_11::where('user_id', $request->query('user_id'))->first();
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
