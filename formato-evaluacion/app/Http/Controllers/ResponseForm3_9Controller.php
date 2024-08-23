<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersResponseForm3_9;
class ResponseForm3_9Controller extends Controller
{
    public function store39(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_9' => 'required|numeric',
                //'comision3_9' => 'required|numeric',
                'obs3_9_1' => 'nullable|string',
                'obs3_9_2' => 'nullable|string',
                'obs3_9_3' => 'nullable|string',
                'obs3_9_4' => 'nullable|string',
                'obs3_9_5' => 'nullable|string',
                'obs3_9_6' => 'nullable|string',
                'obs3_9_7' => 'nullable|string',
                'obs3_9_8' => 'nullable|string',
                'obs3_9_9' => 'nullable|string',
                'obs3_9_10' => 'nullable|string',
                'obs3_9_11' => 'nullable|string',
                'obs3_9_12' => 'nullable|string',
                'obs3_9_13' => 'nullable|string',
                'obs3_9_14' => 'nullable|string',
                'obs3_9_15' => 'nullable|string',
                'obs3_9_16' => 'nullable|string',
                'obs3_9_17' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',

            
            ]);

            // Assign default value if not provided
            for ($i=1; $i <=17 ; $i++) {
                $validatedData["obs3_9_$i"] = $validatedData["obs3_9_$i"] ?? 'sin comentarios';
            }
            

            // Create a new record using Eloquent ORM
            UsersResponseForm3_9::create($validatedData);

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

    public function getData39(Request $request)
    {
        try {
            $data = UsersResponseForm3_9::where('user_id', $request->query('user_id'))->first();
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
