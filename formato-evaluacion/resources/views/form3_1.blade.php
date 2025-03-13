@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Participación en actividades de diseño curricular</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-head-resources />  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
 body.chrome @media print {
    #convocatoria, #convocatoria2 {
        font-size: 1.2rem;
        color: blue; /* Ejemplo de estilo específico para Chrome */
    }


    @html{
        font-size: 2rem;
    }
}

body.chrome @media screen{
       #convocatoria, #convocatoria2 {
        font-size: 1.2rem;
        color: blue; /* Ejemplo de estilo específico para Chrome */
    }

}

#convocatoria2{
    font-weight: normal;
    width: 100%;
    text-align: left;
    margin-top: 20px;
    
}

@media print {
    .print-footer { /* Estilos comunes para ambos footers en la impresión */
        display: table-footer-group !important; /* Asegura que se muestre como footer */
        position: fixed; /* Para que se pegue al final de la página */
        bottom: 0;
        width: 100%;
    }
    .first-page-footer {
        /* Estilos específicos para el footer de la primera página */
    }
    .second-page-footer {
        /* Estilos específicos para el footer de la segunda página */
    }
    /* Oculta el footer que no corresponde a la página actual */
    .first-page-footer {
        display: table-footer-group;
    }
    .second-page-footer {
        display: none;
    }
    table:nth-of-type(2) ~ table .second-page-footer { /* Selecciona el segundo footer solo cuando hay dos tablas antes */
        display: table-footer-group;
    }
    table:nth-of-type(2) ~ table .first-page-footer { /* Oculta el primer footer cuando hay dos tablas antes */
        display: none;
    }
    body {
        -webkit-print-color-adjust: exact;
    }
}

    @media print {
    .page-footer {
        position: relative;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 12px;
        background-color: white;
        padding: 10px 0;
        border-top: 1px solid #ccc;
        page-break-after: always; /* Asegura el salto de página después del footer */
    }
    body {
        
        margin-left: 200px ;
        margin-top: -10px;
        padding: 0;
        font-size: .7rem;
        padding-bottom: 50px;
       
    }
        .footerForm3_1 {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
    }

.prevent-overlap {
    page-break-before: always;
    page-break-inside: avoid; 
}

    #convocatoria, #convocatoria2, #piedepagina1, #piedepagina2 {
        margin: 0;
        font-size: .7rem;
    }

    #piedepagina {
        margin: 0;
    }

    @page {
        size: landscape;
        margin: 20mm; /* Ajusta según sea necesario */
        counter-increment: page;
        
    }
    
    @page:first {
  counter-reset: page 2; /* Initialize the counter to 2 for the first page */
  counter-increment: page;
}


    .page-number-display {
        display: block;
        text-align: center;
        font-size: 12px;
        position: fixed;
        bottom: 10px;
        left: 0;
        width: 100%;
        z-index: 1000;
    }
    
    
}

.page-footer.hidden-footer {
    display: none !important;
}

@media print {
    hidden-footer {
        display: none !important;
    }

    /* Prevent page breaks within table rows */
    table tr {
        page-break-inside: avoid;
    }

    .table-wrap{
      height: 50px; 
      page-break-inside: avoid; 
    }


    /* Página 4 */
/* Mostrar el footer correcto según la página */
    .page-break[data-page="3"] .first-page-footer {
        display: table-footer-group !important;
    }

    .page-break[data-page="4"] .second-page-footer {
        display: table-footer-group !important;
    }



.secretaria-style {
    font-weight: normal;
    font-size: 14px;
    margin-top: 10px;
    text-align: left;
    
}

.secretaria-style #piedepagina1 {
    float: right;
    display: inline-block;
    margin-left: 5px;
    font-weight: normal; /* Opcional, si quieres menos énfasis */
    color: #000;
}

.dictaminador-style {
    font-weight: normal!important;
    font-size: 16px;
    margin-top: 10px;
    text-align: center;
    white-space: nowrap;
}

.dictaminador-style#piedepagina2 {
    margin-left: 800px;
    margin-top: 10px;
    font-weight: normal!important;
    white-space: nowrap;
    
}

