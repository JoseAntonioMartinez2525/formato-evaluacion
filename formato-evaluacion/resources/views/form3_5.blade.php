@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-head-resources />
</head>

<body class="bg-gray-50 text-black/50">

    <div class="relative min-h-screen flex flex-col items-center justify-center">
        @if (Route::has('login'))
            @if (Auth::check())
                <section role="region" aria-label="Response form" class="menu">
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
                                    <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('secretaria') }}">Selección de
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
        <form id="form3_5" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form35', 'form3_5');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <div>
                <!-- 3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC  -->
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4 mt-3" for="">75</label>
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
                        <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                        </th>
                        <th class="table-ajust" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <thead>
                        <tr>
                            <th id="seccion3_5" colspan=2 class="punto3_5" scope=col style="padding:30px;">3.5
                                Asistencia, puntualidad y
                                permanencia en el desempeño docente, evaluada por el JD y por CAAC
                            </th>
                            <td class="punto3_5">Puntaje</td>
                            <td class="punto3_5">Cantidad</td>
                            <td id="score3_5">0</td>
                            <td id="comision3_5">0</td>
                        </tr>
                    </thead>
                    <thead>
                        <td class="punto3_5">a)</td>
                        <td>Evaluado por la persona titular de DA</td>
                        <td id="p35"><b>35</b></td>
                        <td id="cantDA" name="cantDA">
                        </td>
                        <td id="cantDA2"></td>
                        <td>@if($userType == 'dictaminador')
                            <input type="number" id="comDA" placeholder="0" oninput="onActv3Comision3_5()" value="{{ oldValueOrDefault('comDA') }}">
                        @else
                            <span id="comDA" name="comDA"></span>
                            @endif
                        </td>
                        <td>@if($userType == 'dictaminador')
                            <input id="obs3_5_1" name="obs3_5_1" class="table-header" type="text">
                            @else
                            <span id="obs3_5_1" name="obs3_5_1" class="table-header"></span>
                            @endif
                        </td>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <td class="punto3_5">b)</td>
                            <td>Evaluado por CAAC</td>
                            <td id="pCAAC40"><b>40</b></td>
                            <td id="cantCAAC" name="cantCAAC"></td>
                            <td id="cantCAAC2" name="cantCAAC2"></td>
                            <td>@if($userType == 'dictaminador')
                                <input type="number" id="comNCAA"
                                oninput="onActv3Comision3_5()" value="{{ oldValueOrDefault('comNCAA') }}">
                            @else
                                <span id="comNCAA" name="comNCAA"></span>
                                @endif
                            </td>
                            <td>@if($userType == 'dictaminador')
                                <input id="obs3_5_2" name="obs3_5_2" class="table-header" type="text">
                                @else
                                <span id="obs3_5_2" name="obs3_5_2" class="table-header"></span>
                                @endif
                            </td>
                        </tr>
                    </thead>
                </tbody>
            </table>
            <!--Tabla informativa Acreditacion Actividad 3.5-->
            <table>
                <thead>
                    <tr>
                        <th class="acreditacion" scope="col">Acreditacion: </th>
            
                        <th class="descripcion"><b>JDA y CAAC</b>
                        <th>
                        @if($userType != '')    
                            <button id="btn3_5" type="submit" class="btn custom-btn printButtonClass">Enviar
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
                                document.getElementById('score3_5').textContent = data.form3_5.score3_5 || '0';
                                document.getElementById('cantDA').textContent = data.form3_5.cantDA || '0';
                                document.getElementById('cantCAAC').textContent = data.form3_5.cantCAAC || '0';
                                document.getElementById('cantDA2').textContent = data.form3_5.cantDA2 || '0';
                                document.getElementById('cantCAAC2').textContent = data.form3_5.cantCAAC2 || '0';


                                // Populate hidden inputs
                                document.querySelector('input[name="user_id"]').value = data.form3_5.user_id || '';
                                document.querySelector('input[name="email"]').value = data.form3_5.email || '';
                                document.querySelector('input[name="user_type"]').value = data.form3_5.user_type || '';

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
                                if (data.form3_5) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';

                                    document.getElementById('score3_5').textContent = data.form3_5.score3_5 || '0';
                                    document.getElementById('cantDA').textContent = data.form3_5.cantDA || '0';
                                    document.getElementById('cantCAAC').textContent = data.form3_5.cantCAAC || '0';
                                    document.getElementById('cantDA2').textContent = data.form3_5.cantDA2 || '0';
                                    document.getElementById('cantCAAC2').textContent = data.form3_5.cantCAAC2 || '0';

                                    document.getElementById('comision3_5').textContent = data.form3_5.comision3_5 || '0';
                                    document.querySelector('span[name="comDA"]').textContent = data.form3_5.comDA || '0';
                                    document.querySelector('span[name="comNCAA"]').textContent = data.form3_5.comNCAA || '0';
                                    document.querySelector('span[name="obs3_5_1"]').textContent = data.form3_5.obs3_5_1 || '';
                                    document.querySelector('span[name="obs3_5_2"]').textContent = data.form3_5.obs3_5_2 || '';

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

                                    console.error('No form3_5 data found for the selected dictaminador.');
                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('score3_5').textContent = '0';
                                    document.getElementById('cantDA').textContent = '0';
                                    document.getElementById('cantCAAC').textContent = '0';
                                    document.getElementById('cantDA2').textContent = '0';
                                    document.getElementById('cantCAAC2').textContent = '0';
                                    document.getElementById('comision3_5').textContent = '0';
                                    document.querySelector('span[name="comDA"]').textContent = '0';
                                    document.querySelector('span[name="comNCAA"]').textContent = '0';
                                    document.querySelector('span[name="obs3_5_1"]').textContent = '';
                                    document.querySelector('span[name="obs3_5_2"]').textContent = '';

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
            formData['cantDA'] = document.getElementById('cantDA').textContent;
            formData['cantCAAC'] = document.getElementById('cantCAAC').textContent;
            formData['cantDA2'] = document.getElementById('cantDA2').textContent;
            formData['cantCAAC2'] = document.getElementById('cantCAAC2').textContent;
            formData['comDA'] = form.querySelector('input[id="comDA"]').value;
            formData['comNCAA'] = form.querySelector('input[id="comNCAA"]').value;
            formData['score3_5'] = document.getElementById('score3_5').textContent;
            formData['comision3_5'] = document.getElementById('comision3_5').textContent;

            // Observations
            formData['obs3_5_1'] = form.querySelector('input[name="obs3_5_1"]').value;
            formData['obs3_5_2'] = form.querySelector('input[name="obs3_5_2"]').value;

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