<?php

namespace App\Http\Controllers;

use App\Models\UsersResponseForm1;
use App\Models\UsersResponseForm2;
use App\Models\UsersResponseForm2_2;
use App\Models\UsersResponseForm3_1;
use App\Models\UsersResponseForm3_2;
use App\Models\UsersResponseForm3_3;
use App\Models\UsersResponseForm3_4;
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
        // Convert each collection of responses to JSON format
        $jsonResponses = json_encode([
            'form1' => $responses->toArray(),
            'form2' => $responses2->toArray(),
            'form2_2' => $responses2_2->toArray(),
            'form3_1' => $responses3_1->toArray(),
            'form3_2' => $responses3_2->toArray(),
            'form3_3' => $responses3_3->toArray(),
            'form3_4' => $responses3_4->toArray(),
            
        ], JSON_PRETTY_PRINT);

        // Return the JSON response
        return response($jsonResponses)
            ->header('Content-Type', 'application/json');
    }
}
