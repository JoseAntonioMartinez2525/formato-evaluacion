@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="{{ $newLocale }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formato de Evaluación docente</title>

    <x-head-resources />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/resumen_comision.js') }}"></script>
</head>
<style>
    #nivelLabel{
    padding-right: 190px;
}

 #minimaCalidad{
    padding-left: 120px;
 }

#minimaTotal{
    padding-left: 120px;
}

.evaluadores{
    background-color: rgb(232, 240, 254); 
    width: 300px;
}

</style>
<body class="bg-gray-50 text-black/50">

    <div class="relative min-h-screen flex flex-col items-center justify-center">
        @if (Route::has('login'))
                @if (Auth::check())
                    <section role="region" aria-label="Response form">
                        <form class="printButtonClass">
                            @csrf
                            <nav class="nav flex-column" style="padding-top: 50px; height: 900px; background-color: #afc7ce;">
                                <div class="nav-header" style="display: flex; align-items: center; padding-top: 50px;">
                                    <li class="nav-item">
                                        <a class="nav-link disabled enlaceSN" style="font-size: medium;" href="#">
                                            <i class="fa-solid fa-user"></i>{{ Auth::user()->email }}
                                        </a>
                                    </li>
                                    <li style="list-style: none; margin-right: 20px;">
                                        <a href="{{ route('login') }}">
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
                                    <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('resumen_comision') }}">Resumen (A ser
                                        llenado
                                        por la
                                        Comisión del PEDPD)</a>
                                </li><br>
                                <li id="reportLink" class="nav-item d-none">
                                    <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                        Reporte</a>
                                </li>
                                <li class="nav-item">
                                    @if(Auth::user()->user_type === 'dictaminador')
                                        <a class="nav-link active enlaceSN" style="width: 200px;"
                                            href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                                    @else
                                        <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('secretaria') }}">Selección de
                                            Formatos</a>
                                    @endif
                                </li>
                                <li id="jsonDataLink" class="d-none">
                                    <a class="enlaceSN" href="{{ route('json-generator') }}" class="btn btn-primary" style="display: none;">Mostrar datos de los
                                        Usuarios</a>
                                </li>
                            </nav>
                        </form>
                    </section>
                @endif

            </div>
            <x-general-header />
@php
    $user = Auth::user();
    $userType = $user->user_type;
    $user_identity = $user->id; 
