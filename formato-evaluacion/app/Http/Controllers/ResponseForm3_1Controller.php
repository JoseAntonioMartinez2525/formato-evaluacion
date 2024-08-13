<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_1;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\UsersResponseForm3_1;

class ResponseForm3_1Controller extends Controller
{
    public function store31(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'elaboracionSubTotal3' => 'required|numeric',
            'elaboracion4' => 'required|numeric',
            'elaboracionSubTotal4' => 'required|numeric',
            'elaboracion5' => 'required|numeric',
            'elaboracionSubTotal5' => 'required|numeric',
            'score3_1' => 'required|numeric',
            'obs3_1_1' => 'nullable|string',
            'obs3_1_2' => 'nullable|string',
            'obs3_1_3' => 'nullable|string',
            'obs3_1_4' => 'nullable|string',
            'obs3_1_5' => 'nullable|string',
            'user_type' => 'required|in:user,dictaminator',
        ]);

        // Assign default value if not provided
        $validatedData['obs3_1_1'] = $validatedData['obs3_1_1'] ?? 'sin comentarios';
        $validatedData['obs3_1_2'] = $validatedData['obs3_1_2'] ?? 'sin comentarios';
        $validatedData['obs3_1_3'] = $validatedData['obs3_1_3'] ?? 'sin comentarios';
        $validatedData['obs3_1_4'] = $validatedData['obs3_1_4'] ?? 'sin comentarios';
        $validatedData['obs3_1_5'] = $validatedData['obs3_1_5'] ?? 'sin comentarios';

        if ($validatedData['user_type'] == 'dictaminator') {
            DictaminatorsResponseForm3_1::create($validatedData);
        }
        else{
        try {
            // Create a new record using Eloquent ORM
            UsersResponseForm3_1::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Form submitted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting form: ' . $e->getMessage(),
            ], 500);
        }}
    }

    public function getData31(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'user_type' => 'required|in:user,dictaminator', // Nuevo campo para distinguir entre usuarios
        ]);

        // Obtener datos de la tabla correspondiente según el tipo de usuario
        if ($validatedData['user_type'] == 'user') {
            $data = UsersResponseForm3_1::where('user_id', $request->query('user_id'))->first();
        } elseif ($validatedData['user_type'] == 'dictaminator') {
            $data = DictaminatorsResponseForm3_1::where('user_id', $request->query('user_id'))->first();
        }
        return response()->json($data);
    }

}