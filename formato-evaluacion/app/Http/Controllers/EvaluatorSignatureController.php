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
                'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'evaluator_name_1' => 'required|string|max:255',
                'evaluator_name_2' => 'required|string|max:255',
                'evaluator_name_3' => 'required|string|max:255',
                'firma1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'firma2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'firma3' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            $signaturePaths = [];
            foreach (['firma1', 'firma2', 'firma3'] as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    $signaturePaths[$fileKey] = $request->file($fileKey)->store('signatures', 'public');
                }
            }

            EvaluatorSignature::create([
                'dictaminador_id' => $validatedData['dictaminador_id'],
                'user_id' => $validatedData['user_id'],
                'email' => $validatedData['email'],
                'evaluator_name_1' => $validatedData['evaluator_name_1'],
                'evaluator_name_2' => $validatedData['evaluator_name_2'],
                'evaluator_name_3' => $validatedData['evaluator_name_3'],
                'signature_path_1' => $signaturePaths['firma1'] ?? null,
                'signature_path_2' => $signaturePaths['firma2'] ?? null,
                'signature_path_3' => $signaturePaths['firma3'] ?? null,
                'user_type' => $validatedData['user_type'],
                
            ]);

            return response()->json([
                'message' => 'Form submitted successfully!',
                'signature_urls' => array_map(fn($path) => asset('storage/' . $path), $signaturePaths),
            ], 200);
            
        } catch (\Exception $e) {
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