@endphp
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
                    <main class="container" id="formContainer" style="display: none;">
                    <form id="form4" method="POST" enctype="multipart/form-data"
                    onsubmit="event.preventDefault(); submitForm('/store-resume', 'form4');">
                    @csrf
                    <div>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <input type="hidden" name="user_type" value="{{ Auth::user()->user_type }}">
                    <center>
                    <h2 id="resumen">Resumen</h2>
                    <h4>A ser llenado por la Comisión del PEDPD</h4>
                    </center>
                    <table class="resumenTabla">
                    <thead>
                        <tr>
                            <th id="actv">Actividad</th>
                            <th id="pMaximo">Puntaje máximo</th>
                            <th id="pComision">Puntaje otorgado Comisión PEDPD</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                        <!-- Aquí se llenarán los datos del dictaminador con JavaScript -->
                    </tbody>
                    </table>
                    <table>
                    <thead>
                        <tr>
                            <th id="nivelLabel">Nivel obtenido de acuerdo al artículo 10 del Reglamento</th>
                            <th colspan="1" id="minimaLabel">Mínima de Calidad</th>
                            <th colspan="2" id="minimaCalidad"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <th style="padding-right: 200px;"></th>
                            <th class="minima">Mínima Total</th>
                            <th id="minimaTotal"></th>

                    </tbody>
                    </table>
                    <center>
                    @if(Auth::user()->user_type === 'dictaminador')
                        <button type="submit" class="btn custom-btn buttonSignature">Enviar</button>
                    @endif
                    </center>
                    </div>
                    </form>
                        <form id="form5" method="POST" enctype="multipart/form-data"
                            onsubmit="event.preventDefault(); submitForm('/store-evaluator-signature', 'form5');">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="email" id="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="user_type" id="user_type" value="{{ auth()->user()->user_type }}">


                            <table>
                                <thead>
                                    <tr>
                                        <th class="evaluadores">
                                            <!--*Implementacion en caso que el usuario sea vacio-->
                                        @if($userType === '')
                                            <span class="personaEvaluadora1" type="text" id="personaEvaluadora1" ></span>
                                        @elseif($userType === 'dictaminador')
                                            <input class="personaEvaluadora1" type="text" id="personaEvaluadora1" style="background:transparent;
                    border: 15px rgba(0, 0, 0, 0);">
                                        @endif
                                        </th>
                                        <th>
                                        @if($userType === 'dictaminador')
                                            <input type="file" class="form-control" id="firma1" name="firma1" accept="image/*">
                                        @endif
                                        </th>
                                        <th>
                                            <!-- Aquí se mostrará la firma 1 si ya ha sido subida -->
                                    @if(isset($signature_path_1))  
                                        <img id="signature_path_1" src="{{ $signature_path_1 }}" alt="Firma 1" class="imgFirma" data-firma="firma1"
                                            style="display:block;">
                                    @else
                                        <img src="" alt="Firma 1" class="imgFirma" data-firma="firma1" style="display:none;">
                                    @endif
                                        </th>
                                    </tr>
                                    <tr>

                                        <td class="p-2 nombreLabel">Nombre de la persona evaluadora</td>
                                        <td></td>
                                        <td class="p-2"><span id="firmaTexto">Firma</span>
                                        @if($userType === 'dictaminador')
                                            <small class="text-muted">Tamaño máximo permitido: 2MB</small>
                                        </td>
                                    @endif

                                    </tr>
                                    <tr>
                                        <th class="evaluadores">
                                        @if($userType !== '')   
                                        <input class="personaEvaluadora2" type="text" id="personaEvaluadora2" style="background:transparent;
                                                border: 15px rgba(0, 0, 0, 0);">
                                        @else
                                        <span class="personaEvaluadora2" type="text" id="personaEvaluadora2"></span>
                                        @endif
                                        </th>
                                        <th>
                                        @if($userType === 'dictaminador')
                                            <input type="file" class="form-control" id="firma2" name="firma2" accept="image/*">
                                            @endif
                                        </th>
                                        <th>
                                            <!-- Aquí se mostrará la firma 2 si ya ha sido subida -->
                                            @if(isset($signature_path_2))  
                                                <img id="signature_path_2" src="{{ $signature_path_2 }}" alt="Firma 2" class="imgFirma" data-firma="firma2"
                                                    style="display:block;">
                                            @else
                                            <img src="" alt="Firma 2" class="imgFirma" data-firma="firma2" style="display:none;">
                                        @endif

                                        </th>
                                    </tr>
                                    <tr>

                                        <td class="p-2 nombreLabel">Nombre de la persona evaluadora</td>
                                        <td></td>
                                        <td class="p-2"><span id="firmaTexto2">Firma</span>
                                        @if($userType === 'dictaminador')
                                            <small class="text-muted">Tamaño máximo permitido: 2MB</small>
                                        </td>
                                    @endif
                                    </tr>
                                    <tr>
                                        <th class="evaluadores">
                                        @if($userType !== '')   
                                        <input class="personaEvaluadora3" type="text" id="personaEvaluadora3" style="background:transparent;
                                                border: 15px rgba(0, 0, 0, 0);">
                                        @else
                                            <span class="personaEvaluadora3" type="text" id="personaEvaluadora3"></span>
                                        @endif
                                        </th>
                                        <th>
                                        @if($userType === 'dictaminador')
                                            <input type="file" class="form-control" id="firma3" name="firma3" accept="image/*">
                                        @endif
                                        </th>
                                        <th>
                                            <!-- Aquí se mostrará la firma 3 si ya ha sido subida -->
                                        @if(isset($signature_path_3))
                                        <img id="signature_path_3" src="{{ $signature_path_3 }}" alt="Firma 3" class="imgFirma" data-firma="firma3"
                                        style="display:block;">
                                        @else
                                        <img src="" alt="Firma 3" class="imgFirma" data-firma="firma3" style="display:none;">
                                        @endif
                                        </th>


                                    </tr>
                                    <tr>
                                        <td class="p-2 mr-2 nombreLabel">Nombre de la persona evaluadora</td>
                                        <td></td>
                                        <td class="p-2"><span id="firmaTexto3">Firma</span>
                                        @if($userType === 'dictaminador')
                                            <small class="text-muted">Tamaño máximo permitido: 2MB</small>
                                        </td>
                                        @endif

                                    </tr>
                                    <tr>
                                        <td style="padding-left: 600px;">
                                        @if(Auth::user()->user_type === 'dictaminador')
                                        <button type="submit" class="btn custom-btn buttonSignature2">Enviar</button>
                                        @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <footer id="convocatoria"></footer>
                        </form>

                        </main>

        @endif
    </div>

    <div>

    </div>
    </div>
    </div>
    </div>

    <script>
    const labels = [
        '1. Permanencia en las actividades de la docencia  ',
        '1.1 Años de experiencia docente en la institución  ',
        '2. Dedicación en el desempeño docente  ',
        '2.1 Carga de trabajo docente frente a grupo  ',
        '3. Calidad en la docencia  ',
        '3.1 Participación en actividades de diseño curricular  ',
        '3.2 Calidad del desempeño docente evaluada por los estudiantes ',
        '3.3 Publicaciones relacionadas con la docencia',
        '3.4 Distinciones académicas recibidas por el docente',
        '3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC',
        '3.6 Capacitación y actualización pedagógica recibida',
        '3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento',
        '3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente',
        'Subtotal ',
        'Tutorias',
        '3.9 Trabajos dirigidos para la titulación de estudiantes',
        '3.10 Tutorías a estudiantes',
        '3.11 Asesoría a estudiantes',
        'Subtotal',
        'Investigación',
        '3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte el docente',
        '3.13 Proyectos académicos de investigación',
        '3.14 Participación como ponente en congresos o eventos académicos del área de conocimiento o afines del docente',
        '3.15 Registro de patentes y productos de investigación tecnológica y educativa',
        '3.16 Actividades de arbitraje, revisión, corrección y edición',
        'Subtotal',
        'Cuerpos colegiados',
        '3.17 Proyectos académicos de extensión y difusión',
        '3.18 Organización de congresos o eventos institucionales del área de conocimiento del Docente',
        '3.19 Participación en cuerpos colegiados',
        'Subtotal',
        'Total logrado en la evaluación',
        '1. Permanencia en las actividades de la docencia ',
        '2. Dedicación en el desempeño docente',
        '3. Calidad en la docencia',
        'Total de puntaje obtenido en la evaluación',
    ];

    const values = [100, 100, 200, 200, 700, 60, 50, 100, 60, 75, 40, 40, 40, null, null,
        200, 115, 95, null, null, 150, 130, 40, 60, 30, null, null, 50, 40, 40, null, null, 100, 200, 700, null];

        function handleClick(event) {
            var currentTarget = event.currentTarget;
            // Use the event data here. 
            console.log('Button clicked: ' + currentTarget.getAttribute('data-id'));
        } document.addEventListener('DOMContentLoaded', onload);

        function actualizarResultados() {
                const minimaCalidad = evaluarCalidad(sumaComision3);
                const minimaTotal = evaluarTotal(totalLogrado);

                // Actualizar el DOM con los valores calculados
                document.getElementById('minimaCalidad').textContent = minimaCalidad;
                document.getElementById('minimaTotal').textContent = minimaTotal;
            }


        function hayObservacion(indiceActividad) {
            var selectEscala = document.getElementById('selectEscala' + indiceActividad);
            var selectActividad = document.getElementById('selectActividad' + indiceActividad);
            var inputObservacion = document.getElementById('observacion' + indiceActividad);
            var mensajeObservacion = document.getElementById('mensajeObservacion' + indiceActividad);

            if (selectActividad.value != 0 && selectEscala.value != 0) {
                mensajeObservacion.textContent = 'Observación: ' + inputObservacion.value;
                mensajeObservacion.style.display = 'block';
                return true;
            } else {
                mensajeObservacion.style.display = 'none';
                return false;
            }
        }


        const nav = document.querySelector('nav');
        let lastScrollLeft = 0; // Variable to store the last horizontal scroll position

        window.addEventListener('scroll', () => {
            let currentScrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

            // Check if scrolling to the right
            if (currentScrollLeft > lastScrollLeft) {
                // Scrolling to the right, hide the navigation
                nav.style.display = 'none';
            } else {
                // Scrolling to the left or not horizontally, show the navigation
                nav.style.display = 'block';
            }

            lastScrollLeft = currentScrollLeft <= 0 ? 0 : currentScrollLeft; // For Mobile or negative scrolling
        });



        // Function to check if there is an observation for a specific activity
        function hayObservacion(actividad) {
            const obs = document.querySelector(`#obs${actividad}`).value;
            return obs.trim() !== '';
        }

        function minWithSum(value1, value2) {
            const sum = value1 + value2;
            return Math.min(sum, 200);


        }

        function min40(...values) {
            const sum40 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum40, 40);
        }

        function min30(...values) {
            const sum30 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum30, 30);
        }

        function subtotal(value1, value2) {
            const st = value1 * value2;
            return st;
        }

        function min60(...values) {
            const sum60 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum60, 60);
        }

        function minWithSumThree(value1, value2, value3, value4) {
            const ms = value1 + value2 + value3 + value4;
            return Math.min(ms, 100);
        }

        function min50(...values) {
            const ms = values.reduce((acc, val) => acc + val, 0);
            return Math.min(ms, 50);
        }

        function minWithSumThreeFive(value1, value2) {
            const ms = value1 + value2;
            return Math.min(ms, 75);
        }

        function minTutorias() {
            // convert the arguments object to an array
            const values = Array.from(arguments);

            // use reduce to sum the values
            const ms = values.reduce((acc, current) => {
                return acc + current;
            }, 0);

            // return the minimum of ms and 200
            return Math.min(ms, 200);
        }

        function min700(...values) {
            const ms = values.reduce((acc, val) => acc + val, 0);
            return Math.min(ms, 700);
        }

        // Función para actualizar el objeto data con los valores de los campos del formulario
        function actualizarData() {
            data[this.id] = this.value;
        }


        document.addEventListener('DOMContentLoaded', function () {
            const userEmail = "{{ Auth::user()->email }}"; // Obtén el email del usuario desde Blade

            const allowedEmails = [
                'joma_18@alu.uabcs.mx',
                'oa.campillo@uabcs.mx',
                'rluna@uabcs.mx',
                'v.andrade@uabcs.mx'
            ];

            // Verifica si el email está en la lista de correos permitidos
            if (allowedEmails.includes(userEmail)) {
                // Muestra el enlace
                document.getElementById('jsonDataLink').classList.remove('d-none');
            }
        });

        /*
    document.addEventListener('DOMContentLoaded', async () => {
        const userType = @json($userType); 
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const user_identity = @json($user_identity);
        const docenteSelect = document.getElementById('docenteSelect');
        const dictaminadorSelect = document.getElementById('dictaminadorSelect');
        const formContainer = document.getElementById('formContainer');
        constdataContainer = document.getElementById(data');
       
        

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

                                    // Actualizar convocatoria

                                    // Verifica si la respuesta contiene los datos esperados
                                    if (data.docente) {
                                        const convocatoriaElement = document.getElementById('convocatoria');

                                        // Mostrar la convocatoria si existe
                                        if (convocatoriaElement) {
                                            if (data.docente.convocatoria) {
                                                convocatoriaElement.textContent = data.docente.convocatoria;
                                            } else {
                                                convocatoriaElement.textContent = 'Convocatoria no disponible';
                                            }
                                        }
                                    }
                                });
                            // Lógica para obtener datos de DictaminatorsResponseForm
                            try {
                                const response = await fetch('/get-dictaminators-responses');
                                const dictaminatorResponses = await response.json();
                                const formKeys = [
                                    'selectedResponseForm2', 'selectedResponseForm2_2', 'selectedResponseForm3_1',
                                    'selectedResponseForm3_2', 'selectedResponseForm3_3', 'selectedResponseForm3_4',
                                    'selectedResponseForm3_5', 'selectedResponseForm3_6', 'selectedResponseForm3_7',
                                    'selectedResponseForm3_8', 'selectedResponseForm3_9', 'selectedResponseForm3_10',
                                    'selectedResponseForm3_11', 'selectedResponseForm3_12', 'selectedResponseForm3_13',
                                    'selectedResponseForm3_14', 'selectedResponseForm3_15', 'selectedResponseForm3_16',
                                    'selectedResponseForm3_17', 'selectedResponseForm3_18', 'selectedResponseForm3_19'
                                ];
                                const selectedResponses = {};
                                const elements = {};

                                const suffixes = Array.from({ length: 19 }, (_, i) => i + 1); // Genera sufijos del 1 al 19

                                suffixes.forEach(i => {
                                    const dictKey = `form3_${i}`;
                                    const selectedKey = `dictForm3_${i}`;
                                    const elementKey = `comision3_${i}`;

                                    selectedResponses[selectedKey] = dictaminatorResponses[dictKey]?.find(res => res.email === email);
                                    elements[elementKey] = document.getElementById(elementKey);
                                });

                                suffixes.forEach(i => {
                                    const selectedKey = `dictForm3_${i}`;
                                    const elementKey = `comision3_${i}`;

                                    if (elements[elementKey]) {
                                        elements[elementKey].textContent = selectedResponses[selectedKey]?.[`comision3_${i}`] || '0';
                                    } else {
                                        console.warn(`Elemento con ID ${elementKey} no encontrado`);
                                    }
                                });
    

                                if (dictaminatorResponses) {
                                    // Actualizar los valores de los inputs
                                    document.querySelector('input[name="dictaminador_id"]').value = dictaminatorResponses.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = dictaminatorResponses.user_id || '';
                                    document.querySelector('input[name="email"]').value = dictaminatorResponses.email || '';
                                    document.querySelector('input[name="user_type"]').value = dictaminatorResponses.user_type || '';

                                    document.getElementById('comision1').textContent = selectedResponses.selectedResponseForm2?.comision1 || '0';
                                    document.getElementById('actv2Comision').textContent = selectedResponses.selectedResponseForm2_2?.actv2Comision || '0';
                                    document.getElementById('actv3Comision').textContent = selectedResponses.selectedResponseForm3_1?.actv3Comision || '0';

                            } else {
                                console.error('No form data found for the selected docente.');

                                // Reset input values if no data found
                                document.querySelector('input[name="dictaminador_id"]').value = '0';
                                document.querySelector('input[name="user_id"]').value = '0';
                                document.querySelector('input[name="email"]').value = '';
                                document.querySelector('input[name="user_type"]').value = '';



                            }
                            }  catch (error) {
                                console.error('Error fetching dictaminators responses:', error);
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error fetching docentes:', error);
                    alert('No se pudo cargar la lista de docentes.');
                }

               /* docenteSelect.addEventListener('change', async (event) => {
                    const dictaminadorId = event.target.value;
                    const email = event.target.options[event.target.selectedIndex].dataset.email;  // Get email from selected option

                    if (email) {
                        
                        try {

                            const response = await fetch(`/dictaminador-final-data?email=${email}`);
                            constdata = await response.json();

                        dataContainer.innerHTML = ''; // Limpiar datos anteriores
                            formContainer.style.display = 'block'; // Mostrar el formulario

                           
                            const comisiones = [
                            data['comision1'],       // Valor de 'comision1'
                            data['comision1'],       // Valor de 'comision1'
                            data['actv2Comision'],   // Valor de 'actv2Comision'
                            data['actv2Comision'],
                            data[''],    // Valor de 'actv2Comision'          // Total de las actividades 3 (cálculo)
                            data['actv3Comision'],   // Valor de 'actv3Comision'
                            data['comision3_2'],      // Valor de 'comision3_2'
                            data['comision3_3'],
                            data['comision3_4'],
                            data['comision3_5'],
                            data['comision3_6'],
                            data['comision3_7'],
                            data['comision3_8'],
                            data[''],
                            data[''],
                            data['comision3_9'],
                            data['comision3_10'],
                            data['comision3_11'],
                            data[''],
                            data[''],
                            data['comision3_12'],
                            data['comision3_13'],
                            data['comision3_14'],
                            data['comision3_15'],
                            data['comision3_16'],
                            data[''],
                            data[''],
                            data['comision3_17'],
                            data['comision3_18'],
                            data['comision3_19'],
                            data[''],
                            data[''], //31
                            data['comision1'], //32
                            data['actv2Comision'],
                            data[''],       
                            data[''],   //35                                                                                        

                            ];

                          // Generar las filas
                            let sumaComision3 = 0;
                            let comisionSubtotal1 = 0;
                            let comisionSubtotal2 = 0;
                            let comisionSubtotal3 = 0;
                            let comisionSubtotal4 = 0;
                            let totalLogrado = 0;

                            // Primero, calcular los subtotales
                            for (let i = 0; i < labels.length; i++) {
                                if (labels[i] === 'Subtotal ' || labels[i] === 'Subtotal') {
                                    // Sumar las comisiones del índice 5 al 12
                                    if (i === 13) {
                                        for (let index = 5; index <= 12; index++) {
                                            comisionSubtotal1 += parseInt(comisiones[index]) || 0; // Asegurarse de que comisiones[index] sea un número
                                        }
                                        sumaComision3 += comisionSubtotal1;
                                        comisiones[13] = comisionSubtotal1; // Asignar el subtotal calculado
                                    }

                                    // Sumar las comisiones del índice 15 al 17
                                    if (i === 18) {
                                        for (let index = 15; index <= 17; index++) {
                                            comisionSubtotal2 += parseInt(comisiones[index]) || 0; // Asegurarse de que comisiones[index] sea un número
                                        }
                                        sumaComision3 += comisionSubtotal2;
                                        comisiones[18] = comisionSubtotal2; // Asignar el subtotal calculado
                                    }

                                    // Sumar las comisiones del índice 20 al 24
                                    if (i === 25) {
                                        for (let index = 20; index <= 24; index++) {
                                            comisionSubtotal3 += parseInt(comisiones[index]) || 0; // Asegurarse de que comisiones[index] sea un número
                                        }
                                        sumaComision3 += comisionSubtotal3;
                                        comisiones[25] = comisionSubtotal3; // Asignar el subtotal calculado
                                    }

                                    // Sumar las comisiones del índice 27 al 29
                                    if (i === 30) {
                                        for (let index = 27; index <= 29; index++) {
                                            comisionSubtotal4 += parseInt(comisiones[index]) || 0; // Asegurarse de que comisiones[index] sea un número
                                        }
                                        sumaComision3 += comisionSubtotal4;
                                        comisiones[30] = comisionSubtotal4; // Asignar el subtotal calculado
                                    }
                                }
                            }

                            // Limitar sumaComision3 a 700 usando Math.min
                            sumaComision3 = Math.min(sumaComision3, 700);

                            // Asignar el valor de sumaComision3 al índice 4
                            comisiones[4] = sumaComision3;

                            // Calcular totalLogrado sumando comisiones[0], comisiones[2], y comisiones[4]
                            totalLogrado = (parseInt(comisiones[0]) || 0) + (parseInt(comisiones[2]) || 0) + (parseInt(comisiones[4]) || 0);

                            // Limitar totalLogrado a 700 usando Math.min
                            totalLogrado = Math.min(totalLogrado, 700);

                            // Asignar el valor de totalLogrado al índice 31
                            comisiones[31] = totalLogrado;
                            comisiones [34] = comisiones[4];
                            comisiones[35] = comisiones [31];

                            // Luego, generar las filas
                            for (let i = 0; i < labels.length; i++) {
                                const row = document.createElement('tr');
                                let labelCell = document.createElement('td');
                                let valueCell = document.createElement('td');
                                let comisionCell = document.createElement('td');

                                labelCell.textContent = labels[i];
                                valueCell.textContent = values[i];
                                comisionCell.textContent = comisiones[i];

                                // Aplicar estilos a los elementos específicos
                                if (['Subtotal ', 'Subtotal', 'Tutorias', 'Investigación', 'Cuerpos colegiados', 'Total logrado en la evaluación', 'Total de puntaje obtenido en la evaluación'].includes(labels[i])) {
                                    labelCell.style.fontWeight = 'bold';
                                    labelCell.style.textAlign = 'center';
                                }

                                // Excluir ciertos elementos de ser pintados
                                if (![0, 2, 4, 13, 14, 18, 19, 25, 26, 30, 31].includes(i)) {
                                    comisionCell.style.backgroundColor = '#f6c667';
                                }

                                if ([0, 2, 4, 13, 18, 25, 30, 31, 35].includes(i)) {
                                    comisionCell.style.fontWeight = 'bold';
                                }

                                if([35].includes(i)){
                                    comisionCell.style.backgroundColor = 'transparent';
                                }

                                row.appendChild(labelCell);
                                row.appendChild(valueCell);
                                row.appendChild(comisionCell);
                            dataContainer.appendChild(row);

                                // Asegurarse de que el valor de sumaComision3 se muestre en el índice 4
                                if (i === 4) {
                                    comisionCell.textContent = sumaComision3.toString();
                                }

                                // Asegurarse de que los subtotales se muestren en las celdas correspondientes
                                if (i === 13) {
                                    comisionCell.textContent = comisionSubtotal1.toString();
                                } else if (i === 18) {
                                    comisionCell.textContent = comisionSubtotal2.toString();
                                } else if (i === 25) {
                                    comisionCell.textContent = comisionSubtotal3.toString();
                                } else if (i === 30) {
                                    comisionCell.textContent = comisionSubtotal4.toString();
                                } else if (i === 31) {
                                    comisionCell.textContent = totalLogrado.toString();
                                }

                                comisionCell.style.textAlign = 'center';
                            }

                           
                           const minimaCalidad = evaluarCalidad(sumaComision3);
                           const  minimaTotal = evaluarTotal(totalLogrado);

                            document.getElementById('minimaCalidad').textContent = minimaCalidad;
                            document.getElementById('minimaTotal').textContent = minimaTotal;


                            //form5
                         if(userType === ''){
                             
                             const email = event.target.options[event.target.selectedIndex].dataset.email;
                            

                             axios.get('/get-evaluator-signature', {
                                 params: {
                                     email: email,

                                 }
                             })
                                 .then(function (response) {
                                     const evaluatorResponse = response.data;
                                     if (evaluatorResponse && evaluatorResponse.message !== 'Evaluator signature not found') {
                                         document.getElementById('personaEvaluadora1').innerText = evaluatorResponse.evaluator_name_1 || 'No evaluator name found';
                            

                                         document.getElementById('personaEvaluadora2').innerText = evaluatorResponse.evaluator_name_2 || 'No evaluator name found';
                        
                                         document.getElementById('personaEvaluadora3').innerText = evaluatorResponse.evaluator_name_3 || 'No evaluator name found';
                        


                                         // Mostrar las imágenes de las firmas
                                         const imgFirma1 = document.querySelector('img[data-firma="firma1"]');
                                         if (imgFirma1 && evaluatorResponse.signature_path_1) {
                                             imgFirma1.src = evaluatorResponse.signature_path_1;
                                             imgFirma1.style.display = 'block';
                                             imgFirma1.style.height = '100px';
                                         } else if (imgFirma1) {
                                             imgFirma1.style.display = 'none';
                                         }

                                         const imgFirma2 = document.querySelector('img[data-firma="firma2"]');
                                         if (imgFirma2 && evaluatorResponse.signature_path_2) {
                                             imgFirma2.src = evaluatorResponse.signature_path_2;
                                             imgFirma2.style.display = 'block';
                                             imgFirma2.style.height = '100px';
                                         } else if (imgFirma2) {
                                             imgFirma2.style.display = 'none';
                                         }

                                         const imgFirma3 = document.querySelector('img[data-firma="firma3"]');
                                         if (imgFirma3 && evaluatorResponse.signature_path_3) {
                                             imgFirma3.src = evaluatorResponse.signature_path_3;
                                             imgFirma3.style.display = 'block';
                                             imgFirma3.style.height = '100px';
                                         } else if (imgFirma3) {
                                             imgFirma3.style.display = 'none';

                                             document.getElementById('signature_path_1').src = '/storage/' + (evaluatorResponse.signature_path_1 || 'default.png');
                                             document.getElementById('signature_path_2').src = '/storage/' + (evaluatorResponse.signature_path_2 || 'default.png');
                                             document.getElementById('signature_path_3').src = '/storage/' + (evaluatorResponse.signature_path_3 || 'default.png');
                                         }
                                     } else {
                                         console.error('Evaluator signature not found');
                                     }
                                 })
                                 .catch(function (error) {
                                     console.error('Error:', error);
                                 });

                                 
                             async function fetchConvocatoria(dictaminadorId) {
                                 try {
                                     const response = await axios.get(`/fetch-convocatoria/${dictaminadorId}`, {
                                         headers: {
                                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                             'Content-Type': 'application/json',
                                         }
                                     });

                                     console.log('Response:', response); // Verificar la respuesta
                                     console.log('Data:', response.data); // Verificar los datos
                                     document.getElementById('convocatoria').textContent = response.data.convocatoria;

                                     return response.data.convocatoria;

                                 } catch (error) {
                                     console.error('There was a problem fetching the convocatoria:', error.message);
                                 }
                             }


                             fetchConvocatoria(dictaminadorId);
                                }


                        else if(userType === 'dictaminador'){
                             async function submitForm(url, formId) {
                                 const form = document.getElementById(formId);
                                 if (!form) {
                                     console.error(`Form with id "${formId}" not found.`);
                                     return;
                                 }

                                 if (formId === 'form4') {
                                     letdataValues = getCommodataValues(form);
                                    dataValues['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
                                     // Obtener valores de los labels y spans
                                    dataValues['comision_actividad_1_total'] = document.getElementById('totalComision1').textContent;
                                    dataValues['comision_actividad_2_total'] = document.getElementById('totalComision2').textContent;
                                    dataValues['comision_actividad_3_total'] = document.getElementById('totalComision3').textContent;
                                    dataValues['total_puntaje'] = document.getElementById('totalComisionRepetido').textContent;
                                    dataValues['minima_total'] = document.getElementById('minimaTotal').textContent;
                                    dataValues['minima_calidad'] = document.getElementById('minimaCalidad').textContent;

                                     // Log form data to check values
                                     console.log('Form data for form4: ',dataValues);

                                     try {
                                         const response = await fetch(url, {
                                             method: 'POST',
                                             headers: {
                                                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                 'Content-Type': 'application/json',
                                             },
                                             body: JSON.stringifydataValues),
                                         });

                                         if (!response.ok) {
                                             throw new Error('Network response was not ok');
                                         }

                                         const responseData = await response.json();
                                         console.log('Response received from server:', responseData);
                                     } catch (error) {
                                         console.error('There was a problem with the fetch operation:', error);
                                     }
                                 } else if (formId === 'form5') {
                                     letdataValues = newdata(form);
                                     document.getElementById('reportLink').classList.remove('d-none');

                                     // Agregar los campos comunes
                                     let commonData = getCommodataValues(form);
                                     for (let key in commonData) {
                                        dataValues.append(key, commonData[key]);
                                     }


                                     // evaluator names
                                    dataValues.set('evaluator_name_1', form.querySelector('#personaEvaluadora1').value);
                                    dataValues.set('evaluator_name_2', form.querySelector('#personaEvaluadora2').value);
                                    dataValues.set('evaluator_name_3', form.querySelector('#personaEvaluadora3').value);

                                     // Add files todataValues
                                     ['firma1', 'firma2', 'firma3'].forEach((firma) => {
                                         let fileInput = form.querySelector(`#${firma}`);
                                         if (fileInput.files.length > 0) {
                                            dataValues.append(firma, fileInput.files[0]);
                                         }
                                     });

                                     try {
                                         let response = await fetch(url, {
                                             method: 'POST',
                                             headers: {
                                                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                             },
                                             body:dataValues,
                                         });

                                         if (!response.ok) {
                                             throw new Error('Network response was not ok');
                                         }

                                         const contentType = response.headers.get('Content-Type');
                                         if (!contentType || !contentType.includes('application/json')) {
                                             throw new Error('Invalid JSON response');
                                         }

                                         let data = await response.json();
                                         console.log('Response received from server:', data);


                                         // Mostrar todas las firmas
                                         if (data.signature_urls) { // Verifica que existan las URLs de las firmas
                                             const firmas = ['firma1', 'firma2', 'firma3']; // Define tus firmas

                                             firmas.forEach(firma => {
                                                 const img = document.querySelector(`img[data-firma="${firma}"]`); // Selecciona la imagen correspondiente
                                                 if (data.signature_urls[firma]) {
                                                     img.src = data.signature_urls[firma]; // Establece la URL de la firma
                                                     img.style.display = 'block'; // Muestra la imagen
                                                     img.style.maxWidth = '200px'; // Ajusta a 100px
                                                     img.style.height = '100px'; // Mantiene proporción
                                                 } else {
                                                     img.style.display = 'none'; // Oculta la imagen si no hay firma
                                                 }
                                             });
                                         }
                                     } catch (error) {
                                         console.error('There was a problem with the fetch operation:', error);
                                     }
                                 }

                             }
                             window.submitForm = submitForm; 
                        }
                        } catch (error) {
                            console.error('Error fetching data:', error);
                        }
                        
                    } else {
                        formContainer.style.display = 'none'; // Ocultar el formulario si no hay selección
                    }
                    //await fetchConvocatoria(dictaminadorId);
                });
            } 
        }
    }); */

    
