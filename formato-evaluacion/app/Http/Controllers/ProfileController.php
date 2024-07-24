<?php

namespace App\Http\Controllers;

use App\Models\UserResume;
use App\Models\EvaluatorSignature;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile(Request $request)
    {
        $userId = $request->input('user_id');
        $email = $request->input('email');

        // Validar los datos de entrada
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
        ]);

        // Obtener datos del formulario 4 (UserResume)
        $userResume = UserResume::where('user_id', $userId)
            ->where('email', $email)
            ->first();

        // Obtener datos del formulario 5 (EvaluatorSignature)
        $evaluatorSignature = EvaluatorSignature::where('user_id', $userId)
            ->where('email', $email)
            ->first();

        if (!$userResume || !$evaluatorSignature) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        }

        // Pasar los datos a la vista
        return view('perfil', [
            'userResume' => $userResume,
            'evaluatorSignature' => $evaluatorSignature,
        ]);
    }
}
