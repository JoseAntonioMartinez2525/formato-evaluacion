<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm1;
use App\Models\UsersResponseForm2;
use App\Models\UsersResponseForm2_2;
use App\Models\UsersResponseForm3_1;
use App\Models\UsersResponseForm3_10;
use App\Models\UsersResponseForm3_11;
use App\Models\UsersResponseForm3_12;
use App\Models\UsersResponseForm3_13;
use App\Models\UsersResponseForm3_14;
use App\Models\UsersResponseForm3_15;
use App\Models\UsersResponseForm3_16;
use App\Models\UsersResponseForm3_17;
use App\Models\UsersResponseForm3_18;
use App\Models\UsersResponseForm3_19;
use App\Models\UsersResponseForm3_2;
use App\Models\UsersResponseForm3_3;
use App\Models\UsersResponseForm3_4;
use App\Models\UsersResponseForm3_5;
use App\Models\UsersResponseForm3_6;
use App\Models\UsersResponseForm3_7;
use App\Models\UsersResponseForm3_8;
use App\Models\UsersResponseForm3_8_1;
use App\Models\UsersResponseForm3_9;
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

        $formData1 = UsersResponseForm1::where('user_id', $docente->id)->first();
        $convocatoria = UsersResponseForm1::where('user_id', $docente->id)->first();
        $periodo = UsersResponseForm1::where('user_id', $docente->id)->first();
        $nombre = UsersResponseForm1::where('user_id', $docente->id)->first();
        $area = UsersResponseForm1::where('user_id', $docente->id)->first();
        $departamento = UsersResponseForm1::where('user_id', $docente->id)->first();
        $form2Data = UsersResponseForm2::where('user_id', $docente->id)->first();
        $form2_2Data = UsersResponseForm2_2::where('user_id', $docente->id)->first();
        $form3_1Data = UsersResponseForm3_1::where('user_id', $docente->id)->first();
        $form3_2Data = UsersResponseForm3_2::where('user_id', $docente->id)->first();
        $form3_3Data = UsersResponseForm3_3::where('user_id', $docente->id)->first();
        $form3_4Data = UsersResponseForm3_4::where('user_id', $docente->id)->first();
        $form3_5Data = UsersResponseForm3_5::where('user_id', $docente->id)->first();
        $form3_6Data = UsersResponseForm3_6::where('user_id', $docente->id)->first();
        $form3_7Data = UsersResponseForm3_7::where('user_id', $docente->id)->first();
        $form3_8Data = UsersResponseForm3_8::where('user_id', $docente->id)->first();
        $form3_8_1Data = UsersResponseForm3_8_1::where('user_id', $docente->id)->first();
        $form3_9Data = UsersResponseForm3_9::where('user_id', $docente->id)->first();
        $form3_10Data = UsersResponseForm3_10::where('user_id', $docente->id)->first();
        $form3_11Data = UsersResponseForm3_11::where('user_id', $docente->id)->first();
        $form3_12Data = UsersResponseForm3_12::where('user_id', $docente->id)->first();
        $form3_13Data = UsersResponseForm3_13::where('user_id', $docente->id)->first();
        $form3_14Data = UsersResponseForm3_14::where('user_id', $docente->id)->first();
        $form3_15Data = UsersResponseForm3_15::where('user_id', $docente->id)->first();
        $form3_16Data = UsersResponseForm3_16::where('user_id', $docente->id)->first();
        $form3_17Data = UsersResponseForm3_17::where('user_id', $docente->id)->first();
        $form3_18Data = UsersResponseForm3_18::where('user_id', $docente->id)->first();
        $form3_19Data = UsersResponseForm3_19::where('user_id', $docente->id)->first();

        // Return a structured response which includes both form data
        return response()->json([
            'docente' => [
                'id' => $docente->id,
                'email' => $docente->email,
                'convocatoria'=>$convocatoria->convocatoria,
                'periodo'=>$periodo->periodo,
                'nombre'=>$nombre->nombre,
                'area'=>$area->area,
                'departamento'=>$departamento->departamento,
            ],
            'form1'=>$formData1,
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
            'form3_8_1' => $form3_8_1Data,
            'form3_9' => $form3_9Data,
            'form3_10' => $form3_10Data,
            'form3_11' => $form3_11Data,
            'form3_12' => $form3_12Data,
            'form3_13' => $form3_13Data,
            'form3_14' => $form3_14Data,
            'form3_15' => $form3_15Data,
            'form3_16' => $form3_16Data,
            'form3_17' => $form3_17Data,
            'form3_18' => $form3_18Data,
            'form3_19' => $form3_19Data,

        ]);
    }

    public function getUserId(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json(['user_id' => $user->id]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }


}

