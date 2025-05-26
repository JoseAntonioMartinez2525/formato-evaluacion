{{-- resources/views/reporte_pdf.blade.php --}}
@php
$filas = [
    [
        'actividad' => '1. Permanencia en las actividades de la docencia',
        'maximo' => 100,
        'puntaje' => $comisiones->comision1 ?? ''
    ],
    [
        'actividad' => '1.1 Años de experiencia docente en la institución',
        'maximo' => 100,
        'puntaje' => $comisiones->comision1 ?? '0.00'
    ],
    [
        'actividad' => '2. Dedicación en el desempeño docente',
        'maximo' => 200,
        'puntaje' => $comisiones->actv2Comision ?? '0.00'
    ],
    [
        'actividad' => '2.1 Carga de trabajo docente frente a grupo',
        'maximo' => 200,
        'puntaje' => $comisiones->actv2Comision ?? '0.00'
    ],
    [
        'actividad' => '3. Calidad en la docencia',
        'maximo' => 700,
        'puntaje' => $total ?? '0.00' // <-- Cambia esto
    ],
    [
        'actividad' => '3.1 Participación en actividades de diseño curricular',
        'maximo' => 60,
        'puntaje' => $comisiones->actv3Comision ?? '0.00'
    ],
    [
        'actividad' => '3.2 Calidad del desempeño docente evaluada por los estudiantes',
        'maximo' => 50,
        'puntaje' => $comisiones->comision3_2 ?? '0.00'
    ],
    [
        'actividad' => '3.3 Publicaciones relacionadas con la docencia',
        'maximo' => 100,
        'puntaje' => $comisiones->comision3_3 ?? '0.00'
    ],
    [
        'actividad' => '3.4 Distinciones académicas recibidas por el docente',
        'maximo' => 60,
        'puntaje' => $comisiones->comision3_4 ?? '0.00'
    ],
    [
        'actividad' => '3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC',
        'maximo' => 75,
        'puntaje' => $comisiones->comision3_5 ?? '0.00'
    ],
    [
        'actividad' => '3.6 Capacitación y actualización pedagógica recibida',
        'maximo' => 40,
        'puntaje' => $comisiones->comision3_6 ?? '0.00'
    ],
    [
        'actividad' => '3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento',
        'maximo' => 40,
        'puntaje' => $comisiones->comision3_7 ?? '0.00'
    ],
    [
        'actividad' => '3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente',
        'maximo' => 40,
        'puntaje' => $comisiones->comision3_8 ?? '0.00'
    ],
    [
        'actividad' => '3.8.1 RSU',
        'maximo' => 40,
        'puntaje' => $comisiones->comision3_8_1 ?? '0.00'
    ],
    [
        'actividad' => '3.9 Trabajos dirigidos para la titulación de estudiantes',
        'maximo' => 200,
        'puntaje' => $comisiones->comision3_9 ?? '0.00'
    ],
    [
        'actividad' => '3.10 Tutorías a estudiantes',
        'maximo' => 115,
        'puntaje' => $comisiones->comision3_10 ?? '0.00'
    ],
    [
        'actividad' => '3.11 Asesoría a estudiantes',
        'maximo' => 95,
        'puntaje' => $comisiones->comision3_11 ?? '0.00'
    ],
    [
        'actividad' => '3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte el docente',
        'maximo' => 150,
        'puntaje' => $comisiones->comision3_12 ?? '0.00'
    ],
    [
        'actividad' => '3.13 Proyectos académicos de investigación',
        'maximo' => 130,
        'puntaje' => $comisiones->comision3_13 ?? '0.00'
    ],
    [
        'actividad' => '3.14 Participación como ponente en congresos o eventos académicos del área de conocimiento o afines del docente',
        'maximo' => 40,
        'puntaje' => $comisiones->comision3_14 ?? '0.00'
    ],
    [
        'actividad' => '3.15 Registro de patentes y productos de investigación tecnológica y educativa',
        'maximo' => 60,
        'puntaje' => $comisiones->comision3_15 ?? '0.00'
    ],
    [
        'actividad' => '3.16 Actividades de arbitraje, revisión, corrección y edición',
        'maximo' => 30,
        'puntaje' => $comisiones->comision3_16 ?? '0.00'
    ],
];
$data = [
    'logoBase64' => $logoBase64,
    'convocatoria' => $convocatoria,
    'comisiones' => $comisiones,
    'total' => $total,
    'minimaCalidad' => $minimaCalidad,
    'minimaTotal' => $minimaTotal,
    'totalComisionRepetido' => $totalComisionRepetido,
    'subtotal3_1To3_8_1' => $subtotal3_1To3_8_1,
    'subtotal3_9To3_11' => $subtotal3_9To3_11,
    'subtotal3_12To3_16' => $subtotal3_12To3_16,
    'subtotal3_17To3_19' => $subtotal3_17To3_19,
    '$total' => $total,
    'evaluator_name' => $evaluatorSignature->evaluator_name ?? '',
    'evaluator_name_2' => $evaluatorSignature->evaluator_name_2 ?? '',
    'evaluator_name_3' => $evaluatorSignature->evaluator_name_3 ?? '',
    'signature_path' => $signature_path,
    'signature_path_2' => $signature_path_2,
    'signature_path_3' => $signature_path_3,
    'pagina_inicio' => 31,
    'pagina_total' => 32,
];
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Resumen Comisión PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px;
        }

        th {
            background: #f8f8f8;
        }

        .puntaje {
        background: #f7c873;
        text-align: center;
        padding-right: 10px;
        font-weight: normal; /* Sin negritas */
    }
        .puntaje-principal {
            font-weight: bold;
            text-align: center;
            padding-right: 10px;
            background: none;
        }

        .puntaje_total {
            text-align: center;
        }

        .puntaje-subtotal {
            font-weight: bold;
            text-align: center;
            
        }

        .valorMaximo{
            text-align: center;
        }

        .subtotal {
            font-weight: bold;
            background: #f8f8f8;
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        .center {
            text-align: center;
        }
        .firmas-table td, .firmas-table th {
        border: 1px solid #ccc;
        padding: 8px;
        height: 80px; /* Fija la altura de las filas */
        vertical-align: middle;
    }
        .firma-img {
            max-height: 100px;
            max-width: 180px;
            display: block;
            margin: 0 auto;
            background-color: rgb(232, 240, 254);
        }
        .nombre-evaluador {
            text-align: center;
            font-weight: 500;
            background-color: rgb(232, 240, 254);
        }

        .firma-evaluador {
            text-align: center;
            background-color: rgb(232, 240, 254);
        }
        .firmas-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 40px;
        }
        .pie-pag{
            margin-top: 20px; 
            text-align: right;
        }
    </style>
