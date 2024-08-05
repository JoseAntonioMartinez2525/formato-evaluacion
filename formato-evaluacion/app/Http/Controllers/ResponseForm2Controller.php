<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersResponseForm2;
use App\Models\DictaminatorsResponseForm2;

class ResponseForm2Controller extends Controller
{
    public function store2(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'horasActv2' => 'required|numeric',
            'puntajeEvaluar' => 'required|numeric', // Allow nullable
            'comision1' => 'required|numeric',
            'obs1' => 'nullable|string',
            'user_type' => 'required|in:user,dictaminator',
        ]);

        // Assign a default value if puntajeEvaluar is not provided
        if (!isset($validatedData['puntajeEvaluar'])) {
            $validatedData['puntajeEvaluar'] = 0;
        }
        if (!isset($validatedData['obs1'])) {
            $validatedData['obs1'] = "sin comentarios";
        }


        // Guardar en la tabla correspondiente según el tipo de usuario
        if ($validatedData['user_type'] == 'user') {
            UsersResponseForm2::create($validatedData);
        } elseif ($validatedData['user_type'] == 'dictaminator') {
            DictaminatorsResponseForm2::create($validatedData);
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }


    public function getData2(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'user_type' => 'required|in:user,dictaminator', // Nuevo campo para distinguir entre usuarios
        ]);

        // Obtener datos de la tabla correspondiente según el tipo de usuario
        if ($validatedData['user_type'] == 'user') {
            $data = UsersResponseForm2::where('user_id', $request->query('user_id'))->first();
        } elseif ($validatedData['user_type'] == 'dictaminator') {
            $data = DictaminatorsResponseForm2::where('user_id', $request->query('user_id'))->first();
        }

        return response()->json($data);
    }
    }

