<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm1;
use Illuminate\Http\Request;
use App\Models\UsersResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class ResponseController extends Controller
{
    /**
     * Almacenar una nueva respuesta en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Obtener todos los datos de la solicitud
        $data = $request->all();
        
        $data['user_id'] = Auth::id();

        try {
            // Llamar al método estático para crear la respuesta
            $response = UsersResponseForm1::createResponse($data);

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
    public function generateJson()
    {
        // Retrieve all responses from the database
        $responses = UsersResponseForm1::all();

        // Convert responses to JSON format
        $json = $responses->toJson(JSON_PRETTY_PRINT);

        // Return the JSON response
        return response($json)
            ->header('Content-Type', 'application/json');
    }
}
