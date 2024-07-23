<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluatorSignature;

class EvaluatorSignatureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email',
            'evaluator_name' => 'required|string',
            'firma' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $file = $request->file('firma');
        $filePath = $file->store('signatures', 'public'); // Store file in 'public/signatures'

        EvaluatorSignature::create([
            'user_id' => $request->user_id,
            'email' => $request->email,
            'evaluator_name' => $request->evaluator_name,
            'signature_path' => $filePath,
        ]);

        return response()->json(['message' => 'Signature saved successfully.']);
    }
}
