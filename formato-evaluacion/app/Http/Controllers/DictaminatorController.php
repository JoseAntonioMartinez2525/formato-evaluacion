<?php

namespace App\Http\Controllers;

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

        if ($docente) {
            // Aquí deberás devolver los datos específicos del docente.
            // Esto puede requerir que consultes otras tablas o modelos.
            $data = [
                'horasActv2' => $docente->horasActv2,
                'puntajeEvaluar' => $docente->puntajeEvaluar,
                'hours' => $docente->hours,
                'horasPosgrado' => $docente->horasPosgrado,
                'horasSemestre' => $docente->horasSemestre,
                'dse' => $docente->dse,
                'dse2' => $docente->dse2,
            ];

            return response()->json($data);
        }

        return response()->json(['error' => 'Docente no encontrado'], 404);
    }
}