</head>

<body>
    

<!-- Para reporte_pdf.blade.php -->
<table style="width:100%; border:none; margin-bottom: 10px;">
    <tr>
        <td style="width: 110px; text-align:center; border:none; vertical-align:middle;">
            <img id="logoUniv" src="{{ $logoBase64 }}" alt="Logo UABCS" style="width: 100px;">
        </td>
        <td style="text-align:center; border:none; vertical-align:middle;">
            <h1 style="margin: 0 0 4px 0; font-size: 1.7em;">Secretaría General</h1>
            <h3 style="margin: 0; font-size: 1.1em; color: #666;">Programa de Estímulos al Desempeño del Personal Docente</h3>
        </td>
    </tr>
</table>

<div>
    <h2 class="center">Resumen</h2>
    <h4 class="center">A ser llenado por la Comisión del PEDPD</h4>
</div>
   
    <table>
    @include('components.fila-headers')
        <tbody>
        @foreach($filas as $i => $fila)
                @include('components.filas-pdf', [
                    'actividad' => $fila['actividad'],
                    'maximo' => $fila['maximo'],
                    'puntaje' => $fila['puntaje'],
                    'esPrincipal' => in_array($i, [0, 2, 4])
                ])
            {{-- Inserta subtotales y títulos en el orden correcto --}}
            @if($i == 13)
                <tr>
                    <td colspan="2" class="subtotal"><strong>Subtotal</strong></td>
                    <td class="puntaje-subtotal">{{ $subtotal3_1To3_8_1 ?? '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="1" class="center"><strong>Tutorías</strong></td>
                    <td></td>
                    <td></td>
                </tr>
            @elseif($i == 16)
                <tr>
                    <td colspan="2" class="subtotal">Subtotal</td>
                    <td class="puntaje-subtotal">{{ $subtotal3_9To3_11 ?? '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="1" class="center"><strong>Investigación</strong></td>
                    <td></td>
                    <td></td>
                </tr>
            @elseif($i == 21)
                <tr>
                    <td colspan="2" class="subtotal"><strong>Subtotal</strong></td>
                    <td class="puntaje-subtotal">{{ $subtotal3_12To3_16 ?? '0.00' }}</td>
                </tr>
            @endif
        @endforeach
            <tr>
                <td colspan="3" class="center">
                    <strong>Convocatoria:</strong> {{ $convocatoria }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pie-pag">página 31 de 32</div>

    <table>
    @include('components.fila-headers')
        <tbody>
        {{-- Cuerpos colegiados --}}
        <tr>
            <td colspan="1" class="center"><strong>Cuerpos colegiados</strong></td>
            <td></td>
        </tr>
        <tr>
            <td>3.17 Proyectos académicos de extensión y difusión</td>
            <td class="valorMaximo">50</td>
            <td class="puntaje">{{ $comisiones->comision3_17 ?? '0.00' }}</td>
        </tr>
        <tr>
            <td>3.18 Organización de congresos o eventos institucionales del área de conocimiento del Docente</td>
            <td class="valorMaximo">40</td>
            <td class="puntaje">{{ $comisiones->comision3_18 ?? '0.00' }}</td>
        </tr>
        <tr>
            <td>3.19 Participación en cuerpos colegiados</td>
            <td class="valorMaximo">40</td>
            <td class="puntaje">{{ $comisiones->comision3_19 ?? '0.00' }}</td>
        </tr>
        <tr>
            <td colspan="2" class="subtotal"><strong>Subtotal</strong></td>
            <td class="puntaje-subtotal">{{ $subtotal3_17To3_19 ?? '0.00' }}</td>
        </tr>
        {{-- Total logrado en la evaluación --}}
        <tr>
            <td colspan="2" class="puntaje-subtotal"><strong>Total logrado en la evaluación</strong></td>
            <td class="puntaje_total">{{ $totalComisionRepetido ?? '0.00' }}</td>
        </tr>
        {{-- Detalle de los tres rubros principales --}}
        <tr>
            <td>1. Permanencia en las actividades de la docencia</td>
            <td class="valorMaximo">100</td>
            <td class="puntaje">{{ $comisiones->comision1 ?? '0.00' }}</td>
        </tr>
        <tr>
            <td>2. Dedicación en el desempeño docente</td>
            <td class="valorMaximo">200</td>
            <td class="puntaje">{{ $comisiones->actv2Comision ?? '0.00' }}</td>
        </tr>
        <tr>
            <td>3. Calidad en la docencia</td>
            <td class="valorMaximo">700</td>
            <td class="puntaje">{{ $total ?? '0.00' }}</td>
        </tr>
        <tr>
            <td colspan="2" class="subtotal"><strong>Total de puntaje obtenido en la evaluación</strong></td>
            <td class="puntaje-subtotal">{{ $totalComisionRepetido ?? '0.00' }}</td>
        </tr>
        <tr>
            <td colspan="2" class="center"><strong>Nivel obtenido de acuerdo al artículo 10 del Reglamento</strong></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="center"><strong>Mínima de Calidad</strong></td>
            <td class="center"><strong>{{ $minimaCalidad ?? '' }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td class="center"><strong>Mínima Total</strong></td>
            <td class="center"><strong>{{ $minimaTotal ?? '' }}</strong></td>
        </tr>
        </tbody>           
    </table>

{{-- Salto de página 
<div style="page-break-before: always;"></div> --}}

<table class="firmas-table">
    <thead>
        <tr>
            <th style="text-align:center;">Nombre de la persona evaluadora</th>
            <th style="text-align:center;">Firma</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td class="nombre-evaluador">
            {{ $evaluator_name ?? '' }}
        </td>
        <td class="firma-evaluador">
                @if(!empty($signature_path) && file_exists($signature_path))
                    <img src="{{ $signature_path }}" alt="Firma" class="firma-img">
                @endif
        </td>
    </tr>
    <tr>    
    <td class="nombre-evaluador">
        {{ $evaluator_name_2 ?? '' }}
    </td    >
        <td class="firma-evaluador">
            @if(!empty($signature_path_2) && file_exists($signature_path_2))
                <img src="{{ $signature_path_2 }}" alt="Firma 2" class="firma-img">
            @endif
        </td>
    </tr>
    <tr>
        <td class="nombre-evaluador">
        {{ $evaluator_name_3 ?? '' }}
        </td>
        <td class="firma-evaluador">
            @if(!empty($signature_path_3) && file_exists($signature_path_3))
                <img src="{{ $signature_path_3 }}" alt="Firma" class="firma-img">
            @endif
        </td>
    </tr>
    </tbody>
</table>

<div style="margin-top: 20px; text-align: center;">
    <strong>Convocatoria:</strong> {{ $convocatoria }}
</div>

<div class="pie-pag">página 32 de 32</div>

    {{-- Footer dinámico para Snappy/wkhtmltopdf --}}
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial", "normal");
                $size = 10;
                $convocatoria = "' . addslashes($convocatoria) . '";
                $pagina_inicio = ' . intval($pagina_inicio) . ';
                $pagina_total = ' . intval($pagina_total) . ';
                $y = 820;
                $pdf->text(40, $y, "Programa de estímulos al desempeño del Personal docente: " . $convocatoria, $font, $size);
                $pdf->text(500, $y, "Página " . ($PAGE_NUM + $pagina_inicio - 1) . " de " . $pagina_total, $font, $size);
            ');
        }
    </script>
</body>

</html>