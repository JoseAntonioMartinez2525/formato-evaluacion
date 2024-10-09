<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumenComisionController extends Controller
{

    public function getDictaminadoresFinalData()
    {
        $dictaminador = User::where('user_type', 'dictaminador')->get(['id', 'email']);
        \Log::info('Dictaminador:', $dictaminador->toArray());
        return response()->json($dictaminador);
    }
    public function getDictaminadorFinalData(Request $request)
    {
        $email = $request->query('email');

        \Log::info('Email recibido:', ['email' => $email]);

        $dictaminador = User::where('email', $email)->first();

        if (!$dictaminador) {
            return response()->json(['error' => 'Dictaminador not found'], 404);
        }

        $formFinalData = DB::table('consolidated_responses')
            ->join('users_final_resume', 'consolidated_responses.user_email', '=', 'users_final_resume.email')
            ->where('consolidated_responses.user_email', $email)
            ->select('consolidated_responses.*', 'users_final_resume.*')
            ->first();

        

        if (!$formFinalData) {
            return response()->json(['error' => 'Datos del formulario no encontrados'], 404);
        }

        // Retornar siempre una respuesta JSON
        return response()->json($formFinalData);
    }

    public function fetchConvocatoria($user_id)
    {
        \Log::info('User ID recibido:', ['user_id' => $user_id]);

        $convocatoria = DB::table('users_response_form1')
            ->where('user_id', $user_id)
            ->value('convocatoria');

        if (!$convocatoria) {
            return response()->json(['error' => 'Convocatoria not found'], 404);
        }

        \Log::info('Convocatoria encontrada:', ['convocatoria' => $convocatoria]);

        return response()->json(['convocatoria' => $convocatoria]);
    }



}