/* Estilo para secretaria o userType vacío */
.secretaria-style#piedepagina2 {
    margin-left: 100px;
    margin-top: 0;
    font-weight: normal!important;
    display: inline-block;
    white-space: nowrap;
}
}

.table2{
    margin-top: 300px;
}

body.dark-mode #elaboracion, body.dark-mode #elaboracion2, body.dark-mode #elaboracion3, body.dark-mode #elaboracion4, body.dark-mode #elaboracion5,
body.dark-mode #comisionIncisoA, body.dark-mode #comisionIncisoB, body.dark-mode #comisionIncisoC, body.dark-mode #comisionIncisoD, body.dark-mode #comisionIncisoE

{
    background-color:transparent;
    color: #ffffff;
    }

    body.dark-mode [id^="obs3_1_"]
{
    background-color:transparent;
    color: #ffffff;
    }

        .avoid-page-break {
    page-break-inside: avoid;
    page-break-after: avoid;
    }

    .table td, .table th {
    padding: 2px !important;
    margin: 0 !important;
    vertical-align: middle; /* Asegura que el contenido esté centrado verticalmente */
}

/* Reducir la altura de las filas */
.table tr{
    height: auto !important;
}

    </style>


</head>

<body class="bg-gray-50 text-black/50">

    <div class="relative min-h-screen flex flex-col items-center justify-center">
        @if (Route::has('login'))
            @if (Auth::check())
                <section role="region" aria-label="Response form">
                    <form class="printButtonClass">
                        @csrf
                    <nav class="nav flex-column" style="padding-top: 50px; height: 900px; background-color: #afc7ce;" id="navPrint">
                        <div class="nav-header" style="display: flex; align-items: center; padding-top: 50px;">
                            <li class="nav-item">
                                <a class="nav-link disabled enlaceSN" style="font-size: medium;" href="#">
                                    <i class="fa-solid fa-user"></i>{{ Auth::user()->email }}
                                </a>
                            </li>
                            <li style="list-style: none; margin-right: 20px;">
                                <a class="enlaceSN" href="{{ route('login') }}">
                                    <i class="fas fa-power-off" style="font-size: 24px;" name="cerrar_sesion"></i>
                                </a>
                            </li>
                        </div>
                            <li class="nav-item">
                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('rules') }}">Artículo 10
                                    REGLAMENTO
                                    PEDPD</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser
                                    llenado
                                    por la
                                    Comisión del PEDPD)</a>
                            </li><br>
                            <li id="jsonDataLink" class="d-none">
                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de
                                    los
                                    Usuarios</a>
                            </li>
                            <li id="reportLink" class="nav-item d-none">
                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                    Reporte</a>
                            </li>
                            <li class="nav-item">
                                @if(Auth::user()->user_type === 'dictaminador')
                                <a class="nav-link active enlaceSN" style="width: 200px;"
                                    href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                                @else
                                    <a class="nav-link active enlaceSN" style="width: 200px;"
                                        href="{{ route('secretaria') }}">Selección de Formatos</a>
                                @endif
                            </li>
                        </nav>
                    </form>
                </section>
            @endif
        @endif
    </div>
    <x-general-header />
@php
$user = Auth::user();
$userType = $user->user_type;
$user_identity = $user->id;

@endphp

<button id="toggle-dark-mode" class="btn btn-secondary printButtonClass"><i class="fa-solid fa-moon"></i>&nbspModo Obscuro</button>

<div class="container mt-4" id="seleccionDocente">
    @if($userType !== 'docente')
        <!-- Select para dictaminador seleccionando docentes -->
        <label for="docenteSelect">Seleccionar Docente:</label>
        <select id="docenteSelect" class="form-select"> <!--name="docentes[]" multiple-->
            <option value="">Seleccionar un docente</option>
            <!-- Aquí se llenarán los docentes con JavaScript -->
        </select>
    @endif
</div>

    <main class="container">
        <!--Form for Part 3_1 -->
        <form id="form3_1" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form31', 'form3_1');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
           
                <!-- Actividad 3.1 Participación en actividades de diseño curricular -->
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4" id="pMax60" for="">60</label>
                </h4>
            
