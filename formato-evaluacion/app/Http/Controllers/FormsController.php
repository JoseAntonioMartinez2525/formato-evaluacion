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
use App\Models\DictaminatorsResponseForm3_18;
use App\Models\DictaminatorsResponseForm3_19;
use App\Models\DictaminatorsResponseForm3_3;
use App\Models\DictaminatorsResponseForm3_4;
use App\Models\DictaminatorsResponseForm3_5;
use App\Models\DictaminatorsResponseForm3_6;
use App\Models\DictaminatorsResponseForm3_7;
use App\Models\DictaminatorsResponseForm3_8;
use App\Models\DictaminatorsResponseForm3_9;
use App\Models\EvaluatorSignature;
use App\Models\UserResume;
use App\Models\UsersResponseForm1;
use App\Models\UsersResponseForm2;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DictaminatorsResponseForm2;
use App\Models\DictaminatorsResponseForm2_2;
use App\Models\DictaminatorsResponseForm3_1;
use App\Models\DictaminatorsResponseForm3_2;
use Illuminate\Support\Facades\DB;
class FormsController extends Controller
{
    

    public function getDictaminadores()
    {
        $dictaminador = User::where('user_type', 'dictaminador')->get(['id', 'emails']);
        \Log::info('Dictaminador:', $dictaminador->toArray());
        return response()->json($dictaminador);
    }
public function getDictaminadorData(Request $request)
{
        $emails = $request->query('emailss');
        $dictaminador_id = $request->query('dictaminador_id');

        \Log::info('emails recibido:', ['emails' => $emails]);
        \Log::info('Dictaminador ID recibido:', ['dictaminador_id' => $dictaminador_id]);

        if (!is_array($emails) || empty($emailss)) {
            return response()->json(['error' => 'emailss invalidos o no recibidos'], 400);
        }
        // Verificar que el dictaminador con el ID proporcionado exista
        $dictaminador = User::where('id', $dictaminador_id)->first();

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
        $form3_18Data = DictaminatorsResponseForm3_18::where('dictaminador_id', $dictaminador_id)->first();
        $form3_19Data = DictaminatorsResponseForm3_19::where('dictaminador_id', $dictaminador_id)->first();
        $resumeData = UserResume::where('dictaminador_id', $dictaminador_id)->first();
        $signaturesData = EvaluatorSignature::where('user_id', $dictaminador_id)->first();

        $form1Data = $form2Data ? $form2Data->usersResponseForm1 : null;
        $formData = $this->getAllFormData($dictaminador_id, $form1Data);
        // Return a structured response which includes both form data

        $formFinalData = DB::table('consolidated_responses')
            ->join('users_final_resume', 'consolidated_responses.user_email', '=', 'users_final_resume.email')
            ->where('consolidated_responses.user_email', $emails)
            ->select('consolidated_responses.*', 'users_final_resume.*')
            ->first();

        return response()->json([
            'dictaminador' => [
                'dictaminador_id' => $dictaminador->user_id,
                'emails' => $dictaminador->emails,
            ],
            'responseForm1' => $formData['form1Data'],
            'form2' => $form2Data,
            'form2_2' => $formData['form2_2'],
            'forms' => $formData['forms'],
            'form2_2Data' => $form2_2Data,
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
            'form3_18' => $form3_18Data,
            'form3_19' => $form3_19Data,
            'user_final_resume'=> $resumeData,
            'signatures' => $signaturesData,
            'final_form' => $formFinalData,


        ]);

        
    }

    private function getAllFormData($dictaminador_id, &$form1Data)
    {
        $formData = [];
        $forms = [];

        // Obtener datos de DictaminatorsResponseForm2_2
        $formData['form2_2'] = DictaminatorsResponseForm2_2::where('dictaminador_id', $dictaminador_id)->first();
        if ($formData['form2_2'] && !$form1Data) {
            $form1Data = $formData['form2_2']->usersResponseForm1;
        }

        // Iterar sobre los modelos de DictaminatorsResponseForm3
        for ($i = 1; $i <= 19; $i++) {
            $modelClass = 'App\\Models\\DictaminatorsResponseForm3_' . $i;
            if (class_exists($modelClass)) {
                $forms['form3_' . $i] = $modelClass::where('dictaminador_id', $dictaminador_id)->first();
                if ($forms['form3_' . $i] && !$form1Data) {
                    $form1Data = $forms['form3_' . $i]->usersResponseForm1;
                }
            }
        }

        $formData['forms'] = $forms;
        $formData['form1Data'] = $form1Data;

        return $formData;
    }

/*
    public function asignarDocentes(Request $request, $dictaminador_id)
    {
        // Encuentra al dictaminador
        $dictaminator = DictaminatorsResponseForm2::find($dictaminador_id);

        // Verifica si el dictaminador existe
        if (!$dictaminator) {
            return response()->json(['success' => false, 'message' => 'Dictaminador no encontrado'], 404);
        }

        // Convertir los correos electrónicos en IDs
        $docenteemailss = $request->docentes; // Aquí obtienes los emailss

        // Buscar los IDs de los docentes usando los correos electrónicos
        $docentes = UsersResponseForm2::whereIn('emails', $docenteemailss)->get();

        foreach ($docentes as $docente) {
            // Asignar la relación y el correo electrónico
            $dictaminator->docentes()->attach($docente->user_id, ['docente_emails' => $docente->emails]);
        }

        return response()->json(['success' => true, 'message' => 'Docentes asignados correctamente']);
    }



    public function agregarDocente(Request $request, $dictaminador_id)
    {
        // Encuentra al dictaminador
        $dictaminator = DictaminatorsResponseForm2::find($dictaminador_id);

        // Verifica si el dictaminador existe
        if (!$dictaminator) {
            return response()->json(['success' => false, 'message' => 'Dictaminador no encontrado'], 404);
        }

        // Agregar un docente a la relación (esto agrega el docente sin eliminar los actuales)
        // $request->docente_id debe ser el ID del docente
        $dictaminator->docentes()->syncWithoutDetaching([$request->docente_id]);

        return response()->json(['success' => true, 'message' => 'Docente agregado correctamente']);
    }
    
*/

}