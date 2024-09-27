@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Registro de patentes y productos de investigación tecnológica y educativa</title>
    <meta charset="utf-9">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-head-resources />
</head>

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
                                    <a class="nav-link disabled" href="#">
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
                                <a class="nav-link active" style="width: 200px;" href="{{ route('rules') }}">Artículo 10
                                    REGLAMENTO
                                    PEDPD</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser
                                    llenado
                                    por la
                                    Comisión del PEDPD)</a>
                            </li><br>
                            <li id="jsonDataLink" class="d-none">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de
                                    los
                                    Usuarios</a>
                            </li>
                            <li id="reportLink" class="nav-item d-none">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                    Reporte</a>
                            </li>
                            <li class="nav-item">
                                @if(Auth::user()->user_type === 'dictaminador')
                                    <a class="nav-link active" style="width: 200px;"
                                        href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                                @else
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('secretaria') }}">Selección de
                                        Formatos</a>
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
$userType = Auth::user()->user_type;
    @endphp
    <div class="container mt-4 printButtonClass">
        @if($userType == 'dictaminador')
            <!-- Select para dictaminador seleccionando docentes -->
            <label for="docenteSelect">Seleccionar Docente:</label>
            <select id="docenteSelect" class="form-select">
                <option value="">Seleccionar un docente</option>
                <!-- Aquí se llenarán los docentes con JavaScript -->
            </select>
        @elseif($userType == '')
            <!-- Select para usuario con user_type vacío seleccionando dictaminadores -->
            <label for="dictaminadorSelect">Seleccionar Dictaminador:</label>
            <select id="dictaminadorSelect" class="form-select">
                <option value="">Seleccionar un dictaminador</option>
                <!-- Aquí se llenarán los dictaminadores con JavaScript -->
            </select>
        @else
            <!-- Select por defecto para otros usuarios seleccionando docentes -->
            <label for="docenteSelect">Seleccionar Docente:</label>
            <select id="docenteSelect" class="form-select">
                <option value="">Seleccionar un docente</option>
                <!-- Aquí se llenarán los docentes con JavaScript -->
            </select>
        @endif
    </div>

    <main class="container">
        <!-- Form for Part 3_1 -->
        <form id="form3_16" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form316', 'form3_16');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
        <!--3.16 Actividades de arbitraje, revisión, correción y edición -->
            <h4>Puntaje máximo
                <label class="bg-black text-white px-4 mt-3" for="">30</label>
            </h4>
            <table class="table table-sm tutorias">
                <thead>
                    <tr>
                        <th>
                            <h3></h3>
                        </th>
                        <th>
                            <h3></h3>
                        </th>
                        <th>
                            <h3>Investigación</h3>
                        </th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th scope="col" colspan=3>Actividad</th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                        <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th id="seccion3_16" class="acreditacion" colspan=7> 3.16 Actividades de arbitraje,
                            revisión,
                            correción y edición
                        </th>
                        <th id="score3_16">0</th>
                        <th id="comision3_16">0</th>
                        <th class="acreditacion" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th class="acreditacion">Incisos</th>
                        <th class="acreditacion">Actividad</th>
                        <th class="acreditacion">Nivel</th>
                        <th class="acreditacion">Puntaje</th>
                        <th class="acreditacion">Cantidad</th>
                        <th></th>
                        <th></th>
                        <th class="acreditacion">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>a)</td>
                        <td>Arbitraje a proyectos de investigación</td>
                        <td>Internacional</td>
                        <td id="puntajeArbInt"><b>30</b></td>
                        <td id="cantArbInt"></td>
                        <td></td>
                        <td></td>
                        <td id="subtotalArbInt"></td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input type="number" id="comisionArbInt" value="{{ oldValueOrDefault('comisionArbInt') }}"
                                oninput="onActv3Comision3_16()">
                        @else
                            <span id="comisionArbInt"></span>
                        @endif
                        </td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsArbInt">
                        @else
                            <span id="obsArbInt"></span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>b)</td>
                        <td>Arbitraje a proyectos de investigación</td>
                        <td>Nacional</td>
                        <td id="puntajeArbINac"><b>25</b></td>
                        <td id="cantArbNac"></td>
                        <td></td>
                        <td></td>
                        <td id="subtotalArbNac"></td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input type="number" id="comisionArbNac" value="{{ oldValueOrDefault('comisionArbNac') }}"
                                oninput="onActv3Comision3_16()">
                        @else
                            <span id="comisionArbNac"></span>
                        @endif
                        
                        </td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsArbNac">
                        @else
                            <span id="obsArbNac"></span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>c)</td>
                        <td>Arbitraje de publicaciones</td>
                        <td>Internacional</td>
                        <td id="puntajePubInt"><b>20</b></td>
                        <td id="cantPubInt"></td>
                        <td></td>
                        <td></td>
                        <td id="subtotalPubInt"></td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input type="number" id="comisionPubInt" value="{{ oldValueOrDefault('comisionPubInt') }}"
                                oninput="onActv3Comision3_16()"></td>
                        @else
                        <span id="comisionPubInt"></span>

                        @endif
                        <td>
                        @if($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsPubInt">
                        @else

                        <span id="obsPubInt"></span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>d)</td>
                        <td>Arbitraje de publicaciones</td>
                        <td>Nacional</td>
                        <td id="puntajePubINac"><b>10</b></td>
                        <td id="cantPubNac"></td>
                        <td></td>
                        <td></td>
                        <td id="subtotalPubNac"></td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input type="number" id="comisionPubNac" value="{{ oldValueOrDefault('comisionPubNac') }}"
                                oninput="onActv3Comision3_16()">
                        @else
                            <span id="comisionPubNac"></span>
                        @endif
                        </td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsPubNac">
                        @else
                            <span id="obsPubNac"></span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>e)</td>
                        <td>Revisor(a) de libros, corrector(a)</td>
                        <td>Internacional</td>
                        <td id="puntajeRevInt"><b>30</b></td>
                        <td id="cantRevInt"></td>
                        <td></td>
                        <td></td>
                        <td id="subtotalRevInt"></td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input type="number" id="comisionRevInt" value="{{ oldValueOrDefault('comisionRevInt') }}"
                                oninput="onActv3Comision3_16()"></td>
                        @else
                            <span id="comisionRevInt"> </span>
                        @endif
                        <td>
                        @if($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsRevInt">
                        @else
                            <span id="obsRevInt"> </span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>f)</td>
                        <td>Revisor(a) de libros, corrector(a)</td>
                        <td>Nacional</td>
                        <td id="puntajeRevINac"><b>25</b></td>
                        <td id="cantRevNac"></td>
                        <td></td>
                        <td></td>
                        <td id="subtotalRevNac"></td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input type="number" id="comisionRevNac" value="{{ oldValueOrDefault('comisionRevNac') }}"
                                oninput="onActv3Comision3_16()"></td>
                        @else
                            <span id="comisionRevNac"> </span>
                        @endif
                        <td>
                        @if($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsRevNac">
                        @else
                            <span id="obsRevNac"> </span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>g)</td>
                        <td>Consejo editorial de revista, edición de revista</td>
                        <td>----</td>
                        <td id="puntajeRevista"><b>10</b></td>
                        <td id="cantRevista"></td>
                        <td></td>
                        <td></td>
                        <td id="subtotalRevista"></td>
                        <td>
                        @if($userType == 'dictaminador')
                            <input type="number" id="comisionRevista" value="{{ oldValueOrDefault('comisionRevista') }}"
                                oninput="onActv3Comision3_16()"></td>
                        @else
                            <span id="comisionRevista"> </span>
                        @endif
                        <td>
                        @if($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsRevista">
                        @else
                            <span id="obsRevista"> </span>
                        @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--Tabla informativa Acreditacion Actividad 3.16-->
            <table>
                <thead>
                    <tr>
                        <th class="acreditacion" scope="col">Acreditacion: </th>

                        <th class="descripcion"><b>Institución que lo solicita. En el caso de la UABCS,
                                DIIP, SG, CA,
                                JD.</b>
                        </th>
                        <th>
                            @if($userType != '')
                            <button id="btn3_16" type="submit" class="btn custom-btn printButtonClass">Enviar</button>
                            @endif   
                        </th>
                    </tr>
                </thead>
            </table> 
            </form>
    </main>
    <center>
        <footer id="convocatoria">
            <!-- Mostrar convocatoria -->
            @if(isset($convocatoria))

                <div style="margin-right: -700px;">
                    <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
                </div>
            @endif
        </footer>
    </center>
    <script>

        document.addEventListener('DOMContentLoaded', async () => {
            const docenteSelect = document.getElementById('docenteSelect');
            const dictaminadorSelect = document.getElementById('dictaminadorSelect');

            // Current user type from the backend
            const userType = @json($userType);  // Get user type from backend

            // Fetch docente options if user is a dictaminador
            if (docenteSelect && userType === 'dictaminador') {
                try {
                    const response = await fetch('/get-docentes');
                    const docentes = await response.json();

                    docentes.forEach(docente => {
                        const option = document.createElement('option');
                        option.value = docente.email;
                        option.textContent = docente.email;
                        docenteSelect.appendChild(option);
                    });

                    // Handle docente selection change
                    docenteSelect.addEventListener('change', async (event) => {
                        const email = event.target.value;
                        if (email) {
                            try {
                                const response = await axios.get('/get-docente-data', { params: { email } });
                                const data = response.data;

                                // Populate fields with fetched data
                                document.getElementById('score3_16').textContent = data.form3_16.score3_16 || '0';

                                // Cantidades
                                document.getElementById('cantArbInt').textContent = data.form3_16.cantArbInt || '0';
                                document.getElementById('cantArbNac').textContent = data.form3_16.cantArbNac || '0';
                                document.getElementById('cantPubInt').textContent = data.form3_16.cantPubInt || '0';
                                document.getElementById('cantPubNac').textContent = data.form3_16.cantPubNac || '0';
                                document.getElementById('cantRevInt').textContent = data.form3_16.cantRevInt || '0';
                                document.getElementById('cantRevNac').textContent = data.form3_16.cantRevNac || '0';
                                document.getElementById('cantRevista').textContent = data.form3_16.cantRevista || '0';

                                // Subtotales
                                document.getElementById('subtotalArbInt').textContent = data.form3_16.subtotalArbInt || '0';
                                document.getElementById('subtotalArbNac').textContent = data.form3_16.subtotalArbNac || '0';
                                document.getElementById('subtotalPubInt').textContent = data.form3_16.subtotalPubInt || '0';
                                document.getElementById('subtotalPubNac').textContent = data.form3_16.subtotalPubNac || '0';
                                document.getElementById('subtotalRevInt').textContent = data.form3_16.subtotalRevInt || '0';
                                document.getElementById('subtotalRevNac').textContent = data.form3_16.subtotalRevNac || '0';     
                                document.getElementById('subtotalRevista').textContent = data.form3_16.subtotalRevista || '0';                               

                                //  hidden inputs
                                document.querySelector('input[name="user_id"]').value = data.form3_16.user_id || '';
                                document.querySelector('input[name="email"]').value = data.form3_16.email || '';
                                document.querySelector('input[name="user_type"]').value = data.form3_16.user_type || '';

                                    // Verificar si el elemento existe antes de establecer su contenido
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

                            } catch (error) {
                                console.error('Error fetching docente data:', error);
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error fetching docentes:', error);
                    alert('No se pudo cargar la lista de docentes.');
                }
            }

            // Fetch dictaminador options if user type is null or empty
            if (dictaminadorSelect && userType === '') {
                try {
                    const response = await fetch('/get-dictaminadores');
                    const dictaminadores = await response.json();

                    dictaminadores.forEach(dictaminador => {
                        const option = document.createElement('option');
                        option.value = dictaminador.id;  // Use dictaminador ID as value
                        option.dataset.email = dictaminador.email; // Store email in data attribute
                        option.textContent = dictaminador.email;
                        dictaminadorSelect.appendChild(option);
                    });

                    // Handle dictaminador selection change
                    dictaminadorSelect.addEventListener('change', async (event) => {
                        const dictaminadorId = event.target.value;
                        const email = event.target.options[event.target.selectedIndex].dataset.email;  // Get email from selected option

                        if (dictaminadorId) {
                            try {
                                const response = await axios.get('/get-dictaminador-data', {
                                    params: { email: email, dictaminador_id: dictaminadorId }  // Send both ID and email
                                });
                                const data = response.data;

                                // Populate fields based on fetched data
                                if (data.form3_16) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';
                                    document.getElementById('score3_16').textContent = data.form3_16.score3_16 || '0';
                                    document.getElementById('comision3_16').textContent = data.form3_16.comision3_16 || '0';

                                    // Cantidades
                                    document.getElementById('cantArbInt').textContent = data.form3_16.cantArbInt || '0';
                                    document.getElementById('cantArbNac').textContent = data.form3_16.cantArbNac || '0';
                                    document.getElementById('cantPubInt').textContent = data.form3_16.cantPubInt || '0';
                                    document.getElementById('cantPubNac').textContent = data.form3_16.cantPubNac || '0';
                                    document.getElementById('cantRevInt').textContent = data.form3_16.cantRevInt || '0';
                                    document.getElementById('cantRevNac').textContent = data.form3_16.cantRevNac || '0';
                                    document.getElementById('cantRevista').textContent = data.form3_16.cantRevista || '0';


                                    // Subtotales
                                    document.getElementById('subtotalArbInt').textContent = data.form3_16.subtotalArbInt || '0';
                                    document.getElementById('subtotalArbNac').textContent = data.form3_16.subtotalArbNac || '0';
                                    document.getElementById('subtotalPubInt').textContent = data.form3_16.subtotalPubInt || '0';
                                    document.getElementById('subtotalPubNac').textContent = data.form3_16.subtotalPubNac || '0';
                                    document.getElementById('subtotalRevInt').textContent = data.form3_16.subtotalRevInt || '0';
                                    document.getElementById('subtotalRevNac').textContent = data.form3_16.subtotalRevNac || '0';     
                                    document.getElementById('subtotalRevista').textContent = data.form3_16.subtotalRevista || '0';                                         

                                    // Comisiones
                                    document.querySelector('#comisionArbInt').textContent = data.form3_16.comisionArbInt || '0';
                                    document.querySelector('#comisionArbNac').textContent = data.form3_16.comisionArbNac || '0';
                                    document.querySelector('#comisionPubInt').textContent = data.form3_16.comisionPubInt || '0';
                                    document.querySelector('#comisionPubNac').textContent = data.form3_16.comisionPubNac || '0';
                                    document.querySelector('#comisionRevInt').textContent = data.form3_16.comisionRevInt || '0';
                                    document.querySelector('#comisionRevNac').textContent = data.form3_16.comisionRevNac || '0';
                                    document.querySelector('#comisionRevista').textContent = data.form3_16.comisionRevista || '0';                                    
                                    // Observaciones
                                    document.querySelector('#obsArbInt').textContent = data.form3_16.obsArbInt || '';
                                    document.querySelector('#obsArbNac').textContent = data.form3_16.obsArbNac || '';
                                    document.querySelector('#obsPubInt').textContent = data.form3_16.obsPubInt || '';
                                    document.querySelector('#obsPubNac').textContent = data.form3_16.obsPubNac || '';
                                    document.querySelector('#obsRevInt').textContent = data.form3_16.obsRevInt || '';
                                    document.querySelector('#obsRevNac').textContent = data.form3_16.obsRevNac || '';
                                    document.querySelector('#obsRevista').textContent = data.form3_16.obsRevista || '';

                                    // Verificar si el elemento existe antes de establecer su contenido
                                    const convocatoriaElement = document.getElementById('convocatoria');
                                    if (convocatoriaElement) {
                                        if (data.responseForm1) {
                                            convocatoriaElement.textContent = data.responseForm1.convocatoria || '';
                                        } else {
                                            console.error('form1 no está definido en la respuesta.');
                                        }
                                    } else {
                                        console.error('Elemento con ID "convocatoria" no encontrado.');
                                    }
                                    
                                } else {
                                    console.error('No form3_16 data found for the selected dictaminador.');

                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('score3_16').textContent = '0';

                                    // Cantidades
                                    document.getElementById('cantArbInt').textContent = '0';
                                    document.getElementById('cantArbNac').textContent = '0';
                                    document.getElementById('cantPubInt').textContent = '0';
                                    document.getElementById('cantPubNac').textContent = '0';
                                    document.getElementById('cantRevInt').textContent = '0';
                                    document.getElementById('cantRevNac').textContent = '0';
                                    document.getElementById('cantRevista').textContent = '0';

                                    // Subtotales
                                    document.getElementById('subtotalArbInt').textContent = '0';
                                    document.getElementById('subtotalArbNac').textContent = '0';
                                    document.getElementById('subtotalPubInt').textContent = '0';
                                    document.getElementById('subtotalPubNac').textContent = '0';
                                    document.getElementById('subtotalRevInt').textContent = '0';
                                    document.getElementById('subtotalRevNac').textContent = '0';
                                    document.getElementById('subtotalRevista').textContent = '0';

                                    // Comisiones
                                    document.querySelector('#comisionArbInt').textContent = '0';
                                    document.querySelector('#comisionArbNac').textContent = '0';
                                    document.querySelector('#comisionPubInt').textContent = '0';
                                    document.querySelector('#comisionPubNac').textContent = '0';
                                    document.querySelector('#comisionRevInt').textContent = '0';
                                    document.querySelector('#comisionRevNac').textContent = '0';
                                    document.querySelector('#comisionRevista').textContent = '0';


                                    // Observaciones
                                    document.querySelector('#obsArbInt').textContent = '';
                                    document.querySelector('#obsArbNac').textContent = '';
                                    document.querySelector('#obsPubInt').textContent = '';
                                    document.querySelector('#obsPubNac').textContent = '';
                                    document.querySelector('#obsRevInt').textContent = '';
                                    document.querySelector('#obsRevNac').textContent = '';
                                    document.querySelector('#obsRevista').textContent = '';

                                    document.getElementById('comision3_16').textContent = '0';
                                }
                            } catch (error) {
                                console.error('Error fetching dictaminador data:', error);
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error fetching dictaminadores:', error);
                    alert('No se pudo cargar la lista de dictaminadores.');
                }
            }
        });

        // Function to handle form submission
        async function submitForm(url, formId) {
            const formData = {};
            const form = document.getElementById(formId);

            if (!form) {
                console.error(`Form with id "${formId}" not found.`);
                return;
            }

            formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
            formData['user_id'] = form.querySelector('input[name="user_id"]').value;
            formData['email'] = form.querySelector('input[name="email"]').value;
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;

            // Cantidades
            formData['cantArbInt'] = form.querySelector('td[id="cantArbInt"]').textContent;
            formData['cantArbNac'] = form.querySelector('td[id="cantArbNac"]').textContent;
            formData['cantPubInt'] = form.querySelector('td[id="cantPubInt"]').textContent;
            formData['cantPubNac'] = form.querySelector('td[id="cantPubNac"]').textContent;
            formData['cantRevInt'] = form.querySelector('td[id="cantRevInt"]').textContent;
            formData['cantRevNac'] = form.querySelector('td[id="cantRevNac"]').textContent;
            formData['cantRevista'] = form.querySelector('td[id="cantRevista"]').textContent;


            // Subtotales
            formData['subtotalArbInt'] = document.getElementById('subtotalArbInt').textContent;
            formData['subtotalArbNac'] = document.getElementById('subtotalArbNac').textContent;
            formData['subtotalPubInt'] = document.getElementById('subtotalPubInt').textContent;
            formData['subtotalPubNac'] = document.getElementById('subtotalPubNac').textContent;   
            formData['subtotalRevInt'] = document.getElementById('subtotalRevInt').textContent;
            formData['subtotalRevNac'] = document.getElementById('subtotalRevNac').textContent;
            formData['subtotalRevista'] = document.getElementById('subtotalRevista').textContent;                   


            // Comisiones
            formData['comisionArbInt'] = form.querySelector('input[id="comisionArbInt"]').value;
            formData['comisionArbNac'] = form.querySelector('input[id="comisionArbNac"]').value;
            formData['comisionPubInt'] = form.querySelector('input[id="comisionPubInt"]').value;
            formData['comisionPubNac'] = form.querySelector('input[id="comisionPubNac"]').value;
            formData['comisionRevInt'] = form.querySelector('input[id="comisionRevInt"]').value;
            formData['comisionRevNac'] = form.querySelector('input[id="comisionRevNac"]').value;
            formData['comisionRevista'] = form.querySelector('input[id="comisionRevista"]').value;

            // Observaciones
            formData['obsArbInt'] = form.querySelector('input[id="obsArbInt"]').value;
            formData['obsArbNac'] = form.querySelector('input[id="obsArbNac"]').value;
            formData['obsPubInt'] = form.querySelector('input[id="obsPubInt"]').value;
            formData['obsPubNac'] = form.querySelector('input[id="obsPubNac"]').value;
            formData['obsRevInt'] = form.querySelector('input[id="obsRevInt"]').value;
            formData['obsRevNac'] = form.querySelector('input[id="obsRevNac"]').value;
            formData['obsRevista'] = form.querySelector('input[id="obsRevista"]').value;


            formData['score3_16'] = document.getElementById('score3_16').textContent;
            formData['comision3_16'] = document.getElementById('comision3_16').textContent;

            // Observations

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
    </script>

</body>

</html>