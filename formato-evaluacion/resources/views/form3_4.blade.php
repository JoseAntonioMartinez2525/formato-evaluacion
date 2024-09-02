@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Distinciones académicas recibidas por el docente</title>
    <meta charset="utf-8">
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
                            <li class="nav-item">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('docencia') }}">Apartado 3</a>
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
        <form id="form3_4" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form34', 'form3_4');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <div>
                <!-- 3.4 Distinciones académicas recibidas por el docente  -->
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4 mt-3" for="">60</label>
                </h4>
            </div>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Actividad</th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                        <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                        <th class="table-ajust" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th id="seccion3_4" colspan="2" class="punto3_4" scope="col" style="padding:30px;">3.4 Distinciones
                            académicas recibidas por el docente</th>
                        <td class="punto3_4">Puntaje</td>
                        <td class="punto3_4">Cantidad</td>
                        <td id="score3_4">0</td>
                        <td id="comision3_4">0</td>
                    </tr>
                    <tr>
                        <td class="punto3_4">a)</td>
                        <td>Internacional</td>
                        <td id="p60"><b>60</b></td>
                        <td>
                            <span id="cantInternacional" name="cantInternacional"></span>
                        </td>
                        <td id="cantInternacional2"></td>
                        <td>@if($userType == 'dictaminador')
                            <input type="number" id="comInternacional" placeholder="0" oninput="onActv3Comision3_4()">
                            @else
                            <span id="comInternacional" name="comInternacional"></span>
                            @endif
                        </td>
                        <td>@if($userType == 'dictaminador')
                            <input id="obs3_4_1" name="obs3_4_1" class="table-header" type="text">
                        @else
                            <span id="obs3_4_1" name="obs3_4_1" class="table-header"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="punto3_4">b)</td>
                        <td>Nacional</td>
                        <td id="p30Nac"><b>30</b></td>
                        <td><span type="number" id="cantNacional"></span></td>
                        <td id="cantNacional2"></td>
                        <td>@if($userType == 'dictaminador')
                            <input type="number" id="comNacional"name="comNacional" placeholder="0" oninput="onActv3Comision3_4()">
                            @else
                            <span id="comNacional" name="comNacional"></span>
                            @endif
                        </td>
                        <td>@if($userType == 'dictaminador')
                            <input id="obs3_4_2" name="obs3_4_2" class="table-header" type="text">
                            @else
                                <span id="obs3_4_2" name="obs3_4_2" class="table-header"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="punto3_4">c)</td>
                        <td>Regional o estatal</td>
                        <td id="p20"><b>20</b></td>
                        <td>
                            <span id="cantidadRegional"></span>
                        </td>
                        <td id="cantidadRegional2"></td>
                        <td>@if($userType == 'dictaminador')
                            <input type="number" id="comRegional" name="comRegional" placeholder="0" oninput="onActv3Comision3_4()">
                            @else
                            <span id="comRegional" name="comRegional"></span>
                            @endif
                        </td>
                        <td>@if($userType == 'dictaminador')
                            <input id="obs3_4_3" name="obs3_4_3" class="table-header" type="text">
                            @else
                            <span id="obs3_4_3" name="obs3_4_3" class="table-header"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="punto3_4">d)</td>
                        <td>Preparación de grupos de alumnado para olimpiadas competencias académicas o exámenes generales.</td>
                        <td id="p30Prep"><b>30</b></td>
                        <td>
                            <span id="cantPreparacion"></span>
                        </td>
                        <td id="cantPreparacion2"></td>
                        <td>@if($userType == 'dictaminador')
                            <input type="number" id="comPreparacion" placeholder="0" oninput="onActv3Comision3_4()">
                            @else
                            <span id="comPreparacion" name="comPreparacion"></span>
                            @endif
                        </td>
                        <td>
                            @if($userType == 'dictaminador')
                            <input id="obs3_4_4" name="obs3_4_4" class="table-header" type="text">
                            @else
                                <span id="obs3_4_4" name="obs3_4_4" class="table-header"></span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--Tabla informativa Acreditacion Actividad 3.4-->
            <table>
                <thead>
                    <tr><br>
                        <th class="acreditacion" scope="col">Acreditacion: </th>
                        <th class="descripcionCAAC"><b>CAAC, Instancia que la otorga</b></th>
                        <th>@if($userType != '')
                            <button id="btn3_4" type="submit" class="btn custom-btn printButtonClass">Enviar</button>
                            @endif
                        </th>
                    </tr>
                </thead>
            </table>
            </form>
    </main>

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
                                document.getElementById('score3_4').textContent = data.form3_4.score3_4 || '0';
                                document.getElementById('cantInternacional').textContent = data.form3_4.cantInternacional || '0';
                                document.getElementById('cantNacional').textContent = data.form3_4.cantNacional || '0';
                                document.getElementById('cantidadRegional').textContent = data.form3_4.cantidadRegional || '0';
                                document.getElementById('cantPreparacion').textContent = data.form3_4.cantPreparacion || '0';
                                document.getElementById('cantInternacional2').textContent = data.form3_4.cantInternacional2 || '0';
                                document.getElementById('cantNacional2').textContent = data.form3_4.cantNacional2 || '0';
                                document.getElementById('cantidadRegional2').textContent = data.form3_4.cantidadRegional2 || '0';
                                document.getElementById('cantPreparacion2').textContent = data.form3_4.cantPreparacion2 || '0';

                                // Populate hidden inputs
                                document.querySelector('input[name="user_id"]').value = data.form3_4.user_id || '';
                                document.querySelector('input[name="email"]').value = data.form3_4.email || '';
                                document.querySelector('input[name="user_type"]').value = data.form3_4.user_type || '';
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
                                if (data.form3_4) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';

                                    document.getElementById('score3_4').textContent = data.form3_4.score3_4 || '0';
                                    document.getElementById('cantInternacional').textContent = data.form3_4.cantInternacional || '0';
                                    document.getElementById('cantNacional').textContent = data.form3_4.cantNacional || '0';
                                    document.getElementById('cantidadRegional').textContent = data.form3_4.cantidadRegional || '0';
                                    document.getElementById('cantPreparacion').textContent = data.form3_4.cantPreparacion || '0';
                                    document.getElementById('cantInternacional2').textContent = data.form3_4.cantInternacional2 || '0';
                                    document.getElementById('cantNacional2').textContent = data.form3_4.cantNacional2 || '0';
                                    document.getElementById('cantidadRegional2').textContent = data.form3_4.cantidadRegional2 || '0';
                                    document.getElementById('cantPreparacion2').textContent = data.form3_4.cantPreparacion2 || '0';

                                    document.getElementById('comision3_4').textContent = data.form3_4.comision3_4 || '0';
                                    document.querySelector('span[name="comInternacional"]').textContent = data.form3_4.comInternacional || '0';
                                    document.querySelector('span[name="comNacional"]').textContent = data.form3_4.comNacional || '0';
                                    document.querySelector('span[name="comRegional"]').textContent = data.form3_4.comRegional || '0';
                                    document.querySelector('span[name="comPreparacion"]').textContent = data.form3_4.comPreparacion || '0';
                                    document.querySelector('span[name="obs3_4_1"]').textContent = data.form3_4.obs3_4_1 || '';
                                    document.querySelector('span[name="obs3_4_2"]').textContent = data.form3_4.obs3_4_2 || '';
                                    document.querySelector('span[name="obs3_4_3"]').textContent = data.form3_4.obs3_4_3 || '';
                                    document.querySelector('span[name="obs3_4_4"]').textContent = data.form3_4.obs3_4_4 || '';

                                } else {

                                    console.error('No form3_4 data found for the selected dictaminador.');
                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('score3_4').textContent = '0';
                                    document.getElementById('cantInternacional').textContent = '0';
                                    document.getElementById('cantNacional').textContent = '0';
                                    document.getElementById('cantidadRegional').textContent = '0';
                                    document.getElementById('cantPreparacion').textContent = '0';
                                    document.getElementById('cantInternacional2').textContent = '0';
                                    document.getElementById('cantNacional2').textContent = '0';
                                    document.getElementById('cantidadRegional2').textContent = '0';
                                    document.getElementById('cantPreparacion2').textContent = '0';
                                    document.getElementById('comision3_4').textContent = '0';
                                    document.querySelector('span[name="comInternacional"]').textContent = '0';
                                    document.querySelector('span[name="comNacional"]').textContent = '0';
                                    document.querySelector('span[name="comRegional"]').textContent = '0';
                                    document.querySelector('span[name="comPreparacion"]').textContent = '0';
                                    document.querySelector('span[name="obs3_4_1"]').textContent = '';
                                    document.querySelector('span[name="obs3_4_2"]').textContent = '';
                                    document.querySelector('span[name="obs3_4_3"]').textContent = '';
                                    document.querySelector('span[name="obs3_4_4"]').textContent = '';
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

            // Gather all related information from the form
            formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
            formData['user_id'] = form.querySelector('input[name="user_id"]').value;
            formData['email'] = form.querySelector('input[name="email"]').value;
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;
            formData['cantInternacional'] = document.getElementById('cantInternacional').textContent;
            formData['cantNacional'] = document.getElementById('cantNacional').textContent;
            formData['cantidadRegional'] = document.getElementById('cantidadRegional').textContent;
            formData['cantPreparacion'] = document.getElementById('cantPreparacion').textContent;
            formData['cantInternacional2'] = document.getElementById('cantInternacional2').textContent;
            formData['cantNacional2'] = document.getElementById('cantNacional2').textContent;
            formData['cantidadRegional2'] = document.getElementById('cantidadRegional2').textContent;
            formData['cantPreparacion2'] = document.getElementById('cantPreparacion2').textContent;
            formData['comInternacional'] = form.querySelector('input[id="comInternacional"]').value;
            formData['comNacional'] = form.querySelector('input[id="comNacional"]').value;
            formData['comRegional'] = form.querySelector('input[id="comRegional"]').value;
            formData['comPreparacion'] = form.querySelector('input[id="comPreparacion"]').value;
            formData['score3_4'] = document.getElementById('score3_4').textContent;
            formData['comision3_4'] = document.getElementById('comision3_4').textContent;

            // Observations
            formData['obs3_4_1'] = form.querySelector('input[name="obs3_4_1"]').value;
            formData['obs3_4_2'] = form.querySelector('input[name="obs3_4_2"]').value;
            formData['obs3_4_3'] = form.querySelector('input[name="obs3_4_3"]').value;
            formData['obs3_4_4'] = form.querySelector('input[name="obs3_4_4"]').value;

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