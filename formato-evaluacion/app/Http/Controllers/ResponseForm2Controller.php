<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersResponseForm2;
use App\Models\DictaminatorsResponseForm2;

class ResponseForm2Controller extends Controller
{
    public function store2(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'horasActv2' => 'required|numeric',
                'puntajeEvaluar' => 'required|numeric', // Allow nullable
                'obs1' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',
            ]);

            $validatedData['form_type'] = 'form2';
            // Assign a default value if puntajeEvaluar is not provided
            if (!isset($validatedData['puntajeEvaluar'])) {
                $validatedData['puntajeEvaluar'] = 0;
            }
            if (!isset($validatedData['obs1'])) {
                $validatedData['obs1'] = "sin comentarios";
            }

            $horasActv2 = $validatedData['horasActv2'] ?? 0.0;
            UsersResponseForm2::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Form submitted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function getData2(Request $request)
    {
        $data = UsersResponseForm2::where('email', $request->query('email'))->first();


        return response()->json($data);
    }

    
    }

