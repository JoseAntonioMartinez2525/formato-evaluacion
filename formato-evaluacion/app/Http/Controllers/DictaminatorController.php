<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm2;
use App\Models\UsersResponseForm2_2;
use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener el modelo User

class DictaminatorController extends Controller
{
    public function getDocentes()
    {
        $docentes = User::where('user_type', 'docente')->get(['email']);
        return response()->json($docentes);
    }

    public function getDocenteData(Request $request)
    {
        $email = $request->query('email');
        $docente = User::where('email', $email)->first();

        if (!$docente) {
            return response()->json(['error' => 'Docente not found'], 404);
        }

        // Aquí deberás ajustar la lógica según cómo almacenas los datos de `form2` y `form2_2`
        $form2Data = UsersResponseForm2::where('user_id', $docente->id)->first();
        $form2_2Data = UsersResponseForm2_2::where('user_id', $docente->id)->first();

        return response()->json([
            'form2' => $form2Data,
            'form2_2' => $form2_2Data,
        ]);
    }
}

