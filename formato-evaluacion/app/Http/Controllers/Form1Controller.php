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
        $dictaminador = User::with(['form2', 'form2_2', 'form3_1']) // Asegúrate de que estas relaciones estén definidas en tu modelo User
        ->where('email', $email)
        ->first();

    if (!$dictaminador) {
        return response()->json(['error' => 'Dictaminador not found'], 404);
    }

    // Log the results being fetched
    \Log::info('Dictaminador:', [$dictaminador]);

    return response()->json([
        'dictaminador' => [
            'id' => $dictaminador->id,
            'email' => $dictaminador->email,
        ],
        'form2' => $dictaminador->form2, // Accediendo directamente a las relaciones
        'form2_2' => $dictaminador->form2_2,
        'form3_1' => $dictaminador->form3_1,
    ]);
}
}