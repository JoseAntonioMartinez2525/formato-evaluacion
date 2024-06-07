<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersResponseForm2_2;
class ResponseForm2_2Controller extends Controller
{
    public function store3(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'hours' => 'required|numeric',
            'actv2Comision' => 'required|numeric', 
            'obs2' => 'string',
            'obs2_2' => 'string',
        ]);

        // Assign a default value if puntajeEvaluar is not provided
        if (!isset($validatedData['puntajeEvaluar'])) {
            $validatedData['puntajeEvaluar'] = 0;
        }
        if (!isset($validatedData['obs1']) || ($validatedData['obs2_2']) ){
            $validatedData['obs1'] = "sin comentarios";
        }

        UsersResponseForm2_2::create($validatedData);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}