<table class="table table-sm">
    <x-table-header />
    <tr>
        <td colspan="5"><b>3. Calidad en la docencia</b></td>
        <td id="docencia"></td>
        <td class="actv3Comision" style="background-color: #ffcc6d; text-align: center; border: none; font-weight: bold;"></td>
        <td></td>
    </tr>
    <!-- Sub-encabezados -->
    <x-sub-headers-form3_1 />

    <!-- Contenido Incisos a) y b) -->
    <tbody data-page="3">
        <tr class="table-wrap">
            <td>a)</td>
            <td>
                <label style="height:84px; width: 170px;">Plan de estudios de una carrera o posgrado nuevo o
                    actualización</label>
            </td>
            <td>
                <label style="height:94px; width: 180px;">Responsable de la Comisión para la elaboración del
                documento</label>
            </td>
            <td id="puntaje60"><b>60</b></td>
            <td class="elabInput"><span id="elaboracion">0</span></td>
            <td><span id="elaboracionSubTotal1"></span></td>
            <td class="comision actv comEstilos">
                @if($userType == 'dictaminador')
                    <input id="comisionIncisoA" class="actv3Comision" type="number" step="0.01" oninput="onActv3Comision()"
                        value="{{ oldValueOrDefault('comisionIncisoA') }}">
                @else
                    <label id="comisionIncisoA"></label>
                @endif
            </td>
            <td class="comEstilos">
                @if($userType == 'dictaminador')
                    <input id="obs3_1_1" name="obs3_1_1" class="table-header" type="text">
                @else
                    <label id="obs3_1_1" class="table-header"></label>
                @endif
            </td>
        </tr>
        <tr  class="table-wrap">
            <td>b)</td>
            <td><label class="form3_1LabelActv" for="">Plan de estudios de una carrera o posgrado nuevo o
                    actualización</label></td>
            <td><label class="form3_1LabelDoc" for="">Colaboración en la Comisión para la elaboración del
                    documento</label></td>
            <td><span id="puntaje40"><b>40</b></span></td>
            <td class="elabInput"><span id="elaboracion2">0</span></td>
            <td><span id="elaboracionSubTotal2" for="" type="text"></span></td>
            <td class="comEstilos">
                @if($userType == 'dictaminador')
                    <input id="comisionIncisoB" type="number" step="0.01" oninput="onActv3Comision()"
                        value="{{ oldValueOrDefault('comisionIncisoB') }}">
                @else
                    <label id="comisionIncisoB"></label>
                @endif
            </td>
            <td>
                @if($userType == 'dictaminador')
                    <input id="obs3_1_2" name="obs3_1_2" type="text">
                @else
                    <label id="obs3_1_2"></label>
                @endif
            </td>
        </tr>
    </tbody>
</table>

<div class="avoid-page-break" style="display: flex; justify-content: space-between; padding-top: -20px;">
    <div id="convocatoria">
        <!-- Mostrar convocatoria -->
        @if(isset($convocatoria))
            <div style="margin-right: -500px;">
                <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
            </div>
        @endif
    </div>
    <div id="piedepagina1"
        class="{{ $userType === 'dictaminador' ? 'dictaminador-style' : ($userType === '' ? 'secretaria-style' : '') }}">
        Página 3 de 33
    </div>
</div><br>

