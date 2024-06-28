<?php

namespace App\Http\Controllers;

use App\Models\UserResume;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function storeResume(Request $request)
    {
        try{$validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|exists:users,email',
            'comision_actividad_1_total' => 'required|numeric',
            'comision_actividad_2_total' => 'required|numeric',
            'comision_actividad_3_total' => 'required|numeric',
            'total_puntaje'=> 'required|numeric',
            'minima_calidad'=>'required|string',
            'minima_total'=>'required|string',
            'persona_evaluadora'=>'required|string',
            'firma' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('firma')) {
            $file = $request->file('firma');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('firmas', $fileName, 'public');

            // Opcional: Guardar la ruta en la base de datos
            // Firma::create(['ruta_firma' => $filePath]);

            // Guardar como un BLOB en la base de datos
            $imageBlob = file_get_contents($file->getRealPath());
            DB::table('users_final_resume')->insert([
                'firma' => $imageBlob,
                // Otros campos...
            ]);
        }

         // Create a new record using Eloquent ORM
            UserResume::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Form submitted successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            \Log::error('Validation error: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log other errors
            \Log::error('Error submitting form: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error submitting form: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDataResume(Request $request)
    {
        try {
            $data = UserResume::where('user_id', $request->query('user_id'))->first();
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error retrieving data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
