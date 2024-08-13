<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm2;
use App\Models\UsersResponseForm2_2;
use App\Models\UsersResponseForm3_1;
use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener el modelo User

class DictaminatorController extends Controller
{
    public function getDocentes()
    {
        $docentes = User::where('user_type', 'docente')->get(['email']);
        \Log::info('Docentes:', $docentes->toArray());
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
        $form3_1Data = UsersResponseForm3_1::where('user_id', $docente->id)->first();

        // Return a structured response which includes both form data
        return response()->json([
            'docente' => [
                'id' => $docente->id,
                'email' => $docente->email,
            ],
            'form2' => $form2Data,    // existing fields can still be accessed
            'form2_2' => $form2_2Data,  // potentially useful for this view
            'form3_1' => $form3_1Data
        ]);
    }
}

