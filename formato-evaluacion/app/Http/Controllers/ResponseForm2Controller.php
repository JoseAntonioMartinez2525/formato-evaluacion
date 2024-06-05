<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm2;
use Illuminate\Http\Request;
use App\Models\UsersResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class ResponseForm2Controller extends Controller
{
    /**
     * Almacenar una nueva respuesta en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store2(Request $request)
    {
        // Obtener todos los datos de la solicitud
        $data = $request->all();

        $data['user_id'] = Auth::id();
        $data['email'] = Auth::email();

        try {
            // Llamar al método estático para crear la respuesta
            $response = UsersResponseForm2::createResponse($data);

            // Devolver una respuesta exitosa en formato JSON
            return response()->json(['success' => true, 'data' => $response], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Manejar otros errores y devolver una respuesta de error
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function generateJsonTwo()
    {
        // Retrieve all responses from the database
        $responses = UsersResponseForm2::all();
        

        // Convert responses to JSON format
        $json = $responses->toJson(JSON_PRETTY_PRINT);

        // Return the JSON response
        return response($json)
            ->header('Content-Type', 'application/json');
    }

    
}

