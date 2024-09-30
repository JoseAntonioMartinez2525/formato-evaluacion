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
        //$dictaminador_id = $request->query('dictaminador_id');

        \Log::info('Email recibido:', ['email' => $email]);
        //\Log::info('Dictaminador ID recibido:', ['dictaminador_id' => $dictaminador_id]);

        $dictaminador = User::where('email', $email)
            ->first();

        if (!$dictaminador) {
            return response()->json(['error' => 'Dictaminador not found'], 404);
        }

        $formFinalData = DB::table('consolidated_responses')
            ->join('users_final_resume', 'consolidated_responses.user_email', '=', 'users_final_resume.email')
            ->where('consolidated_responses.user_email', $email)
            ->select('consolidated_responses.*', 'users_final_resume.*')
            ->first();

        if ($request->ajax()) {
            return response()->json($formFinalData);
        }

        return view('resumen_comision', compact('formFinalData'));
    }

}
