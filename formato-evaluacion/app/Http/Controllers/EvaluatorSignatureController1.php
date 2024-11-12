<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\EvaluatorSignature;
use Illuminate\Http\Request;

class EvaluatorSignatureController1 extends Controller
{
    public function storeEvaluatorSignature(Request $request)
    {
        try {
            // Log de entrada de solicitud
            Log::info('Received request to store evaluator signature', $request->all());
            // Validate the request data
            $validatedData = $request->validate([
                //'dictaminador_id' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'evaluator_name' => 'required|string|max:255',
                'firma' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'user_type' => 'nullable|in:docente,dictaminador,'
            ]);
/*
          
                        */
            // Cargar o crear una entrada de firma de dictaminador
            $evaluatorSignature = EvaluatorSignature::updateOrCreate(
            [
                'user_id' => $validatedData['user_id'],
                'email' => $validatedData['email']
            ]);

            $evaluatorNames = EvaluatorSignature::updateOrCreate([
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
            $evaluatorSignature->addEvaluatorName($validatedData['evaluator_name']);
            $evaluatorSignature->addSignaturePath($signaturePath);
            $evaluatorSignature->save();

            //verificar que los nombres se puedan repetir en caso de que se evalue a otro docente



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

    public function getEvaluatorSignature(Request $request){
        Log::info('Received request for evaluator signature', $request->all());
        // Suponiendo que estás buscando por user_id o email
        //$userId = $request->input('user_id');
        $request->validate([
            //'user_id'=> 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'evaluator_name'=>'exists:evaluador_por_firmas,evaluator_name',
            'evaluator_name_2' => 'exists:evaluador_por_firmas,evaluator_name_2',
            'evaluator_name_3' => 'exists:evaluador_por_firmas,evaluator_name_3',
            'signature_path' => 'exists:evaluador_por_firmas,signature_path',
            'signature_path_2' => 'exists:evaluador_por_firmas,signature_path_2',
            'signature_path_3' => 'exists:evaluador_por_firmas,signature_path_3',

        ]);

        $email = $request->input('email');
        //$userType = $request->input('user_type');
        // Buscamos el user_id y user_type asociados a ese email
       
        if ($request->has('user_id')) {
            $userId = $request->input('user_id');
        } else {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
            $userId = $user->id;
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

        Log::info('Received email:', ['email' => $email]);
        Log::info('User ID:', ['user_id' => $userId]);
        Log::info('User Type:', ['user_type' => $userType]);

        // Maneja el caso en el que no se encuentra el registro
        if (!$evaluatorSignature) {
            Log::warning('Evaluator signature not found', ['email' => $email]);
            
            return response()->json([
                'message' => "Evaluator signature not found for `$email`",
            ], 404);
        }
        // Log data to check
        Log::info('Evaluator signature data:', ($evaluatorSignature)->toArray());
        // Devuelve los datos como JSON
        // Devuelve los datos con las URLs completas de las firmas
        return response()->json([
            //'user_id'=> $evaluatorSignature->userId,
            'email'=>$evaluatorSignature->email,
            'evaluator_name' => $evaluatorSignature->evaluator_name,
            'evaluator_name_2' => $evaluatorSignature->evaluator_name_2,
            'evaluator_name_3' => $evaluatorSignature->evaluator_name_3,
            'signature_path' => asset('storage/' . $evaluatorSignature->signature_path),
            'signature_path_2' => asset('storage/' . $evaluatorSignature->signature_path_2),
            'signature_path_3' => asset('storage/' . $evaluatorSignature->signature_path_3),

        ]);

    }
}
