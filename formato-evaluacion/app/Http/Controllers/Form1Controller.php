<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm1;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DictaminatorsResponseForm2;
use App\Models\DictaminatorsResponseForm2_2;
use App\Models\DictaminatorsResponseForm3_1;

class Form1Controller extends Controller
{

    public function getDictaminadores()
    {
        $dictaminador = User::where('user_type', 'dictaminador')->get(['email']);
        \Log::info('Dictaminador:', $dictaminador->toArray());
        return response()->json($dictaminador);
    }

    public function getDictaminadorData(Request $request)
    {
        $email = $request->query('email');
        $dictaminador = User::where('email', $email)->first();
        //$docentes = User::where('user_type', 'docente')->get(['email']);

        if (!$dictaminador) {
            return response()->json(['error' => 'Dictaminador not found'], 404);
        }

        // Almacenamiento de formularios
 
        $form2Data = DictaminatorsResponseForm2::where('user_id', $dictaminador->id)->first();
        $form2_2Data = DictaminatorsResponseForm2_2::where('user_id', $dictaminador->id)->first();
        $form3_1Data = DictaminatorsResponseForm3_1::where('user_id', $dictaminador->id)->first();

        // Return a structured response which includes both form data
        return response()->json([
            'dictaminador' => [
                'id' => $dictaminador->id,
                'email' => $dictaminador->email,
            ],
            //'form1'=>$form1Data,
            'form2' => $form2Data,    // existing fields can still be accessed
            'form2_2' => $form2_2Data,  // potentially useful for this view
            'form3_1' => $form3_1Data
        ]);
    }
}