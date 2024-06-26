<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm1;
use App\Models\UsersResponseForm2;
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
        //responses 3.1 -> 3.19
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
        

        // Convert each collection of responses to JSON format
        $jsonResponses = json_encode([
            'form1' => $responses->toArray(),
            'form2' => $responses2->toArray(),
            'form2_2' => $responses2_2->toArray(),
            'form3_1' => $responses3_1->toArray(),
            'form3_2' => $responses3_2->toArray(),
            'form3_3' => $responses3_3->toArray(),
            'form3_4' => $responses3_4->toArray(),
            'form3_5' => $responses3_5->toArray(),
            'form3_6' => $responses3_6->toArray(),
            'form3_7' => $responses3_7->toArray(),
            'form3_8' => $responses3_8->toArray(),
            'form3_9' => $responses3_9->toArray(),
            'form3_10' => $responses3_10->toArray(),
            'form3_11' => $responses3_11->toArray(),
            'form3_12' => $responses3_12->toArray(),
            'form3_13' => $responses3_13->toArray(),
            'form3_14' => $responses3_14->toArray(),
            'form3_15' => $responses3_15->toArray(),
            'form3_16' => $responses3_16->toArray(),
            'form3_17' => $responses3_17->toArray(),
            'form3_18' => $responses3_18->toArray(),

            
        ], JSON_PRETTY_PRINT);

        // Return the JSON response
        return response($jsonResponses)
            ->header('Content-Type', 'application/json');
    }
}
