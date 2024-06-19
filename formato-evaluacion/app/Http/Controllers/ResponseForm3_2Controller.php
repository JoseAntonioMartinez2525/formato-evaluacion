<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm3_2;
use Illuminate\Http\Request;

class ResponseForm3_2Controller extends Controller
{
    public function store32(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'score3_2' => 'required|numeric',
            'comision3_2' => 'required|numeric',
            'obs3_2_1' => 'nullable|string',
            'obs3_2_2' => 'nullable|string',
            'obs3_2_3' => 'nullable|string',

        ]);

        // Assign default value if not provided
        $validatedData['obs3_2_1'] = $validatedData['obs3_2_1'] ?? 'sin comentarios';
        $validatedData['obs3_2_2'] = $validatedData['obs3_2_2'] ?? 'sin comentarios';
        $validatedData['obs3_2_3'] = $validatedData['obs3_2_3'] ?? 'sin comentarios';

        try {
            // Create a new record using Eloquent ORM
            UsersResponseForm3_2::create($validatedData);

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

    public function getData32(Request $request)
    {
       
        $data = UsersResponseForm3_2::where('user_id', $request->query('user_id'))->first();
        return response()->json($data);
    }

}