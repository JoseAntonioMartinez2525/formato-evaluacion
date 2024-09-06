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

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
                    'user_email' => $userEmail, 
                    'user_type' => 'dictaminador',
                    'comision1' => $response->comision1 ?? '0',
                    'actv2Comision' => $response->actv2Comision ?? '0',
                    'actv3Comision' => $response->actv3Comision ?? '0',
                    'comision3_2' => $response->comision3_2 ?? '0',
                    'comision3_3' => $response->comision3_3 ?? '0',
                    'comision3_4' => $response->comision3_4 ?? '0',
                    'comision3_5' => $response->comision3_5 ?? '0',
                    'comision3_6' => $response->comision3_6 ?? '0',
                    'comision3_7' => $response->comision3_7 ?? '0',
                    'comision3_8' => $response->comision3_8 ?? '0',
                    'comision3_9' => $response->comision3_9 ?? '0',
                    'comision3_10' => $response->comision3_10 ?? '0',
                    'comision3_11' => $response->comision3_11 ?? '0',
                    'comision3_12' => $response->comision3_12 ?? '0',
                    'comision3_13' => $response->comision3_13 ?? '0',
                    'comision3_14' => $response->comision3_14 ?? '0',
                    'comision3_15' => $response->comision3_15 ?? '0',
                    'comision3_16' => $response->comision3_16 ?? '0',
                    'comision3_17' => $response->comision3_17 ?? '0',
                    'comision3_18' => $response->comision3_18 ?? '0',
                    'comision3_19' => $response->comision3_19 ?? '0',

                    'response_data' => json_encode($response),
                    'created_at' => $response->created_at,
                    'updated_at' => $response->updated_at,
                ]);
            }
        }
    }



}

