<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm3_19;
use Illuminate\Http\Request;

class ResponseForm3_19Controller extends Controller
{
    public function store319(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'email' => 'required|exists:users,email',
                'score3_19' => 'required|numeric',
                //'comision3_19' => 'required|numeric',
                'obsCGUtitular' => 'nullable|string',
                'obsCGUespecial' => 'nullable|string',
                'obsCGUpermanente' => 'nullable|string',
                'obsCAACtitular' => 'nullable|string',
                'obsCAACintegCom' => 'nullable|string',
                'obsComDepart' => 'nullable|string',
                'obsComPEDPD' => 'nullable|string',
                'obsComPartPos' => 'nullable|string',
                'obsRespPos' => 'nullable|string',
                'obsRespCarrera' => 'nullable|string',
                'obsRespProd' => 'nullable|string',
                'obsRespLab' => 'nullable|string',
                'obsExamProf' => 'nullable|string',
                'obsExamAcademicos' => 'nullable|string',
                'obsPRODEPformResp' => 'nullable|string',
                'obsPRODEPformInteg' => 'nullable|string',
                'obsPRODEPenconsResp' => 'nullable|string',
                'obsPRODEPenconsInteg' => 'nullable|string',
                'obsPRODEPconsResp' => 'nullable|string',
                'obsPRODEPconsInteg' => 'nullable|string',
                'user_type' => 'required|in:user,docente,dictaminator',



            ]);

            // Assign default value if not provided
            $validatedData['obsCGUtitular'] = $validatedData['obsCGUtitular'] ?? 'sin comentarios';
            $validatedData['obsCGUespecial'] = $validatedData['obsCGUespecial'] ?? 'sin comentarios';
            $validatedData['obsCGUpermanente'] = $validatedData['obsCGUpermanente'] ?? 'sin comentarios';
            $validatedData['obsCAACtitular'] = $validatedData['obsCAACtitular'] ?? 'sin comentarios';
            $validatedData['obsCAACintegCom'] = $validatedData['obsCAACintegCom'] ?? 'sin comentarios';
            $validatedData['obsComDepart'] = $validatedData['obsComDepart'] ?? 'sin comentarios';
            $validatedData['obsComPEDPD'] = $validatedData['obsComPEDPD'] ?? 'sin comentarios';
            $validatedData['obsComPartPos'] = $validatedData['obsComPartPos'] ?? 'sin comentarios';
            $validatedData['obsRespPos'] = $validatedData['obsRespPos'] ?? 'sin comentarios';
            $validatedData['obsRespCarrera'] = $validatedData['obsRespCarrera'] ?? 'sin comentarios';
            $validatedData['obsRespProd'] = $validatedData['obsRespProd'] ?? 'sin comentarios';
            $validatedData['obsRespLab'] = $validatedData['obsRespLab'] ?? 'sin comentarios';
            $validatedData['obsExamProf'] = $validatedData['obsExamProf'] ?? 'sin comentarios';
            $validatedData['obsExamAcademicos'] = $validatedData['obsExamAcademicos'] ?? 'sin comentarios';
            $validatedData['obsPRODEPformResp'] = $validatedData['obsPRODEPformResp'] ?? 'sin comentarios';
            $validatedData['obsPRODEPformInteg'] = $validatedData['obsPRODEPformInteg'] ?? 'sin comentarios';
            $validatedData['obsPRODEPenconsResp'] = $validatedData['obsPRODEPenconsResp'] ?? 'sin comentarios';
            $validatedData['obsPRODEPenconsInteg'] = $validatedData['obsPRODEPenconsInteg'] ?? 'sin comentarios';
            $validatedData['obsPRODEPconsResp'] = $validatedData['obsPRODEPconsResp'] ?? 'sin comentarios';
            $validatedData['obsPRODEPconsInteg'] = $validatedData['obsPRODEPconsInteg'] ?? 'sin comentarios';



            // Create a new record using Eloquent ORM
            UsersResponseForm3_19::create($validatedData);

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

    public function getData319(Request $request)
    {
        try {
            $data = UsersResponseForm3_19::where('user_id', $request->query('user_id'))->first();
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
