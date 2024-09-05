<?php

namespace App\Console\Commands;

use App\Models\DictaminatorsResponseForm3_10;
use App\Models\DictaminatorsResponseForm3_11;
use App\Models\DictaminatorsResponseForm3_12;
use App\Models\DictaminatorsResponseForm3_13;
use App\Models\DictaminatorsResponseForm3_14;
use App\Models\DictaminatorsResponseForm3_15;
use App\Models\DictaminatorsResponseForm3_16;
use App\Models\DictaminatorsResponseForm3_17;
use App\Models\DictaminatorsResponseForm3_18;
use App\Models\DictaminatorsResponseForm3_2;
use App\Models\DictaminatorsResponseForm3_3;
use App\Models\DictaminatorsResponseForm3_4;
use App\Models\DictaminatorsResponseForm3_5;
use App\Models\DictaminatorsResponseForm3_6;
use App\Models\DictaminatorsResponseForm3_7;
use App\Models\DictaminatorsResponseForm3_8;
use App\Models\DictaminatorsResponseForm3_9;
use App\Models\UsersResponseForm3_10;
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
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\UsersResponseForm1;
use App\Models\UsersResponseForm2;
use App\Models\UsersResponseForm2_2;
use App\Models\UsersResponseForm3_1;
use App\Models\UsersResponseForm3_9;
use App\Models\DictaminatorsResponseForm2;
use App\Models\DictaminatorsResponseForm2_2;
use App\Models\DictaminatorsResponseForm3_1;
use App\Models\DictaminatorsResponseForm3_19;

class TransferResponses extends Command
{
    protected $signature = 'transfer:responses';
    protected $description = 'Transfer responses data to the consolidated table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Transfer docente responses
        //$this->transferDocenteResponses();

        // Transfer dictaminador responses
        $this->transferDictaminadorResponses();

        $this->info('Data transfer completed.');
    }

    /*private function transferDocenteResponses()
    {
       $models = [

    UsersResponseForm2::class,
    UsersResponseForm2_2::class,
    UsersResponseForm3_1::class,
    UsersResponseForm3_2::class,
    UsersResponseForm3_3::class,
    UsersResponseForm3_4::class,
    UsersResponseForm3_5::class,
    UsersResponseForm3_6::class,
    UsersResponseForm3_7::class,
    UsersResponseForm3_8::class,
    UsersResponseForm3_9::class,
    UsersResponseForm3_10::class,
    UsersResponseForm3_11::class,
    UsersResponseForm3_12::class,
    UsersResponseForm3_13::class,
    UsersResponseForm3_14::class,
    UsersResponseForm3_15::class,
    UsersResponseForm3_16::class,
    UsersResponseForm3_17::class,
    UsersResponseForm3_18::class,
    UsersResponseForm3_19::class,
];

foreach ($models as $model) {
    // Eager load 'user' relationship
    $responses = $model::with('user')->get();

    foreach ($responses as $response) {
        $userEmail = $response->user ? $response->user->email : null;

        DB::table('consolidated_responses')->insert([
            'user_id' => $response->user_id,
            'user_email' => $userEmail,
            'user_type' => 'docente',
            'response_data' => json_encode($response),
            'created_at' => $response->created_at,
            'updated_at' => $response->updated_at,
        ]);
    }
    }
    }
*/
    private function transferDictaminadorResponses()
    {
        $models = [
            DictaminatorsResponseForm2::class,
            DictaminatorsResponseForm2_2::class,
            DictaminatorsResponseForm3_1::class,
            DictaminatorsResponseForm3_2::class,
            DictaminatorsResponseForm3_3::class,
            DictaminatorsResponseForm3_4::class,
            DictaminatorsResponseForm3_5::class,
            DictaminatorsResponseForm3_6::class,
            DictaminatorsResponseForm3_7::class,
            DictaminatorsResponseForm3_8::class,
            DictaminatorsResponseForm3_9::class,
            DictaminatorsResponseForm3_10::class,
            DictaminatorsResponseForm3_11::class,
            DictaminatorsResponseForm3_12::class,
            DictaminatorsResponseForm3_13::class,
            DictaminatorsResponseForm3_14::class,
            DictaminatorsResponseForm3_15::class,
            DictaminatorsResponseForm3_16::class,
            DictaminatorsResponseForm3_17::class,
            DictaminatorsResponseForm3_18::class,
            DictaminatorsResponseForm3_19::class,
        ];

        foreach ($models as $model) {
            $responses = $model::with('user')->get(); // Asegúrate de que el modelo tenga una relación `user`
            foreach ($responses as $response) {
                // Verifica si el modelo tiene la relación `user` antes de intentar acceder a `email`
                $userEmail = $response->user ? $response->user->email : null;

                DB::table('consolidated_responses')->insert([
                    'user_id' => $response->user_id,
                    'user_email' => $userEmail, // Puede ser null si no hay relación `user`
                    'user_type' => 'dictaminador',
                    'comision1' => $response->comision1,
                    'actv2Comision' => $response->actv2Comision,
                    'actv3Comision' => $response->actv3Comision,
                    'comision3_2' => $response->comision3_2,
                    'comision3_3' => $response->comision3_3,
                    'comision3_4' => $response->comision3_4,
                    'comision3_5' => $response->comision3_5,
                    'comision3_6' => $response->comision3_6,
                    'comision3_7' => $response->comision3_7,
                    'comision3_8' => $response->comision3_8,
                    'comision3_9' => $response->comision3_9,
                    'comision3_10' => $response->comision3_10,
                    'comision3_11' => $response->comision3_11,
                    'comision3_12' => $response->comision3_12,
                    'comision3_13' => $response->comision3_13,
                    'comision3_14' => $response->comision3_14,
                    'comision3_15' => $response->comision3_15,
                    'comision3_16' => $response->comision3_16,
                    'comision3_17' => $response->comision3_17,
                    'comision3_18' => $response->comision3_18,
                    'comision3_19' => $response->comision3_19,

                    'response_data' => json_encode($response),
                    'created_at' => $response->created_at,
                    'updated_at' => $response->updated_at,
                ]);
            }
        }
    }
}

