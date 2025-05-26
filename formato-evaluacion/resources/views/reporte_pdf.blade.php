{{-- resources/views/reporte_pdf.blade.php --}}
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
            font-weight: bold;
            text-align: right;
        }

        .subtotal {
            font-weight: bold;
            background: #f8f8f8;
        }

        .page-break {
            page-break-before: always;
        }

        .center {
            text-align: center;
        }

        #logoUniv{
    width: 150px; height: auto; margin-bottom: 10px;margin-left: -550px; margin-top: 30px;
    }
    </style>
</head>

<body>
    
<img id="logoUniv" src="{{ $logoBase64 }}"  alt="Logo UABCS">
    <h1 class="center">Secretaría General</h1>
    <h3 class="center">Programa de Estímulos al Desempeño del Personal Docente</h3>
   


<div>
<h2 class="center">Resumen</h2>
<h4 class="center">A ser llenado por la Comisión del PEDPD</h4>

</div>
   
    <table>
        <thead>
            <tr>
                <th>Actividad</th>
                <th>Puntaje máximo</th>
                <th>Puntaje otorgado<br>Comisión PEDPD</th>
            </tr>
        </thead>
        <tbody>
            {{-- Ejemplo de filas, usa tus variables dinámicas --}}
            <tr>
                <td>1. Permanencia en las actividades de la docencia</td>
                <td>100</td>
                <td class="puntaje">{{ $comisiones->comision1 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>1.1 Años de experiencia docente en la institución</td>
                <td>100</td>
                <td class="puntaje">{{ $comisiones->comision1_1 ?? '0.00' }}</td>
            </tr>
            {{-- ...ya tienes 1. y 1.1... --}}
            <tr>
                <td>2. Dedicación en el desempeño docente</td>
                <td>200</td>
                <td class="puntaje">{{ $comisiones->actv2Comision ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>2.1 Carga de trabajo docente frente a grupo</td>
                <td>200</td>
                <td class="puntaje">{{ $comisiones->actv2Comision ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3. Calidad en la docencia</td>
                <td>700</td>
                <td class="puntaje">{{ $comisiones->total ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.1 Participación en actividades de diseño curricular</td>
                <td>60</td>
                <td class="puntaje">{{ $comisiones->actv3Comision ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.2 Calidad del desempeño docente evaluada por los estudiantes</td>
                <td>50</td>
                <td class="puntaje">{{ $comisiones->comision3_2 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.3 Publicaciones relacionadas con la docencia</td>
                <td>100</td>
                <td class="puntaje">{{ $comisiones->comision3_3 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.4 Distinciones académicas recibidas por el docente</td>
                <td>60</td>
                <td class="puntaje">{{ $comisiones->comision3_4 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC</td>
                <td>75</td>
                <td class="puntaje">{{ $comisiones->comision3_5 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.6 Capacitación y actualización pedagógica recibida</td>
                <td>40</td>
                <td class="puntaje">{{ $comisiones->comision3_6 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento</td>
                <td>40</td>
                <td class="puntaje">{{ $comisiones->comision3_7 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente</td>
                <td>40</td>
                <td class="puntaje">{{ $comisiones->comision3_8 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.8.1 RSU</td>
                <td>40</td>
                <td class="puntaje">{{ $comisiones->comision3_8_1 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="subtotal"><strong>Subtotal</strong></td>
                <td class="puntaje">{{ $subtotal3_1To3_8_1 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td colspan="1" class="center"><strong>Tutorías</strong></td>
            </tr>
            <tr>
                <td>3.9 Trabajos dirigidos para la titulación de estudiantes</td>
                <td>200</td>
                <td class="puntaje">{{ $comisiones->comision3_9 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.10 Tutorías a estudiantes</td>
                <td>115</td>
                <td class="puntaje">{{ $comisiones->comision3_10 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.11 Asesoría a estudiantes</td>
                <td>95</td>
                <td class="puntaje">{{ $comisiones->comision3_11 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="subtotal">Subtotal</td>
                <td class="puntaje">{{ $subtotal3_9To3_11 ?? '0.00' }}</td>
            </tr>
            {{-- Investigación --}}
            <tr>
                <td colspan="1" class="center"><strong>Investigación</strong></td>
                <td></td>
            </tr>
            <tr>
                <td>3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte el docente</td>
                <td>150</td>
                <td class="puntaje">{{ $comisiones->comision3_12 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.13 Proyectos académicos de investigación</td>
                <td>130</td>
                <td class="puntaje">{{ $comisiones->comision3_13 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.14 Participación como ponente en congresos o eventos académicos del área de conocimiento o afines del docente
                </td>
                <td>40</td>
                <td class="puntaje">{{ $comisiones->comision3_14 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.15 Registro de patentes y productos de investigación tecnológica y educativa</td>
                <td>60</td>
                <td class="puntaje">{{ $comisiones->comision3_15 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.16 Actividades de arbitraje, revisión, corrección y edición</td>
                <td>30</td>
                <td class="puntaje">{{ $comisiones->comision3_16 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="subtotal"><strong>Subtotal</strong></td>
                <td class="puntaje">{{ $subtotal3_12To3_16 ?? '0.00' }}</td>
            </tr>
            {{-- Cuerpos colegiados --}}
            <tr>
                <td colspan="1" class="center"><strong>Cuerpos colegiados</strong></td>
                <td></td>
            </tr>
            <tr>
                <td>3.17 Proyectos académicos de extensión y difusión</td>
                <td>50</td>
                <td class="puntaje">{{ $comisiones->comision3_17 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.18 Organización de congresos o eventos institucionales del área de conocimiento del Docente</td>
                <td>40</td>
                <td class="puntaje">{{ $comisiones->comision3_18 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3.19 Participación en cuerpos colegiados</td>
                <td>40</td>
                <td class="puntaje">{{ $comisiones->comision3_19 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="subtotal"><strong>Subtotal</strong></td>
                <td class="puntaje">{{ $subtotal3_17To3_19 ?? '0.00' }}</td>
            </tr>
            {{-- Total logrado en la evaluación --}}
            <tr>
                <td colspan="2" class="subtotal"><strong>Total logrado en la evaluación</strong></td>
                <td class="puntaje">{{ $total ?? '0.00' }}</td>
            </tr>
            {{-- Detalle de los tres rubros principales --}}
            <tr>
                <td>1. Permanencia en las actividades de la docencia</td>
                <td>100</td>
                <td class="puntaje">{{ $comisiones->comision1 ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>2. Dedicación en el desempeño docente</td>
                <td>200</td>
                <td class="puntaje">{{ $comisiones->actv2Comision ?? '0.00' }}</td>
            </tr>
            <tr>
                <td>3. Calidad en la docencia</td>
                <td>700</td>
                <td class="puntaje">{{ $comisiones->total ?? '0.00' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="subtotal"><strong>Total de puntaje obtenido en la evaluación</strong></td>
                <td class="puntaje">{{ $totalComisionRepetido ?? '0.00' }}</td>
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
            {{-- Convocatoria justo debajo del conjunto de los formularios que quepan en cada pagina --}}
            <tr>
                <td colspan="3" class="center">
                    <strong>Convocatoria:</strong> {{ $convocatoria }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Salto de página antes del siguiente subtotal --}}
    <div class="page-break"></div>
{{-- Salto de página --}}
<div style="page-break-before: always;"></div>

<table style="width: 100%; margin-top: 40px;">
    <thead>
        <tr>
            <th style="text-align:center;">Nombre de la persona evaluadora</th>
            <th style="text-align:center;">Firma</th>
        </tr>
    </thead>
    <tbody>
    <tr>
    <td style="text-align:center;">
        {{ $evaluator_name ?? '' }}
    </td>
    <td style="text-align:center;">
    @if(!empty($signature_path) && file_exists($signature_path))
    <img src="{{ $signature_path }}" alt="Firma" style="height:100px;">
    @endif
    </td>
</tr>

<tr>
    <td style="text-align:center;">
        {{ $evaluator_name_2 ?? '' }}
    </td>
    <td style="text-align:center;">
    @if(!empty($signature_path_2) && file_exists($signature_path_2))
    <img src="{{ $signature_path_2 }}" alt="Firma 2" style="height:100px;">
@endif
</td>
</tr>

<tr>
    <td style="text-align:center;">
        {{ $evaluator_name_3 ?? '' }}
    </td>
    <td style="text-align:center;">
    @if(!empty($signature_path_3) && file_exists($signature_path_3))
    <img src="{{ $signature_path_3 }}" alt="Firma" style="height:100px;">
@endif
</td>
</tr>
    </tbody>
</table>

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