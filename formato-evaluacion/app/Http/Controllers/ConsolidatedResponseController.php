<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ConsolidatedResponseController extends Controller
{
    public function showResumen()
    {
        // Recuperar los datos de comisiones
        $consolidatedResponses = DB::table('consolidated_responses')->get();


        // Estructurar los datos en secciones
        $sections = [
            '1.1' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '1.1 Años de experiencia docente en la institución',
                            'value' => 100,
                            'comision' => $response->comision1,
                        ],
                        // Añadir más datos de la sección "Experiencia"
                    ],
                ];
            }),

            '2.1' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '2.1 Carga de trabajo docente frente a grupo',
                            'value' => 200,
                            'comision' => $response->actv2Comision,
                        ],

                    ],
                ];
            }),
            '3.1' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.1 Participación en actividades de diseño curricular',
                            'value' => 60,
                            'comision' => $response->actv3Comision,
                        ],
                    ],
                ];
            }),

            '3.2' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.2 Calidad del desempeño docente evaluada por los estudiantes',
                            'value' => 50,
                            'comision' => $response->comision3_2,
                        ],
                    ],
                ];
            }),

            '3.3' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.3 Publicaciones relacionadas con la docencia',
                            'value' => 100,
                            'comision' => $response->comision3_3,
                        ],
                    ],
                ];
            }),

            '3.4' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.4 Distinciones académicas recibidas por el docente',
                            'value' => 60,
                            'comision' => $response->comision3_4,
                        ],
                    ],
                ];
            }),

            '3.5' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC',
                            'value' => 75,
                            'comision' => $response->comision3_5,
                        ],
                    ],
                ];
            }),

            '3.6' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.6 Capacitación y actualización pedagógica recibida',
                            'value' => 40,
                            'comision' => $response->comision3_6,
                        ],
                    ],
                ];
            }),

            '3.7' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento',
                            'value' => 40,
                            'comision' => $response->comision3_7,
                        ],
                    ],
                ];
            }),

            '3.8' => $consolidatedResponses->map(function ($response) {
                return [
                    'data' => [
                        [
                            'label' => '3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente',
                            'value' => 40,
                            'comision' => $response->comision3_8,
                        ],
                    ],
                ];
            }),


            // Añadir más secciones según sea necesario
        ];

        // Pasar los datos a la vista resumen.blade.php
        return view('resumen', ['sections' => $sections, 'responses' => $consolidatedResponses]);

    }

    
}
