<?php
namespace App\Listeners;

use App\Events\EvaluationCompleted;
use Illuminate\Support\Facades\DB;

class TransferComisionDataListener
{
    // Mapeo de modelos de origen a su respectivo campo de comisión y modelo de destino
    protected $modelMappings = [
        \App\Models\DictaminatorsResponseForm2::class => [
            'sourceField' => 'comision1',
            'destinationModel' => \App\Models\UsersResponseForm2::class,
            'destinationField' => 'comision1',
        ],
        \App\Models\DictaminatorsResponseForm2_2::class => [
            'sourceField' => 'actv2Comision',
            'destinationModel' => \App\Models\UsersResponseForm2_2::class,
            'destinationField' => 'actv2Comision',
        ],
        \App\Models\DictaminatorsResponseForm3_1::class => [
            'sourceField' => 'actv3Comision',
            'destinationModel' => \App\Models\UsersResponseForm3_1::class,
            'destinationField' => 'actv3Comision',
        ],
        \App\Models\DictaminatorsResponseForm3_2::class => [
            'sourceField' => 'comision3_2',
            'destinationModel' => \App\Models\UsersResponseForm3_2::class,
            'destinationField' => 'comision3_2',
        ],

        \App\Models\DictaminatorsResponseForm3_3::class => [
            'sourceField' => 'comision3_3',
            'destinationModel' => \App\Models\UsersResponseForm3_3::class,
            'destinationField' => 'comision3_3',
        ],
        \App\Models\DictaminatorsResponseForm3_4::class => [
            'sourceField' => 'comision3_4',
            'destinationModel' => \App\Models\UsersResponseForm3_4::class,
            'destinationField' => 'comision3_4',
        ],
        \App\Models\DictaminatorsResponseForm3_5::class => [
            'sourceField' => 'comision3_5',
            'destinationModel' => \App\Models\UsersResponseForm3_5::class,
            'destinationField' => 'comision3_5',
        ],
        \App\Models\DictaminatorsResponseForm3_6::class => [
            'sourceField' => 'comision3_6',
            'destinationModel' => \App\Models\UsersResponseForm3_6::class,
            'destinationField' => 'comision3_6',
        ],
        \App\Models\DictaminatorsResponseForm3_7::class => [
            'sourceField' => 'comision3_7',
            'destinationModel' => \App\Models\UsersResponseForm3_7::class,
            'destinationField' => 'comision3_7',
        ],
        \App\Models\DictaminatorsResponseForm3_8::class => [
            'sourceField' => 'comision3_8',
            'destinationModel' => \App\Models\UsersResponseForm3_8::class,
            'destinationField' => 'comision3_8',
        ],
        \App\Models\DictaminatorsResponseForm3_9::class => [
            'sourceField' => 'comision3_9',
            'destinationModel' => \App\Models\UsersResponseForm3_9::class,
            'destinationField' => 'comision3_9',
        ],
        \App\Models\DictaminatorsResponseForm3_10::class => [
            'sourceField' => 'comision3_10',
            'destinationModel' => \App\Models\UsersResponseForm3_10::class,
            'destinationField' => 'comision3_10',
        ],
        \App\Models\DictaminatorsResponseForm3_11::class => [
            'sourceField' => 'comision3_11',
            'destinationModel' => \App\Models\UsersResponseForm3_11::class,
            'destinationField' => 'comision3_11',
        ],
        \App\Models\DictaminatorsResponseForm3_12::class => [
            'sourceField' => 'comision3_12',
            'destinationModel' => \App\Models\UsersResponseForm3_12::class,
            'destinationField' => 'comision3_12',
        ],
        \App\Models\DictaminatorsResponseForm3_13::class => [
            'sourceField' => 'comision3_13',
            'destinationModel' => \App\Models\UsersResponseForm3_13::class,
            'destinationField' => 'comision3_13',
        ],
        \App\Models\DictaminatorsResponseForm3_14::class => [
            'sourceField' => 'comision3_14',
            'destinationModel' => \App\Models\UsersResponseForm3_14::class,
            'destinationField' => 'comision3_14',
        ],
        \App\Models\DictaminatorsResponseForm3_15::class => [
            'sourceField' => 'comision3_15',
            'destinationModel' => \App\Models\UsersResponseForm3_15::class,
            'destinationField' => 'comision3_15',
        ],
        \App\Models\DictaminatorsResponseForm3_16::class => [
            'sourceField' => 'comision3_16',
            'destinationModel' => \App\Models\UsersResponseForm3_16::class,
            'destinationField' => 'comision3_16',
        ],
        \App\Models\DictaminatorsResponseForm3_17::class => [
            'sourceField' => 'comision3_17',
            'destinationModel' => \App\Models\UsersResponseForm3_17::class,
            'destinationField' => 'comision3_17',
        ],
        \App\Models\DictaminatorsResponseForm3_18::class => [
            'sourceField' => 'comision3_18',
            'destinationModel' => \App\Models\UsersResponseForm3_18::class,
            'destinationField' => 'comision3_18',
        ],             
        \App\Models\DictaminatorsResponseForm3_19::class => [
            'sourceField' => 'comision3_19',
            'destinationModel' => \App\Models\UsersResponseForm3_19::class,
            'destinationField' => 'comision3_19',
        ],
    ];

    public function handle(EvaluationCompleted $event)
    {
        foreach ($this->modelMappings as $sourceModel => $mapping) {
            // Obtener los datos del dictaminador
            $dictaminator = DB::table($sourceModel::getTable())
                ->where('user_id', $event->user_id) // Cambia aquí para usar dictaminador_id
                ->first();

            if ($dictaminator) {
                // Transferir datos a la tabla correspondiente
                $destinationModel = $mapping['destinationModel'];
                $sourceField = $mapping['sourceField'];
                $destinationField = $mapping['destinationField'];

                DB::table($destinationModel::getTable())
                    ->where('user_id', $dictaminator->user_id)
                    ->update([$destinationField => $dictaminator->$sourceField]);
            }
        }
    }
}

