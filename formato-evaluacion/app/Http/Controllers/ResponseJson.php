<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm2_2;
use App\Models\DictaminatorsResponseForm3_1;
use App\Models\DictaminatorsResponseForm3_10;
use App\Models\DictaminatorsResponseForm3_11;
use App\Models\DictaminatorsResponseForm3_12;
use App\Models\DictaminatorsResponseForm3_13;
use App\Models\DictaminatorsResponseForm3_14;
use App\Models\DictaminatorsResponseForm3_15;
use App\Models\DictaminatorsResponseForm3_16;
use App\Models\DictaminatorsResponseForm3_17;
use App\Models\DictaminatorsResponseForm3_18;
use App\Models\DictaminatorsResponseForm3_19;
use App\Models\DictaminatorsResponseForm3_2;
use App\Models\DictaminatorsResponseForm3_3;
use App\Models\DictaminatorsResponseForm3_4;
use App\Models\DictaminatorsResponseForm3_5;
use App\Models\DictaminatorsResponseForm3_6;
use App\Models\DictaminatorsResponseForm3_7;
use App\Models\DictaminatorsResponseForm3_8;
use App\Models\DictaminatorsResponseForm3_9;
use App\Models\EvaluatorSignature;
use App\Models\UserResume;
use App\Models\UsersResponseForm1;
use App\Models\UsersResponseForm2;
use App\Models\DictaminatorsResponseForm2;
use App\Models\UsersResponseForm2_2;
use App\Models\UsersResponseForm3_1;
use App\Models\UsersResponseForm3_11;
use App\Models\UsersResponseForm3_12;
use App\Models\UsersResponseForm3_13;
use App\Models\UsersResponseForm3_14;
use App\Models\UsersResponseForm3_15;
use App\Models\UsersResponseForm3_16;
use App\Models\UsersResponseForm3_17;
use App\Models\UsersResponseForm3_18;
use App\Models\UsersResponseForm3_19;
use App\Models\UsersResponseForm3_2;
use App\Models\UsersResponseForm3_3;
use App\Models\UsersResponseForm3_4;
use App\Models\UsersResponseForm3_5;
use App\Models\UsersResponseForm3_6;
use App\Models\UsersResponseForm3_7;
use App\Models\UsersResponseForm3_8;
use App\Models\UsersResponseForm3_9;
use App\Models\UsersResponseForm3_10;
use Illuminate\Http\Request;
use App\Models\UsersResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ResponseJson extends Controller
{
    public function jsonGenerator()
    {
        // Retrieve all responses from the database
        $responses = UsersResponseForm1::all()->filter()->values();
        $responses2 = UsersResponseForm2::all()->filter()->values();
        $responses2_2 = UsersResponseForm2_2::all()->filter()->values();
        $responses3_1 = UsersResponseForm3_1::all()->filter()->values();

        $responses3_2 = UsersResponseForm3_2::all()->filter()->values();
        $responses3_3 = UsersResponseForm3_3::all()->filter()->values();
        $responses3_4 = UsersResponseForm3_4::all()->filter()->values();
        $responses3_5 = UsersResponseForm3_5::all()->filter()->values();
        $responses3_6 = UsersResponseForm3_6::all()->filter()->values();
        $responses3_7 = UsersResponseForm3_7::all()->filter()->values();
        $responses3_8 = UsersResponseForm3_8::all()->filter()->values();
        $responses3_9 = UsersResponseForm3_9::all()->filter()->values();
        $responses3_10 = UsersResponseForm3_10::all()->filter()->values();
        $responses3_11 = UsersResponseForm3_11::all()->filter()->values();
        $responses3_12 = UsersResponseForm3_12::all()->filter()->values();
        $responses3_13 = UsersResponseForm3_13::all()->filter()->values();
        $responses3_14 = UsersResponseForm3_14::all()->filter()->values();
        $responses3_15 = UsersResponseForm3_15::all()->filter()->values();
        $responses3_16 = UsersResponseForm3_16::all()->filter()->values();
        $responses3_17 = UsersResponseForm3_17::all()->filter()->values();
        $responses3_18 = UsersResponseForm3_18::all()->filter()->values();
        $responses3_19 = UsersResponseForm3_19::all()->filter()->values();

        $dictaminators_responses2 = DictaminatorsResponseForm2::all()->filter()->values();
        $dictaminators_responses2_2 = DictaminatorsResponseForm2::all()->filter()->values();
        $dictaminators_responses3_1 = DictaminatorsResponseForm3_1::all()->filter()->values();
        $dictaminators_responses3_2 = DictaminatorsResponseForm3_2::all()->filter()->values();
        $dictaminators_responses3_3 = DictaminatorsResponseForm3_3::all()->filter()->values();
        $dictaminators_responses3_4 = DictaminatorsResponseForm3_4::all()->filter()->values();
        $dictaminators_responses3_5 = DictaminatorsResponseForm3_5::all()->filter()->values();
        $dictaminators_responses3_6 = DictaminatorsResponseForm3_6::all()->filter()->values();
        $dictaminators_responses3_7 = DictaminatorsResponseForm3_7::all()->filter()->values();
        $dictaminators_responses3_8 = DictaminatorsResponseForm3_8::all()->filter()->values();
        $dictaminators_responses3_9 = DictaminatorsResponseForm3_9::all()->filter()->values();
        $dictaminators_responses3_10 = DictaminatorsResponseForm3_10::all()->filter()->values();
        $dictaminators_responses3_11 = DictaminatorsResponseForm3_11::all()->filter()->values();
        $dictaminators_responses3_12 = DictaminatorsResponseForm3_12::all()->filter()->values();
        $dictaminators_responses3_13 = DictaminatorsResponseForm3_13::all()->filter()->values();
        $dictaminators_responses3_14 = DictaminatorsResponseForm3_14::all()->filter()->values();
        $dictaminators_responses3_15 = DictaminatorsResponseForm3_15::all()->filter()->values();
        $dictaminators_responses3_16 = DictaminatorsResponseForm3_16::all()->filter()->values();
        $dictaminators_responses3_17 = DictaminatorsResponseForm3_17::all()->filter()->values();
        $dictaminators_responses3_18 = DictaminatorsResponseForm3_18::all()->filter()->values();
        $dictaminators_responses3_19 = DictaminatorsResponseForm3_19::all()->filter()->values();

        $responsesFinal = UserResume::all()->filter()->values();
        $responsesEvaluator = EvaluatorSignature::all()->filter()->values();

        // Combine user and dictaminator responses for form2
        $combinedForm2Responses = $responses2->merge($dictaminators_responses2);
        $combinedForm2_2Responses = $responses2_2->merge($dictaminators_responses2_2);
        $combinedForm3_1Responses = $responses3_1->merge($dictaminators_responses3_1);
        $combinedForm3_2Responses = $responses3_2->merge($dictaminators_responses3_2);
        $combinedForm3_3Responses = $responses3_3->merge($dictaminators_responses3_3);
        $combinedForm3_4Responses = $responses3_4->merge($dictaminators_responses3_4);
        $combinedForm3_5Responses = $responses3_5->merge($dictaminators_responses3_5);
        $combinedForm3_6Responses = $responses3_6->merge($dictaminators_responses3_6);
        $combinedForm3_7Responses = $responses3_7->merge($dictaminators_responses3_7);
        $combinedForm3_8Responses = $responses3_8->merge($dictaminators_responses3_8);
        $combinedForm3_9Responses = $responses3_9->merge($dictaminators_responses3_9);
        $combinedForm3_10Responses = $responses3_10->merge($dictaminators_responses3_10);
        $combinedForm3_11Responses = $responses3_11->merge($dictaminators_responses3_11);
        $combinedForm3_12Responses = $responses3_12->merge($dictaminators_responses3_12);
        $combinedForm3_13Responses = $responses3_13->merge($dictaminators_responses3_13);
        $combinedForm3_14Responses = $responses3_14->merge($dictaminators_responses3_14);
        $combinedForm3_15Responses = $responses3_15->merge($dictaminators_responses3_15);
        $combinedForm3_16Responses = $responses3_16->merge($dictaminators_responses3_16);
        $combinedForm3_17Responses = $responses3_17->merge($dictaminators_responses3_17);
        $combinedForm3_18Responses = $responses3_18->merge($dictaminators_responses3_18);
        $combinedForm3_19Responses = $responses3_19->merge($dictaminators_responses3_19);
 

        

        // Convert each collection of responses to JSON format
        $jsonResponses = json_encode([
            'form1' => $responses->toArray(),
            'form2' => $combinedForm2Responses->toArray(),
            'form2_2' => $combinedForm2_2Responses->toArray(),
            'form3_1' => $combinedForm3_1Responses->toArray(),
            'form3_2' => $combinedForm3_2Responses->toArray(),
            'form3_3' => $combinedForm3_3Responses->toArray(),
            'form3_4' => $combinedForm3_4Responses->toArray(),
            'form3_5' => $combinedForm3_5Responses->toArray(),
            'form3_6' => $combinedForm3_6Responses->toArray(),
            'form3_7' => $combinedForm3_7Responses->toArray(),
            'form3_8' => $combinedForm3_8Responses->toArray(),
            'form3_9' => $combinedForm3_9Responses->toArray(),
            'form3_10' => $combinedForm3_10Responses->toArray(),
            'form3_11' => $combinedForm3_11Responses->toArray(),
            'form3_12' => $combinedForm3_12Responses->toArray(),
            'form3_13' => $combinedForm3_13Responses->toArray(),
            'form3_14' => $combinedForm3_14Responses->toArray(),
            'form3_15' => $combinedForm3_15Responses->toArray(),
            'form3_16' => $combinedForm3_16Responses->toArray(),
            'form3_17' => $combinedForm3_17Responses->toArray(),
            'form3_18' => $combinedForm3_18Responses->toArray(),
            'form3_19' => $combinedForm3_19Responses->toArray(),
            'form4' => $responsesFinal->toArray(),
            'form5'=> $responsesEvaluator->toArray(),

            
        ], JSON_PRETTY_PRINT);

        // Return the JSON response
        return response($jsonResponses)
            ->header('Content-Type', 'application/json');
    }

    public function getDictaminatorResponses()
    {
// Obtiene las respuestas de form2
    $dictaminators_responses2 = DictaminatorsResponseForm2::all()->filter()->values();
    $dictaminators_responses2_2 = DictaminatorsResponseForm2_2::all()->filter()->values();
    $dictaminators_responses3_1 = DictaminatorsResponseForm3_1::all()->filter()->values();
    $dictaminators_responses3_2 = DictaminatorsResponseForm3_2::all()->filter()->values();
    $dictaminators_responses3_3 = DictaminatorsResponseForm3_3::all()->filter()->values();
    $dictaminators_responses3_4 = DictaminatorsResponseForm3_4::all()->filter()->values();
    $dictaminators_responses3_5 = DictaminatorsResponseForm3_5::all()->filter()->values();
    $dictaminators_responses3_6 = DictaminatorsResponseForm3_6::all()->filter()->values();
    $dictaminators_responses3_7 = DictaminatorsResponseForm3_7::all()->filter()->values();
    $dictaminators_responses3_8 = DictaminatorsResponseForm3_8::all()->filter()->values();
    $dictaminators_responses3_9 = DictaminatorsResponseForm3_9::all()->filter()->values();
    $dictaminators_responses3_10 = DictaminatorsResponseForm3_10::all()->filter()->values();
    $dictaminators_responses3_11 = DictaminatorsResponseForm3_11::all()->filter()->values();
    $dictaminators_responses3_12 = DictaminatorsResponseForm3_12::all()->filter()->values();
    $dictaminators_responses3_13 = DictaminatorsResponseForm3_13::all()->filter()->values();
    $dictaminators_responses3_14 = DictaminatorsResponseForm3_14::all()->filter()->values();
    $dictaminators_responses3_15 = DictaminatorsResponseForm3_15::all()->filter()->values();
    $dictaminators_responses3_16 = DictaminatorsResponseForm3_16::all()->filter()->values();
    $dictaminators_responses3_17 = DictaminatorsResponseForm3_17::all()->filter()->values();
    $dictaminators_responses3_18 = DictaminatorsResponseForm3_18::all()->filter()->values();
    $dictaminators_responses3_19 = DictaminatorsResponseForm3_19::all()->filter()->values();


    // Retorna ambas respuestas en un array JSON estructurado
    return response()->json([
        'form2' => $dictaminators_responses2,
        'form2_2' => $dictaminators_responses2_2,
        'form3_1' => $dictaminators_responses3_1,
        'form3_2' => $dictaminators_responses3_2,
        'form3_3' => $dictaminators_responses3_3,
        'form3_4' => $dictaminators_responses3_4,
        'form3_5' => $dictaminators_responses3_5,
        'form3_6' => $dictaminators_responses3_6,
        'form3_7' => $dictaminators_responses3_7,
        'form3_8' => $dictaminators_responses3_8,
        'form3_9' => $dictaminators_responses3_9,
        'form3_10' => $dictaminators_responses3_10,
        'form3_11' => $dictaminators_responses3_11,
        'form3_12' => $dictaminators_responses3_12,
        'form3_13' => $dictaminators_responses3_13,
        'form3_14' => $dictaminators_responses3_14,
        'form3_15' => $dictaminators_responses3_15,
        'form3_16' => $dictaminators_responses3_16,
        'form3_17' => $dictaminators_responses3_17,
        'form3_18' => $dictaminators_responses3_18,
        'form3_19' => $dictaminators_responses3_19,
    ]);

}


}