document.addEventListener('DOMContentLoaded', async () => {
    const userType = @json($userType); 
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const user_identity = @json($user_identity);
    const docenteSelect = document.getElementById('docenteSelect');
    const dictaminadorSelect = document.getElementById('dictaminadorSelect');
    const formContainer = document.getElementById('formContainer');
    const dataContainer = document.getElementById('data');

    if (docenteSelect) {
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
                    // Mantenemos la solicitud a /get-docente-data para obtener los datos del docente
                    axios.get('/get-docente-data', { params: { email } })
                        .then(async response => {
                            const data = response.data;

                            formContainer.style.display = 'block'; // Mostrar formulario

                            // Aquí realizamos la solicitud para obtener las comisiones de los dictaminadores
                            try {
                                const userIdResponse = await fetch(`/get-user-id?email=${email}`);
                                const userIdData = await userIdResponse.json();
                                
                                if (userIdData.user_id) {
                                const userId = userIdData.user_id;
                                    
                                const dictaminatorResponse = await fetch(`/get-dictaminators-responses?user_id=${userId}`);
                                const dictaminatorData = await dictaminatorResponse.json();

                                // Inicializar comisiones con valores predeterminados
                                const comisiones = Array(35).fill('');

                                // Sobrescribir las comisiones obtenidas del dictaminador
                                comisiones[0] = dictaminatorData.form2?.comision1 || '0'; 
                                comisiones[1] = dictaminatorData.form2?.comision1 || '0'; 
                                comisiones[2] = dictaminatorData.form2_2?.actv2Comision || '0';
                                comisiones[3] = dictaminatorData.form2_2?.actv2Comision || '0';
                                comisiones[5] = dictaminatorData.form3_1?.actv3Comision || '0';
                                comisiones[6] = dictaminatorData.form3_2?.comision3_2 || '0';
                                comisiones[7] = dictaminatorData.form3_3?.comision3_3 || '0';
                                comisiones[8] = dictaminatorData.form3_4?.comision3_4 || '0';
                                comisiones[9] = dictaminatorData.form3_5?.comision3_5 || '0';
                                comisiones[10] = dictaminatorData.form3_6?.comision3_6 || '0';
                                comisiones[11] = dictaminatorData.form3_7?.comision3_7 || '0';
                                comisiones[12] = dictaminatorData.form3_8?.comision3_8 || '0';
                                comisiones[15] = dictaminatorData.form3_9?.comision3_9 || '0';
                                comisiones[16] = dictaminatorData.form3_10?.comision3_10 || '0';
                                comisiones[17] = dictaminatorData.form3_11?.comision3_11 || '0';
                                comisiones[20] = dictaminatorData.form3_12?.comision3_12 || '0';
                                comisiones[21] = dictaminatorData.form3_13?.comision3_13 || '0';
                                comisiones[22] = dictaminatorData.form3_14?.comision3_14 || '0';
                                comisiones[23] = dictaminatorData.form3_15?.comision3_15 || '0';
                                comisiones[24] = dictaminatorData.form3_16?.comision3_16 || '0';
                                comisiones[27] = dictaminatorData.form3_17?.comision3_17 || '0';
                                comisiones[28] = dictaminatorData.form3_18?.comision3_18 || '0';
                                comisiones[29] = dictaminatorData.form3_19?.comision3_19 || '0';
                                comisiones[32] = dictaminatorData.form2?.comision1 || '0'; 
                                comisiones[33] = dictaminatorData.form2_2?.actv2Comision || '0';

                                // **Realizar los cálculos de los subtotales y totales** después de obtener los datos
                                let sumaComision3 = 0;
                                let comisionSubtotal1 = 0;
                                let comisionSubtotal2 = 0;
                                let comisionSubtotal3 = 0;
                                let comisionSubtotal4 = 0;
                                let totalLogrado = 0;

                                // Calcular los subtotales
                                for (let i = 0; i < labels.length; i++) {
                                    if (labels[i] === 'Subtotal ' || labels[i] === 'Subtotal') {
                                        if (i === 13) { // Subtotal 1
                                            for (let index = 5; index <= 12; index++) {
                                                comisionSubtotal1 += parseInt(comisiones[index]) || 0;
                                            }
                                            sumaComision3 += comisionSubtotal1;
                                            comisiones[13] = comisionSubtotal1; // Asignar el subtotal calculado
                                        }
                                        if (i === 18) { // Subtotal 2
                                            for (let index = 15; index <= 17; index++) {
                                                comisionSubtotal2 += parseInt(comisiones[index]) || 0;
                                            }
                                            sumaComision3 += comisionSubtotal2;
                                            comisiones[18] = comisionSubtotal2;
                                        }
                                        if (i === 25) { // Subtotal 3
                                            for (let index = 20; index <= 24; index++) {
                                                comisionSubtotal3 += parseInt(comisiones[index]) || 0;
                                            }
                                            sumaComision3 += comisionSubtotal3;
                                            comisiones[25] = comisionSubtotal3;
                                        }
                                        if (i === 30) { // Subtotal 4
                                            for (let index = 27; index <= 29; index++) {
                                                comisionSubtotal4 += parseInt(comisiones[index]) || 0;
                                            }
                                            sumaComision3 += comisionSubtotal4;
                                            comisiones[30] = comisionSubtotal4;
                                        }
                                    }
                                }

                                sumaComision3 = Math.min(sumaComision3, 700);
                                comisiones[4] = sumaComision3;

                                totalLogrado = (parseInt(comisiones[0]) || 0) + (parseInt(comisiones[2]) || 0) + (parseInt(comisiones[4]) || 0);
                                totalLogrado = Math.min(totalLogrado, 700);
                                comisiones[31] = totalLogrado;
                                comisiones[34] = comisiones[4];
                                comisiones[35] = comisiones[31];

                                let comisionCell;

                                // **Generar las filas con los estilos y cálculos**
                                for (let i = 0; i < labels.length; i++) {
                                    const row = document.createElement('tr');
                                    let labelCell = document.createElement('td');
                                    let valueCell = document.createElement('td');
                                    comisionCell = document.createElement('td');

                                    labelCell.textContent = labels[i];
                                    valueCell.textContent = values[i];
                                    comisionCell.textContent = comisiones[i] || '';

                                    // Aplicar estilos
                                    if (['Subtotal ', 'Subtotal', 'Tutorias', 'Investigación', 'Cuerpos colegiados', 'Total logrado en la evaluación', 'Total de puntaje obtenido en la evaluación'].includes(labels[i])) {
                                        labelCell.style.fontWeight = 'bold';
                                        labelCell.style.textAlign = 'center';
                                    }

                                    if (![0, 2, 4, 13, 14, 18, 19, 25, 26, 30, 31].includes(i)) {
                                        comisionCell.style.backgroundColor = '#f6c667';
                                        comisionCell[i] = comisiones[i].toString();
                                    }

                                    if ([0, 2, 4, 13, 18, 25, 30, 31, 35].includes(i)) {
                                        comisionCell.style.fontWeight = 'bold';
                                        comisionCell[i] = comisiones[i].toString();
                                    }

                                    if ([35].includes(i)) {
                                        comisionCell.style.backgroundColor = 'transparent';
                                    }

                                    // Insertar los valores calculados
                                    if (i === 4) comisionCell.textContent = sumaComision3.toString();
                                    if (i === 13) comisionCell.textContent = comisionSubtotal1.toString();
                                    if (i === 18) comisionCell.textContent = comisionSubtotal2.toString();
                                    if (i === 25) comisionCell.textContent = comisionSubtotal3.toString();
                                    if (i === 30) comisionCell.textContent = comisionSubtotal4.toString();
                                    if (i === 31) comisionCell.textContent = totalLogrado.toString();

                                     comisionCell.style.textAlign = 'center';
                                    row.appendChild(labelCell);
                                    row.appendChild(valueCell);
                                    row.appendChild(comisionCell);
                                    dataContainer.appendChild(row);

                                    
                                }

                                

                                console.log(comisiones[0].toString());

                                // Asignar los valores calculados a otros elementos del DOM
                                const minimaCalidad = evaluarCalidad(sumaComision3);
                                const minimaTotal = evaluarTotal(totalLogrado);
                                document.getElementById('minimaCalidad').textContent = minimaCalidad;
                                document.getElementById('minimaTotal').textContent = minimaTotal;



                                             // Actualizar convocatoria
                                                const convocatoriaElement = document.getElementById('convocatoria');
                                                if (convocatoriaElement) {
                                                    if (data.form1) {
                                                        convocatoriaElement.textContent = data.form1.convocatoria || '';
                                                    } else {
                                                        console.error('form1 no está definido en la respuesta.');
                                                    }
                                                } else {
                                                    console.error('Elemento con ID "convocatoria" no encontrado.');
                              
                                                }
                                        } else {
                                    console.error('No se pudo encontrar el user_id para el email seleccionado.');
                                }
                            } catch (error) {
                                console.error('Error fetching dictaminators responses:', error);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching docente data:', error);
                        });
                }
            });
        } catch (error) {
            console.error('Error fetching docentes:', error);
            alert('No se pudo cargar la lista de docentes.');
        }
    }
});

    async function fetchData(url, params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const fullUrl = `${url}?${queryString}`;

        try {
            const response = await axios.get(fullUrl, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            });

            console.log('Response:', response); // Verificar la respuesta
            console.log('Data:', response.data); // Verificar los datos
            return response.data;
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error.message);
        }
    }

    async function loadSignatures() {
            let data = await fetchData('/get-evaluator-signature', {
                user_id: userId,
                email: email,
                user_type: userType
            });

            if (data) {
                // Si las URLs de las firmas están disponibles, las mostramos
                console.log('Datos de firma recibidos:', data);

                // Verificar si los elementos imgFirma existen antes de asignarles src
                let imgFirma1 = document.getElementById('imgFirma1');
                let imgFirma2 = document.getElementById('imgFirma2');
                let imgFirma3 = document.getElementById('imgFirma3');

                if (data.signature_path_1 && imgFirma1) {
                    imgFirma1.src = data.signature_path_1;
                    imgFirma1.style.display = 'block';
                }
                if (data.signature_path_2 && imgFirma2) {
                    imgFirma2.src = data.signature_path_2;
                    imgFirma2.style.display = 'block';
                }
                if (data.signature_path_3 && imgFirma3) {
                    imgFirma3.src = data.signature_path_3;
                    imgFirma3.style.display = 'block';
                }
            } else {
                console.error('Error: Signature data not found.');
            }

        }

    function getCommodataValues(form) {
            constdata = {};

        data['user_id'] = form.querySelector('input[name="user_id"]').value;
        data['email'] = form.querySelector('input[name="email"]').value;
        data['user_type'] = form.querySelector('input[name="user_type"]').value;
            console.log('user_type value: ',data['user_type']);
            returndata;
        }
           
   async function saveConsolidatedData(data) {
                    try {
                        const response = await fetch('/consolidate-responses', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        });

                        if (!response.ok) {
                            throw new Error('Error al guardar los datos consolidados');
                        }

                        const result = await response.json();
                        console.log('Datos consolidados guardados exitosamente:', result);
                    } catch (error) {
                        console.error('Hubo un problema al guardar los datos:', error);
                    }
                }
                // Después de calcular los subtotales y totales
                const consolidatedData = {
                    user_id: userId,
                    comision1: comisiones[0],
                    actv2Comision: comisiones[2],
                    actv3Comision: sumaComision3,
                    totalLogrado: totalLogrado,
                    // Agrega otros campos necesarios
                };

                await saveConsolidatedData(consolidatedData);
     
    </script>


</body>

</html>