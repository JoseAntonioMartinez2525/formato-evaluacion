<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm3_4;
use Illuminate\Http\Request;

class ResponseForm3_4Controller extends Controller
{
    public function store34(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'score3_4' => 'required|numeric',
            'comision3_4' => 'required|numeric',
            'obs3_4_1' => 'nullable|string',
            'obs3_4_2' => 'nullable|string',
            'obs3_4_3' => 'nullable|string',
            'obs3_4_4' => 'nullable|string',

        ]);

        // Assign default value if not provided
        $validatedData['obs3_4_1'] = $validatedData['obs3_4_1'] ?? 'sin comentarios';
        $validatedData['obs3_4_2'] = $validatedData['obs3_4_2'] ?? 'sin comentarios';
        $validatedData['obs3_4_3'] = $validatedData['obs3_4_3'] ?? 'sin comentarios';
        $validatedData['obs3_4_4'] = $validatedData['obs3_4_4'] ?? 'sin comentarios';

        try {
            // Create a new record using Eloquent ORM
            UsersResponseForm3_4::create($validatedData);

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

    public function getData34(Request $request)
    {

        $data = UsersResponseForm3_4::where('user_id', $request->query('user_id'))->first();
        return response()->json($data);
    }
}