<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ConsolidatedResponseController extends Controller
{
    public function showResumen()
    {
        // Recuperar los datos de comisiones
        $consolidatedResponses = DB::table('consolidated_responses')->get();
        
        // Calcular subtotales para las secciones
        $subtotal3_1To3_8 = $consolidatedResponses->reduce(function ($carry, $response) {
            return $carry + $response->actv3Comision + $response->comision3_2 + $response->comision3_3 + $response->comision3_4 + $response->comision3_5 + $response->comision3_6 + $response->comision3_7 + $response->comision3_8;
        }, 0);

        $subtotal3_9To3_11 = $consolidatedResponses->reduce(function ($carry, $response) {
            return $carry + $response->comision3_9 + $response->comision3_10 + $response->comision3_11;
        }, 0);

        $subtotal3_12To3_16 = $consolidatedResponses->reduce(function ($carry, $response) {
            return $carry + $response->comision3_12 + $response->comision3_13 + $response->comision3_14 + $response->comision3_15 + $response->comision3_16;
        }, 0);

        $subtotal3_17To3_19 = $consolidatedResponses->reduce(function ($carry, $response) {
            return $carry + $response->comision3_17 + $response->comision3_18 + $response->comision3_19;
        }, 0);

        $total = min(
            $subtotal3_1To3_8 + $subtotal3_9To3_11 + $subtotal3_12To3_16 + $subtotal3_17To3_19, 
            700
        );

        $totalComision1 = $consolidatedResponses->first()->comision1 ?? 0;
        $totalComision2 = $consolidatedResponses->first()->actv2Comision ?? 0;
        $totalComision3 = $total; // Calculado anteriormente

        $totalComisionRepetido = min($totalComision1 + $totalComision2 + $totalComision3,700);

        // Evaluar la calidad mínima y el total
        $minimaCalidad = $this->evaluarCalidad($total);
        $minimaTotal = $this->evaluarTotal($totalComisionRepetido);

        // Estructurar los datos en secciones
        $sections = [
            'data' => [
                // Datos de las secciones y subtotales
                ['label' => '1. Permanencia en las actividades de la docencia', 'value' => 100, 'comision' => $consolidatedResponses->first()->comision1 ?? 0],
                ['label' => '1.1 Años de experiencia docente en la institución', 'value' => 100, 'comision' => $consolidatedResponses->first()->comision1 ?? 0],
                ['label' => '2. Dedicación en el desempeño docente', 'value' => 200, 'comision' => $consolidatedResponses->first()->actv2Comision ?? 0],
                ['label' => '2.1 Carga de trabajo docente frente a grupo', 'value' => 200, 'comision' => $consolidatedResponses->first()->actv2Comision ?? 0],
                ['label' => '3. Calidad en la docencia', 'value' => 60, 'comision' => $total],
                // Datos de las secciones 3.1 a 3.8
                ['label' => '3.1 Participación en actividades de diseño curricular', 'value' => 60, 'comision' => $consolidatedResponses->first()->actv3Comision ?? 0],
                ['label' => '3.2 Calidad del desempeño docente evaluada por los estudiantes', 'value' => 50, 'comision' => $consolidatedResponses->first()->comision3_2 ?? 0],
                ['label' => '3.3 Publicaciones relacionadas con la docencia', 'value' => 100, 'comision' => $consolidatedResponses->first()->comision3_3 ?? 0],
                ['label' => '3.4 Distinciones académicas recibidas por el docente', 'value' => 60, 'comision' => $consolidatedResponses->first()->comision3_4 ?? 0],
                ['label' => '3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC', 'value' => 75, 'comision' => $consolidatedResponses->first()->comision3_5 ?? 0],
                ['label' => '3.6 Capacitación y actualización pedagógica recibida', 'value' => 40, 'comision' => $consolidatedResponses->first()->comision3_6 ?? 0],
                ['label' => '3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento', 'value' => 40, 'comision' => $consolidatedResponses->first()->comision3_7 ?? 0],
                ['label' => '3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente', 'value' => 40, 'comision' => $consolidatedResponses->first()->comision3_8 ?? 0],
                ['label' => 'Subtotal', 'value' => '', 'comision' => $subtotal3_1To3_8, 'is_subtotal' => true],
                // Datos de las secciones 3.9 a 3.11
                ['label' => '3.9 Trabajos dirigidos para la titulación de estudiantes', 'value' => 200, 'comision' => $consolidatedResponses->first()->comision3_9 ?? 0],
                ['label' => '3.10 Tutorías a estudiantes', 'value' => 115, 'comision' => $consolidatedResponses->first()->comision3_10 ?? 0],
                ['label' => '3.11 Asesoría a estudiantes', 'value' => 95, 'comision' => $consolidatedResponses->first()->comision3_11 ?? 0],
                ['label' => 'Subtotal', 'value' => '', 'comision' => $subtotal3_9To3_11, 'is_subtotal' => true],
                // Datos de las secciones 3.12 a 3.16
                ['label' => '3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte el docente', 'value' => 150, 'comision' => $consolidatedResponses->first()->comision3_12 ?? 0],
                ['label' => '3.13 Proyectos académicos de investigación', 'value' => 130, 'comision' => $consolidatedResponses->first()->comision3_13 ?? 0],
                ['label' => '3.14 Participación como ponente en congresos o eventos académicos del área de conocimiento o afines del docente', 'value' => 40, 'comision' => $consolidatedResponses->first()->comision3_14 ?? 0],
                ['label' => '3.15 Registro de patentes y productos de investigación tecnológica y educativa', 'value' => 60, 'comision' => $consolidatedResponses->first()->comision3_15 ?? 0],
                ['label' => '3.16 Actividades de arbitraje, revisión, corrección y edición', 'value' => 30, 'comision' => $consolidatedResponses->first()->comision3_16 ?? 0],
                ['label' => 'Subtotal', 'value' => '', 'comision' => $subtotal3_12To3_16, 'is_subtotal' => true],
                // Datos de las secciones 3.17 a 3.19
                ['label' => '3.17 Proyectos académicos de extensión y difusión', 'value' => 50, 'comision' => $consolidatedResponses->first()->comision3_17 ?? 0],
                ['label' => '3.18 Organización de congresos o eventos institucionales del área de conocimiento del Docente', 'value' => 40, 'comision' => $consolidatedResponses->first()->comision3_18 ?? 0],
                ['label' => '3.19 Participación en cuerpos colegiados', 'value' => 40, 'comision' => $consolidatedResponses->first()->comision3_19 ?? 0],
                ['label' => 'Subtotal', 'value' => '', 'comision' => $subtotal3_17To3_19, 'is_subtotal' => true],
            ],
        ];

        if ($consolidatedResponses->isEmpty()) {
            // Si no hay datos, maneja este caso
            return view('form4', [
                'error' => 'No se encontraron respuestas consolidadas.'
            ]);
        }

        $totalComision1 = $consolidatedResponses->first()->comision1 ?? 0;

        return view('resumen_comision', [
            'sections' => $sections,
            'subtotal3_1To3_8' => $subtotal3_1To3_8,
            'subtotal3_9To3_11' => $subtotal3_9To3_11,
            'subtotal3_12To3_16' => $subtotal3_12To3_16,
            'subtotal3_17To3_19' => $subtotal3_17To3_19,
            'totalComision1' => $totalComision1,
            'totalComision2'=> $totalComision2,
            'total' => $total,
            'minimaCalidad' => $minimaCalidad,
            'minimaTotal' => $minimaTotal,
            'totalComisionRepetido' => $totalComisionRepetido,
        ]);

        
    }

    
    // Función para evaluar la calidad mínima
    private function evaluarCalidad($total)
    {
        switch (true) {
            case ($total >= 210 && $total <= 264):
                return 'I';
            case ($total >= 265 && $total <= 319):
                return 'II';
            case ($total >= 320 && $total <= 374):
                return 'III';
            case ($total >= 375 && $total <= 429):
                return 'IV';
            case ($total >= 430 && $total <= 484):
                return 'V';
            case ($total >= 485 && $total <= 539):
                return 'VI';
            case ($total >= 540 && $total <= 594):
                return 'VII';
            case ($total >= 595 && $total <= 649):
                return 'FALSE';
            default:
                return 'FALSE';
        }
    }

    // Función para evaluar el total
    private function evaluarTotal($totalComisionRepetido)
    {
        switch (true) {
            case ($totalComisionRepetido >= 301 && $totalComisionRepetido <= 377):
                return 'I';
            case ($totalComisionRepetido >= 378 && $totalComisionRepetido <= 455):
                return 'II';
            case ($totalComisionRepetido >= 456 && $totalComisionRepetido <= 533):
                return 'III';
            case ($totalComisionRepetido >= 534 && $totalComisionRepetido <= 611):
                return 'IV';
            case ($totalComisionRepetido >= 612 && $totalComisionRepetido <= 689):
                return 'V';
            case ($totalComisionRepetido >= 690 && $totalComisionRepetido <= 767):
                return 'VI';
            case ($totalComisionRepetido >= 768 && $totalComisionRepetido <= 845):
                return 'VII';
            case ($totalComisionRepetido >= 846 && $totalComisionRepetido <= 923):
                return 'VIII';
            case ($totalComisionRepetido >= 924 && $totalComisionRepetido <= 1000):
                return 'IX';
            default:
                return 'FALSE';
        }
    }
}

