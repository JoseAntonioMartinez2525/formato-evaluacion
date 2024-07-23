<?php

namespace App\Http\Controllers;

use App\Models\EvaluatorSignature;
use Illuminate\Http\Request;

class EvaluatorSignatureController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'evaluator_name' => 'required|string|max:255',
            'firma' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation as needed
        ]);

        // Store the signature file
        $signaturePath = $request->file('firma')->store('signatures', 'public');

        // Create a new record
        $evaluatorSignature = EvaluatorSignature::create([
            'user_id' => $validatedData['user_id'],
            'email' => $validatedData['email'],
            'evaluator_name' => $validatedData['evaluator_name'],
            'signature_path' => $signaturePath,
        ]);

        // Return response with the signature URL
        return response()->json([
            'message' => 'Form submitted successfully!',
            'signature_url' => asset('storage/' . $signaturePath), // Return the URL of the stored image
        ], 200);
    }

    public function get(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is required'
            ], 400);
        }

        $data = EvaluatorSignature::where('user_id', $userId)->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the given user ID'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
