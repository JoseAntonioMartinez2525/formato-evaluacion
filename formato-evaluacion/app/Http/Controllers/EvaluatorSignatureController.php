<?php

namespace App\Http\Controllers;

use App\Models\EvaluatorSignature;
use Illuminate\Http\Request;

class EvaluatorSignatureController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'evaluator_name' => 'required|string|max:255',
                'firma' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
                'signature_url' => asset('storage/' . $signaturePath),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'There was an error processing your request',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
