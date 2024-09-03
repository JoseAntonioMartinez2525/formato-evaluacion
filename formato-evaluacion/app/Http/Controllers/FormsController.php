<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_10;
use App\Models\DictaminatorsResponseForm3_11;
use App\Models\DictaminatorsResponseForm3_12;
use App\Models\DictaminatorsResponseForm3_13;
use App\Models\DictaminatorsResponseForm3_14;
use App\Models\DictaminatorsResponseForm3_15;
use App\Models\DictaminatorsResponseForm3_16;
use App\Models\DictaminatorsResponseForm3_17;
use App\Models\DictaminatorsResponseForm3_3;
use App\Models\DictaminatorsResponseForm3_4;
use App\Models\DictaminatorsResponseForm3_5;
use App\Models\DictaminatorsResponseForm3_6;
use App\Models\DictaminatorsResponseForm3_7;
use App\Models\DictaminatorsResponseForm3_8;
use App\Models\DictaminatorsResponseForm3_9;
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
        $form3_5Data = DictaminatorsResponseForm3_5::where('dictaminador_id', $dictaminador_id)->first();
        $form3_6Data = DictaminatorsResponseForm3_6::where('dictaminador_id', $dictaminador_id)->first();
        $form3_7Data = DictaminatorsResponseForm3_7::where('dictaminador_id', $dictaminador_id)->first();
        $form3_8Data = DictaminatorsResponseForm3_8::where('dictaminador_id', $dictaminador_id)->first();
        $form3_9Data = DictaminatorsResponseForm3_9::where('dictaminador_id', $dictaminador_id)->first();
        $form3_10Data = DictaminatorsResponseForm3_10::where('dictaminador_id', $dictaminador_id)->first();
        $form3_11Data = DictaminatorsResponseForm3_11::where('dictaminador_id', $dictaminador_id)->first();
        $form3_12Data = DictaminatorsResponseForm3_12::where('dictaminador_id', $dictaminador_id)->first();
        $form3_13Data = DictaminatorsResponseForm3_13::where('dictaminador_id', $dictaminador_id)->first();
        $form3_14Data = DictaminatorsResponseForm3_14::where('dictaminador_id', $dictaminador_id)->first();
        $form3_15Data = DictaminatorsResponseForm3_15::where('dictaminador_id', $dictaminador_id)->first();
        $form3_16Data = DictaminatorsResponseForm3_16::where('dictaminador_id', $dictaminador_id)->first();
        $form3_17Data = DictaminatorsResponseForm3_17::where('dictaminador_id', $dictaminador_id)->first();

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
            'form3_5' => $form3_5Data,
            'form3_6' => $form3_6Data,
            'form3_7' => $form3_7Data,
            'form3_8' => $form3_8Data,
            'form3_9' => $form3_9Data,
            'form3_10' => $form3_10Data,
            'form3_11' => $form3_11Data,
            'form3_12' => $form3_12Data,
            'form3_13' => $form3_13Data,
            'form3_14' => $form3_14Data,
            'form3_15' => $form3_15Data,
            'form3_16' => $form3_16Data,
            'form3_17' => $form3_17Data,


        ]);
    }

}