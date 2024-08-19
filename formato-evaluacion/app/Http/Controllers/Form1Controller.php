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
        $dictaminador = User::where('user_type', 'dictaminador')->get(['id', 'email']);
        \Log::info('Dictaminador:', $dictaminador->toArray());
        return response()->json($dictaminador);
    }

    public function getDictaminadorData(Request $request)
    {
        $dictaminator_id = $request->input('dictaminator_id');
        if (!$dictaminator_id) {
            return response()->json(['error' => 'ID is required'], 400);
        }

        $dictaminador = User::find($dictaminator_id);
        if (!$dictaminador) {
            return response()->json(['error' => 'Dictaminador not found'], 404);
        }

        // Assuming you have related data or additional model to fetch
        $form2Data = DictaminatorsResponseForm2::where('id', $dictaminador->id)->first();

        return response()->json([
            'form2' =>[
             'id'=> $form2Data->id, 
             'horasActv2' => $form2Data->horasActv2,
             'puntajeEvaluar'=>$form2Data->puntajeEvaluar,
             'comision1'=>$form2Data->comision1,
             'obs1'=>$form2Data->obs1,
            ] 
        ]);
    }

}