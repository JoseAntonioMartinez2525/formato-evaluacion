<?php

namespace App\Http\Controllers;

use App\Models\DictaminatorsResponseForm3_1;
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

        // Combine user and dictaminator responses for form2
        $combinedForm2Responses = $responses2->merge($dictaminators_responses2);
        $combinedForm2_2Responses = $responses2_2->merge($dictaminators_responses2_2);
        $combinedForm3_1Responses = $responses3_1->merge($dictaminators_responses3_1);
        $combinedForm3_2Responses = $responses3_2->merge($dictaminators_responses3_2);
        $combinedForm3_3Responses = $responses3_3->merge($dictaminators_responses3_3);
        $combinedForm3_4Responses = $responses3_4->merge($dictaminators_responses3_4);
        $combinedForm3_5Responses = $responses3_5->merge($dictaminators_responses3_5);
        $combinedForm3_6Responses = $responses3_6->merge($dictaminators_responses3_6);
        $combinedForm3_7Responses = $responses3_6->merge($dictaminators_responses3_7);
        $combinedForm3_8Responses = $responses3_6->merge($dictaminators_responses3_8);
        $combinedForm3_9Responses = $responses3_6->merge($dictaminators_responses3_9);

        $responsesFinal = UserResume::all()->filter()->values();
        $responsesEvaluator = EvaluatorSignature::all()->filter()->values();

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
            'form3_10' => $responses3_10->toArray(),
            'form3_11' => $responses3_11->toArray(),
            'form3_12' => $responses3_12->toArray(),
            'form3_13' => $responses3_13->toArray(),
            'form3_14' => $responses3_14->toArray(),
            'form3_15' => $responses3_15->toArray(),
            'form3_16' => $responses3_16->toArray(),
            'form3_17' => $responses3_17->toArray(),
            'form3_18' => $responses3_18->toArray(),
            'form3_19' => $responses3_19->toArray(),
            'formFinal' => $responsesFinal->toArray(),
            'form5'=> $responsesEvaluator->toArray(),

            
        ], JSON_PRETTY_PRINT);

        // Return the JSON response
        return response($jsonResponses)
            ->header('Content-Type', 'application/json');
    }
}
