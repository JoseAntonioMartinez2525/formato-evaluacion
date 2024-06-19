<?php

namespace App\Http\Controllers;

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
            'score3_1' => 'required|numeric',
            'actv3Comision' => 'required|numeric',
            'obs3_1_1' => 'nullable|string',
            'obs3_1_2' => 'nullable|string',
            'obs3_1_3' => 'nullable|string',
            'obs3_1_4' => 'nullable|string',
            'obs3_1_5' => 'nullable|string',
        ]);

        // Assign default value if not provided
        $validatedData['obs3_1_1'] = $validatedData['obs3_1_1'] ?? 'sin comentarios';
        $validatedData['obs3_1_2'] = $validatedData['obs3_1_2'] ?? 'sin comentarios';
        $validatedData['obs3_1_3'] = $validatedData['obs3_1_3'] ?? 'sin comentarios';
        $validatedData['obs3_1_4'] = $validatedData['obs3_1_4'] ?? 'sin comentarios';
        $validatedData['obs3_1_5'] = $validatedData['obs3_1_5'] ?? 'sin comentarios';

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
        }
    }

    public function getData31(Request $request)
    {
       
        $data = UsersResponseForm3_1::where('user_id', $request->query('user_id'))->first();
        return response()->json($data);
    }

}