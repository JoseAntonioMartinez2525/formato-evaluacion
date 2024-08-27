<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_3;
use App\Models\DictaminatorsResponseForm3_4;
use App\Models\UsersResponseForm1;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DictaminatorsResponseForm2;
use App\Models\DictaminatorsResponseForm2_2;
use App\Models\DictaminatorsResponseForm3_1;
use App\Models\DictaminatorsResponseForm3_2;

class FormsController extends Controller
{
    

    public function getDictaminadores()
    {
        $dictaminador = User::where('user_type', 'dictaminador')->get(['id', 'email']);
        \Log::info('Dictaminador:', $dictaminador->toArray());
        return response()->json($dictaminador);
    }
public function getDictaminadorData(Request $request)
{
        $email = $request->query('email');
        $dictaminador_id = $request->query('dictaminador_id');
        $dictaminador = User::where('email', $email)
            ->where('id', $dictaminador_id)
            ->first();

        if (!$dictaminador) {
            return response()->json(['error' => 'Dictaminador not found'], 404);
        }

        // Aquí deberás ajustar la lógica según cómo almacenas los datos de `form2` y `form2_2`
        $form2Data = DictaminatorsResponseForm2::where('dictaminador_id', $dictaminador_id)->first();
        $form2_2Data = DictaminatorsResponseForm2_2::where('dictaminador_id', $dictaminador_id)->first();
        $form3_1Data = DictaminatorsResponseForm3_1::where('dictaminador_id', $dictaminador_id)->first();
        $form3_2Data = DictaminatorsResponseForm3_2::where('dictaminador_id', $dictaminador_id)->first();
        $form3_3Data = DictaminatorsResponseForm3_3::where('dictaminador_id', $dictaminador_id)->first();
        $form3_4Data = DictaminatorsResponseForm3_4::where('dictaminador_id', $dictaminador_id)->first();

        // Return a structured response which includes both form data
        return response()->json([
            'dictaminador' => [
                'dictaminador_id' => $dictaminador->user_id,
                'email' => $dictaminador->email,
            ],
            'form2' => $form2Data,    // existing fields can still be accessed
            'form2_2' => $form2_2Data,  // potentially useful for this view
            'form3_1' => $form3_1Data,
            'form3_2' => $form3_2Data,
            'form3_3' => $form3_3Data,
            'form3_4' => $form3_4Data,

        ]);
    }

}