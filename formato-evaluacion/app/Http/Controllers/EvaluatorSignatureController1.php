<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\EvaluatorSignature;
use Illuminate\Http\Request;

class EvaluatorSignatureController1 extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log de entrada de solicitud
            Log::info('Received request to store evaluator signature', $request->all());
            // Validate the request data
            $validatedData = $request->validate([
                //'docente_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'evaluator_name' => 'required|string|max:255',
                /*
                'evaluator_name_2' => 'required|string|max:255',
                'evaluator_name_3' => 'required|string|max:255',
                'firma1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'firma2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                */
                'firma' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'user_type' => 'nullable|in:docente,dictaminador,'
            ]);
/*
            $signaturePaths = [];
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile('firma' . $i)) {
                    $signaturePaths['firma' . $i] = $request->file('firma' . $i)->store('signatures', 'public');
                }
            }

            EvaluatorSignature::create([
                //'dictaminador_id' => $validatedData['dictaminador_id'],
                'user_id' => $validatedData['user_id'],
                'email' => $validatedData['email'],
                'evaluator_name' => $validatedData['evaluator_name_'],
                'signature_path' => $signaturePaths['firma'] ?? null,

                'user_type' => $validatedData['user_type'],
                
            ]);

            return response()->json([
                'message' => 'Form submitted successfully!',
                'signature_urls' => array_map(fn($path) => asset('storage/' . $path), $signaturePaths),
            ], 200);
                        */
            // Cargar o crear una entrada de firma de dictaminador
            $evaluatorSignature = EvaluatorSignature::firstOrNew([
                'user_id' => $validatedData['user_id'],
                'email' => $validatedData['email']
            ]);

            $evaluatorNames = EvaluatorSignature::firstOrNew([
                'user_id' => $validatedData['user_id'],
                'email' => $validatedData['email']
            ]);

            // Comprobar si existe espacio para otra firma
            if (!$evaluatorSignature->hasAvailableSignatureSlot()) {
                return response()->json([
                    'message' => 'Ya se han registrado las tres firmas necesarias.'
                ], 400);
            }

            if (!$evaluatorNames->hasAvailableEvaluatorName()) {
                return response()->json([
                    'message' => 'Ya se han registrado los tres nombres necesarios.'
                ], 400);
            }

            // Guardar la nueva firma
            $signaturePath = $request->file('firma')->store('signatures', 'public');
            $evaluatorSignature->addSignaturePath($signaturePath);



            return response()->json([
                'message' => 'Firma guardada exitosamente.',
                'evaluator_names'=>[
                    'evaluator_name' => $evaluatorSignature->evaluator_name,
                    'evaluator_name_2' => $evaluatorSignature->evaluator_name_2,
                    'evaluator_name_3' => $evaluatorSignature->evaluator_name_3,
                ],
                'signature_urls' => [
                    'firma' => asset('storage/' . $evaluatorSignature->signature_path),
                    'firma2' => asset('storage/' . $evaluatorSignature->signature_path_2),
                    'firma3' => asset('storage/' . $evaluatorSignature->signature_path_3),
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error storing evaluator signature', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'There was an error processing your request',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function getEvaluatorSignature1(Request $request){
        Log::info('Received request for evaluator signature', $request->all());
        // Suponiendo que estás buscando por user_id o email
        //$userId = $request->input('user_id');
        $request->validate([

            'email' => 'required|exists:users,email',


        ]);

        $email = $request->input('email');
        //$userType = $request->input('user_type');
        // Buscamos el user_id y user_type asociados a ese email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        // Extraemos el user_id y user_type
        $userId = $user->id;
        $userType = $user->user_type;




        $evaluatorSignatureQuery = EvaluatorSignature::where('user_id', $userId)
            ->where('email', $email);

    

        // Si el user_type no está vacío, lo añade a la consulta
        if ($userType) {
            $evaluatorSignatureQuery->where('user_type', $userType);
        }

        // Ejecuta la consulta
        $evaluatorSignature = $evaluatorSignatureQuery->first();

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
        // Devuelve los datos con las URLs completas de las firmas
        return response()->json([
            'evaluator_name' => $evaluatorSignature->evaluator_name_1,
            'signature_path' => asset('storage/' . $evaluatorSignature->signature_path_1),

        ]);

    }
}
