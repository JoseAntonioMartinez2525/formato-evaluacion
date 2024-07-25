<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\EvaluatorSignature;
use Illuminate\Http\Request;

class EvaluatorSignatureController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log de entrada de solicitud
            Log::info('Received request to store evaluator signature', $request->all());
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

            // Log de éxito
            Log::info('Evaluator signature stored successfully', ['signature_path' => $signaturePath]);
            // Return response with the signature URL
            return response()->json([
                'message' => 'Form submitted successfully!',
                'signature_url' => asset('storage/' . $signaturePath),
            ], 200);

        } catch (\Exception $e) {
            // Log de error
            Log::error('Error storing evaluator signature', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'There was an error processing your request',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getEvaluatorSignature(Request $request){
        Log::info('Received request for evaluator signature', $request->all());
        // Suponiendo que estás buscando por user_id o email
        $userId = $request->input('user_id');
        $email = $request->input('email');
        

        // Valida los datos de entrada
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            
        ]);

        // Obtén los datos de la firma del evaluador
        $evaluatorSignature = EvaluatorSignature::where('user_id', $userId)
            ->where('email', $email)
            ->first();

        // Maneja el caso en el que no se encuentra el registro
        if (!$evaluatorSignature) {
            Log::warning('Evaluator signature not found', ['user_id' => $userId, 'email' => $email]);
            return response()->json([
                'message' => 'Evaluator signature not found',
            ], 404);
        }
        // Log data to check
        Log::info('Evaluator signature data:', ($evaluatorSignature)->toArray());
        // Devuelve los datos como JSON
        return response()->json($evaluatorSignature);

    }
}