<table class="table table-sm table2">
    <x-table-header />
    
    <tr>
        <td colspan="5"><b>3. Calidad en la docencia</b></td>
        <td id="docencia"></td>
        <td class="actv3Comision" style="background-color: #ffcc6d; text-align: center; border: none; font-weight: bold;"></td>
        <td></td>
    </tr>
    <!--Sub Encabezados-->
    <x-sub-headers-form3_1 />
    
    <!-- Contenido Incisos c), d) y e) -->
    <tbody class="page-break" data-page="4">
        <tr class="table-wrap">
            <td>c)</td>
            <td><label class="form3_1LabelActv" for="">Plan de estudios de una carrera o posgrado nuevo o actualización</label></td>
            <td><label class="form3_1LabelDoc">Elaboración de contenidos mínimos</label></td>
            <td><label id="puntaje10" for=""><b>10</b></label></td>
            <td class="elabInput"><span id="elaboracion3">0</span></td>
            <td><span id="elaboracionSubTotal3" for="" type="text"></span></td>
            <td class="comision actv comEstilos">
                @if($userType == 'dictaminador')
                    <input id="comisionIncisoC" for="" type="number" step="0.01" oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoC') }}">
                @else
                    <label id="comisionIncisoC" name="comisionIncisoC"></label>
                @endif
            </td>
            <td class="comEstilos">
                @if($userType == 'dictaminador')
                    <input id="obs3_1_3" name="obs3_1_3" class="table-header" type="text">
                @else
                    <label id="obs3_1_3" name="obs3_1_3" class="table-header"></label>
                @endif
            </td>
        </tr>
        <tr  class="table-wrap">
            <td>d)</td>
            <td><label class="form3_1LabelActv" for="">Plan de estudios de una carrera o posgrado nuevo o actualización</label></td>
            <td><label class="form3_1LabelDoc">Elaboración de programas de asignatura</label></td>
            <td><label id="puntaje20" for=""><b>20</b></label></td>
            <td class="elabInput"><span id="elaboracion4">0</span></td>
            <td><span id="elaboracionSubTotal4"></span></td>
            <td class="comision actv comEstilos">
                @if($userType == 'dictaminador')
                    <input id="comisionIncisoD" for="" type="number" step="0.01" oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoD') }}">
                @else
                    <label id="comisionIncisoD" name="comisionIncisoD"></label>
                @endif
            </td>
            <td class="comEstilos">
                @if($userType == 'dictaminador')
                    <input id="obs3_1_4" name="obs3_1_4" class="table-header" type="text">
                @else
                    <label id="obs3_1_4" name="obs3_1_4" class="table-header"></label>
                @endif
            </td>
        </tr>
        <tr  class="table-wrap">
            <td>e)</td>
            <td><label class="form3_1LabelActv" for="">Plan de estudios de una carrera o posgrado nuevo o actualización</label></td>
            <td><label class="form3_1LabelDoc">Actualización de programas de asignatura</label></td>
            <td><label id="p10" for=""><b>10</b></label></td>
            <td class="elabInput"><span id="elaboracion5">0</span></td>
            <td><span id="elaboracionSubTotal5"></span></td>
            <td class="comision actv comEstilos">
                @if($userType == 'dictaminador')
                    <input id="comisionIncisoE" for="" type="number" step="0.01" oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoE') }}">
                @else
                    <label id="comisionIncisoE" name="comisionIncisoE"></label>
                @endif
            </td>
            <td class="comEstilos">
                @if($userType == 'dictaminador')
                    <input id="obs3_1_5" name="obs3_1_5" class="table-header" type="text">
                @else
                    <label id="obs3_1_5" name="obs3_1_5" class="table-header"></label>
                @endif
            </td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <!-- Tabla informativa Acreditacion Actividad 3_1 -->

            <th class="acreditacion" scope="col">Acreditacion: </th>

            <th class="descripcion" style="white-space: nowrap;"><b>H.CGU</b> puntos a,b y e; <b>CAAC</b> puntos d y e</th>
            <th>
            @if ($userType != '')
                <button id="btn3_1" type="submit" class="btn custom-btn printButtonClass">Enviar</button>
            @endif
            </th>
            </tr>
                </thead>
            </table>
<!--Convocatoria 2-->
            <div class="avoid-page-break" style="display: flex; justify-content: space-between;padding-top: 15px;">
                <div id="convocatoria2">
                    <!-- Mostrar convocatoria -->
                    @if(isset($convocatoria))

                        <div style="margin-right: -200px;white-space: nowrap;">
                            <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
                        </div>
                    @endif
                </div>

                <div id="piedepagina2"
                    class="{{ $userType === 'dictaminador' ? 'dictaminador-style' : ($userType === '' ? 'secretaria-style' : '') }}">
                    Página 4 de 33
                </div>
            </div>

        </form>
            </div>
    </main>
    <script>

    window.onload = function () {

                function preventOverlap() {
            const footerHeight = document.querySelector('footer')?.offsetHeight || 0;
            const elements = document.querySelectorAll('.prevent-overlap');

            elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const viewportHeight = window.innerHeight;

                if (rect.bottom > viewportHeight - footerHeight) {
                    element.style.pageBreakBefore = "always";
                }
            });
        }

        preventOverlap();

        // Actualizar la paginación antes de imprimir
        // window.addEventListener('beforeprint', updatePagination);
    };


        document.addEventListener('DOMContentLoaded', async () => {
            const userType = @json($userType);  // Inject user type from backend to JS
            const user_identity = @json($user_identity);
            const docenteSelect = document.getElementById('docenteSelect');

            if (docenteSelect) {
                // Cuando el usuario es dictaminador
                if (userType === 'dictaminador') {
                    try {
                        const response = await fetch('/get-docentes');
                        const docentes = await response.json();

                        docentes.forEach(docente => {
                            const option = document.createElement('option');
                            option.value = docente.email;
                            option.textContent = docente.email;
                            docenteSelect.appendChild(option);
                        });

                        docenteSelect.addEventListener('change', async (event) => {
                            const email = event.target.value;

                            if (email) {
                                axios.get('/get-docente-data', { params: { email } })
                                    .then(response => {
                                         const data = response.data;
                                        const scoreElements = document.querySelectorAll('.score3_1');
                                        scoreElements.forEach(element => {
                                            element.textContent = data.form3_1.score3_1 || '0';
                                        });
                                        document.getElementById('elaboracion').textContent = data.form3_1.elaboracion || '0';
                                        document.getElementById('elaboracionSubTotal1').textContent = data.form3_1.elaboracionSubTotal1 || '0';
                                        document.getElementById('elaboracion2').textContent = data.form3_1.elaboracion2 || '0';
                                        document.getElementById('elaboracionSubTotal2').textContent = data.form3_1.elaboracionSubTotal2 || '0';
                                        document.getElementById('elaboracion3').textContent = data.form3_1.elaboracion3 || '0';
                                        document.getElementById('elaboracionSubTotal3').textContent = data.form3_1.elaboracionSubTotal3 || '0';
                                        document.getElementById('elaboracion4').textContent = data.form3_1.elaboracion4 || '0';
                                        document.getElementById('elaboracionSubTotal4').textContent = data.form3_1.elaboracionSubTotal4 || '0';
                                        document.getElementById('elaboracion5').textContent = data.form3_1.elaboracion5 || '0';
                                        document.getElementById('elaboracionSubTotal5').textContent = data.form3_1.elaboracionSubTotal5 || '0';
                                        //document.getElementById('actv3Comision').textContent = data.form3_1.actv3Comision || '0';

                                        // Populate hidden inputs
                                        document.querySelector('input[name="user_id"]').value = data.form3_1.user_id || '';
                                        document.querySelector('input[name="email"]').value = data.form3_1.email || '';
                                        document.querySelector('input[name="user_type"]').value = data.form3_1.user_type || '';

                                        // Actualizar convocatoria
                                        const convocatoriaElement = document.getElementById('convocatoria');
                                        const convocatoriaElement2 = document.getElementById('convocatoria2');
                                        if (convocatoriaElement) {
                                            if (data.form1) {
                                                convocatoriaElement.textContent = data.form1.convocatoria || '';
                                                convocatoriaElement2.textContent = data.form1.convocatoria || '';
                                            } else {
                                                console.error('form1 no está definido en la respuesta.');
                                            }
                                        } else {
                                            console.error('Elemento con ID "convocatoria" no encontrado.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error fetching docente data:', error);
                                    });
                                //await asignarDocentes(user_identity, email);
                            }
                        });
                    } catch (error) {
                        console.error('Error fetching docentes:', error);
                        alert('No se pudo cargar la lista de docentes.');
                    }
                }
                // Cuando el userType está vacío
                else if (userType === '') {
                    const formName = 'form2';
                    try {
                        const response = await fetch('/get-docentes');

                        const docentes = await response.json();

                        docentes.forEach(docente => {
                            const option = document.createElement('option');
                            option.value = docente.email;
                            option.textContent = docente.email;
                            docenteSelect.appendChild(option);
                        });

                        docenteSelect.addEventListener('change', async (event) => {
                            const email = event.target.value;

                            if (email) {
                                axios.get('/get-docente-data', { params: { email } })
                                    .then(response => {
                                        const data = response.data;

                                        // Actualizar convocatoria

                                        // Verifica si la respuesta contiene los datos esperados
                                        if (data.docente) {
                                            const convocatoriaElement = document.getElementById('convocatoria');
                                            const convocatoriaElement2 = document.getElementById('convocatoria2');

                                            // Mostrar la convocatoria si existe
                                            if (convocatoriaElement) {
                                                if (data.docente.convocatoria) {
                                                    
                                                    convocatoriaElement.textContent = data.docente.convocatoria;
                                                    convocatoriaElement2.textContent = data.docente.convocatoria;
                                                    // const existingSpan = convocatoriaElement.querySelector('span#piedepagina1');
                                                  
                                                } else {
                                                    convocatoriaElement.textContent = 'Convocatoria no disponible';
                                                }
                                            }
                                        }
                                    });
                                // Lógica para obtener datos de DictaminatorsResponseForm2
                                try {
                                    const response = await fetch('/get-dictaminators-responses');
                                    const dictaminatorResponses = await response.json();
                                    // Filtrar la entrada correspondiente al email seleccionado
                                    const selectedResponseForm3_1 = dictaminatorResponses.form3_1.find(res => res.email === email);
                                    if (selectedResponseForm3_1) {
 
                                        document.querySelector('input[name="dictaminador_id"]').value = selectedResponseForm3_1.dictaminador_id || '0';
                                        document.querySelector('input[name="user_id"]').value = selectedResponseForm3_1.user_id || '';
                                        document.querySelector('input[name="email"]').value = selectedResponseForm3_1.email || '';
                                        document.querySelector('input[name="user_type"]').value = selectedResponseForm3_1.user_type || '';

                                        const scoreElements = document.querySelectorAll('.score3_1'); // Selecciona todos los elementos con la clase 'score3_1'
                                        scoreElements.forEach(element => {
                                            element.textContent = selectedResponseForm3_1.score3_1 || '0'; // Asigna el valor o '0' como fallback
                                        });
                                        document.getElementById('elaboracion').textContent = selectedResponseForm3_1.elaboracion || '0';
                                        document.getElementById('elaboracionSubTotal1').textContent = selectedResponseForm3_1.elaboracionSubTotal1 || '0';
                                        document.getElementById('elaboracion2').textContent = selectedResponseForm3_1.elaboracion2 || '0';
                                        document.getElementById('elaboracionSubTotal2').textContent = selectedResponseForm3_1.elaboracionSubTotal2 || '0';
                                        document.getElementById('elaboracion3').textContent = selectedResponseForm3_1.elaboracion3 || '0';
                                        document.getElementById('elaboracionSubTotal3').textContent = selectedResponseForm3_1.elaboracionSubTotal3 || '0';
                                        document.getElementById('elaboracion4').textContent = selectedResponseForm3_1.elaboracion4 || '0';
                                        document.getElementById('elaboracionSubTotal4').textContent = selectedResponseForm3_1.elaboracionSubTotal4 || '0';
                                        document.getElementById('elaboracion5').textContent = selectedResponseForm3_1.elaboracion5 || '0';
                                        document.getElementById('elaboracionSubTotal5').textContent = selectedResponseForm3_1.elaboracionSubTotal5 || '0';
                                        
                                        const actv3ComisionElements = document.querySelectorAll('.actv3Comision');
                                        actv3ComisionElements.forEach(element => {
                                            element.textContent = selectedResponseForm3_1.actv3Comision || '0'; // Asigna el valor o '0' como fallback
                                        });
                                        document.querySelector('label[id="comisionIncisoA"]').textContent = selectedResponseForm3_1.comisionIncisoA || '0';
                                        document.querySelector('label[id="comisionIncisoB"]').textContent = selectedResponseForm3_1.comisionIncisoB || '0';
                                        document.querySelector('label[id="comisionIncisoC"]').textContent = selectedResponseForm3_1.comisionIncisoC || '0';
                                        document.querySelector('label[id="comisionIncisoD"]').textContent = selectedResponseForm3_1.comisionIncisoD || '0';
                                        document.querySelector('label[id="comisionIncisoE"]').textContent = selectedResponseForm3_1.comisionIncisoE || '0';
                                        document.querySelector('label[id="obs3_1_1"]').textContent = selectedResponseForm3_1.obs3_1_1 || 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_2"]').textContent = selectedResponseForm3_1.obs3_1_2 || 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_3"]').textContent = selectedResponseForm3_1.obs3_1_3 || 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_4"]').textContent = selectedResponseForm3_1.obs3_1_4 || 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_5"]').textContent = selectedResponseForm3_1.obs3_1_5 || 'sin comentarios';

                                    } else {

                                        console.error('No form3_1 data found for the selected dictaminador.');
                                        // Reset input values if no data found
                                        document.querySelector('input[name="dictaminador_id"]').value = '0';
                                        document.querySelector('input[name="user_id"]').value = '0';
                                        document.querySelector('input[name="email"]').value = '';
                                        document.querySelector('input[name="user_type"]').value = '';
                                        const scoreElements = document.querySelectorAll('.score3_1'); 
                                        scoreElements.forEach(element => {
                                            element.textContent = '0'; 
                                        });
                                        document.getElementById('elaboracion').textContent = '0';
                                        document.getElementById('elaboracionSubTotal1').textContent = '0';
                                        document.getElementById('elaboracion2').textContent = '0';
                                        document.getElementById('elaboracionSubTotal2').textContent = '0';
                                        document.getElementById('elaboracion3').textContent = '0';
                                        document.getElementById('elaboracionSubTotal3').textContent = '0';
                                        document.getElementById('elaboracion4').textContent = '0';
                                        document.getElementById('elaboracionSubTotal4').textContent = '0';
                                        document.getElementById('elaboracion5').textContent = '0';
                                        document.getElementById('elaboracionSubTotal5').textContent = '0';
                                       
                                        const actv3ComisionElements = document.querySelectorAll('.actv3Comision');
                                        actv3ComisionElements.forEach(element => {
                                            element.textContent = '0'; // Asigna '0' cuando no haya datos
                                        });
                                        document.querySelector('label[id="comisionIncisoA"]').textContent = '0';
                                        document.querySelector('label[id="comisionIncisoB"]').textContent = '0';
                                        document.querySelector('label[id="comisionIncisoC"]').textContent = '0';
                                        document.querySelector('label[id="comisionIncisoD"]').textContent = '0';
                                        document.querySelector('label[id="comisionIncisoE"]').textContent = '0';
                                        document.querySelector('label[id="obs3_1_1"]').textContent = 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_2"]').textContent = 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_3"]').textContent = 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_4"]').textContent = 'sin comentarios';
                                        document.querySelector('label[id="obs3_1_5"]').textContent = 'sin comentarios';
                                    }
                                } catch (error) {
                                    console.error('Error fetching dictaminators responses:', error);
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Error fetching docentes:', error);
                        alert('No se pudo cargar la lista de docentes.');
                    }


                }



            }

           const pages = document.querySelectorAll(".page-break");
            const isPrinting = window.matchMedia('print').matches;

            if (isPrinting) {
                const firstFooter = document.querySelector('.first-page-footer');
                const secondFooter = document.querySelector('.second-page-footer');

                // Ocultar/mostrar los pies de página según el contenido visible
                pages.forEach((page) => {
                    if (page.dataset.page === "3") {
                        firstFooter.style.display = 'table-footer-group';
                        secondFooter.style.display = 'none';
                    } else if (page.dataset.page === "4") {
                        firstFooter.style.display = 'none';
                        secondFooter.style.display = 'table-footer-group';
                    }
                });
            }

                    window.addEventListener('beforeprint', () => {
                const pages = document.querySelectorAll(".page-break");

                pages.forEach(page => {
                    const pageNumber = page.getAttribute('data-page');
                    const firstFooter = page.querySelector('.first-page-footer');
                    const secondFooter = page.querySelector('.second-page-footer');

                    if (firstFooter) {
                        firstFooter.style.display = pageNumber === '3' ? 'table-footer-group' : 'none';
                    }

                    if (secondFooter) {
                        secondFooter.style.display = pageNumber === '4' ? 'table-footer-group' : 'none';
                    }
                });
            });
        });


            // Function to handle form submission
            async function submitForm(url, formId) {
            const formData = { };
            const form = document.getElementById(formId);

            if (!form) {
                console.error(`Form with id "${formId}" not found.`);
            return;
        }

            // Gather all related information from the form
            formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
            formData['user_id'] = form.querySelector('input[name="user_id"]').value;
            formData['email'] = form.querySelector('input[name="email"]').value;
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;

            formData['elaboracion'] = document.getElementById('elaboracion').textContent;
            formData['elaboracionSubTotal1'] = document.getElementById('elaboracionSubTotal1').textContent;
            formData['comisionIncisoA'] = document.getElementById('comisionIncisoA').value; // Ensure input value is fetched
            formData['elaboracion2'] = document.getElementById('elaboracion2').textContent;
            formData['elaboracionSubTotal2'] = document.getElementById('elaboracionSubTotal2').textContent;
            formData['comisionIncisoB'] = document.getElementById('comisionIncisoB').value; // Ensure input value is fetched
            formData['elaboracion3'] = document.getElementById('elaboracion3').textContent;
            formData['elaboracionSubTotal3'] = document.getElementById('elaboracionSubTotal3').textContent;
            formData['comisionIncisoC'] = document.getElementById('comisionIncisoC').value; // Ensure input value is fetched
            formData['elaboracion4'] = document.getElementById('elaboracion4').textContent;
            formData['elaboracionSubTotal4'] = document.getElementById('elaboracionSubTotal4').textContent;
            formData['comisionIncisoD'] = document.getElementById('comisionIncisoD').value; // Ensure input value is fetched
            formData['elaboracion5'] = document.getElementById('elaboracion5').textContent;
            formData['elaboracionSubTotal5'] = document.getElementById('elaboracionSubTotal5').textContent;
            formData['comisionIncisoA'] = form.querySelector('input[id="comisionIncisoA"]').value; 
            formData['comisionIncisoB'] = form.querySelector('input[id="comisionIncisoB"]').value;
            formData['comisionIncisoC'] = form.querySelector('input[id="comisionIncisoC"]').value;
            formData['comisionIncisoD'] = form.querySelector('input[id="comisionIncisoD"]').value;   
            formData['comisionIncisoE'] = form.querySelector('input[id="comisionIncisoE"]').value;                      
            const scores = document.querySelectorAll('.score3_1'); // Selecciona todos los elementos con la clase 'score3_1'

            scores.forEach((element, index) => {
                formData[`score3_1_${index}`] = element.textContent; // Asigna los valores dinámicamente con un índice
            });

            const actv3ComisionElements = document.querySelectorAll('.actv3Comision');
            actv3ComisionElements.forEach((element, index) => {
                formData[`actv3Comision_${index}`] = element.textContent; // Asigna los valores dinámicamente con un índice
            });

            // Observations
            formData['obs3_1_1'] = form.querySelector('input[name="obs3_1_1"]').value;
            formData['obs3_1_2'] = form.querySelector('input[name="obs3_1_2"]').value;
            formData['obs3_1_3'] = form.querySelector('input[name="obs3_1_3"]').value;
            formData['obs3_1_4'] = form.querySelector('input[name="obs3_1_4"]').value;
            formData['obs3_1_5'] = form.querySelector('input[name="obs3_1_5"]').value;

            console.log('Form data:', formData);

            try {
            const response = await fetch(url, {
                method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
                },
            body: JSON.stringify(formData),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const responseData = await response.json();
            console.log('Response received from server:', responseData);
        } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
        }
    }
        function minWithSum(value1, value2) {
            const sum = value1 + value2;
            return Math.min(sum, 200);


        }

        document.addEventListener('DOMContentLoaded', function () {

                const toggleDarkModeButton = document.getElementById('toggle-dark-mode');
                if (toggleDarkModeButton) {
                    const widthDarkButton = window.outerWidth - 230;
                    toggleDarkModeButton.style.marginLeft = `${widthDarkButton}px`;
                }

                toggleDarkMode();
            });
    </script>
</body>

</html>