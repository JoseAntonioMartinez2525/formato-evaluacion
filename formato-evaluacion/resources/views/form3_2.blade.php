@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Calidad del desempeño docente evaluada por el alumnado</title>
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
                                <a class="nav-link disabled enlaceSN" href="#">
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
        <form id="form3_2" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form32', 'form3_2');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <div>
            <!-- Actividad 3.2 Calidad del desempeño docente evaluada por el alumnado -->
            <h4>Puntaje máximo
                <label class="bg-black text-white px-4 mt-3" for="">50</label>
            </h4>
            </div>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Actividad</th>
                            <th class="table-ajust" scope="col"></th>
                            <th class="table-ajust" scope="col"></th>
                            <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                            <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                            <th class="table-ajust" scope="col">Observaciones</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <td id="seccion3_2" style="height: 80px; width: 200px;">3.2 Calidad del desempeño
                                docente
                                evaluada por el alumnado
                            </td>
                            <td>Puntaje</td>
                            <td style="text-align:left;">Cantidad</td>
                            <td id="score3_2" for="">0</td>
                            <td id="comision3_2">0</td>
                        </tr>
                    </thead>
                    <thead>
                        <!--prom90-100-->
                        <tr>
                            <td class="ranges">
                                <center>Promedio 90-100</center>
                            </td>
                            <td id="ran1"><b>50</b></td>
                            <td class="elabinput" style="background-color: #c1cfd3;text-align:right;"><span id="r1" name="r1"></span></td>
                            <td id="cant1" name="cant1">0</td>
                            <td>
                            @if($userType == 'dictaminador')
                                <input id="prom90_100" type="number" 
                                    oninput="onActv3_2Comision()" value="{{ oldValueOrDefault('prom90_100') }}">
                            @else
                            <span id="prom90_100" name="prom90_100"></span>
                            @endif
                            </td>
                            <td>
                            @if($userType == 'dictaminador')
                                <input id="obs3_2_1" name="obs3_2_1" class="table-header" type="text">
                            @else
                                <span id="obs3_2_1" name="obs3_2_1" class="table-header"></span>
                            @endif

                            </td>
                        </tr>
                        <!--prom80-90-->
                        <tr>
                            <td class="ranges">
                                <center>Promedio 80-90</center>
                            </td>
                            <td id="ran2"><b>40</b></td>
                            <td class="elabInput" style="background-color: #c1cfd3;"><span id="r2" name="r2"></span></td>
                            <td id="cant2" name="cant2">0</td>

                            <td>
                             @if($userType == 'dictaminador')   
                                <input id="prom80_90" type="number"
                                    oninput="onActv3_2Comision()" value="{{ oldValueOrDefault('prom80_90') }}">
                            @else
                                <span id="prom80_90" name="prom80_90"></span>
                            @endif
                            </td>
                            <td>
                            @if($userType == 'dictaminador')    
                                <input id="obs3_2_2" name="obs3_2_2" class="table-header" type="text">
                            @else
                                <span id="obs3_2_2" name="obs3_2_2" class="table-header"></span>
                            @endif
                            </td>
                        </tr>
                        <!--prom70-80-->
                        <tr>
                            <td class="ranges">
                                <center>Promedio 70-80</center>
                            </td>
                            <td id="ran3"><b>30</b></td>
                            <td class="elabInput" style="background-color: #c1cfd3;">
                                <span id="r3" name="r3"></span>
                            </td>
                            <td id="cant3">0</td>
                            <td>
                            @if($userType == 'dictaminador')  
                                <input id="prom70_80" placeholder="0" type="number"
                                        oninput="onActv3_2Comision()" value="{{ oldValueOrDefault('prom70_80') }}">
                            @else
                            <span id="prom70_80" name="prom70_80"></span>
                            @endif
                            </td>
                            <td>
                            @if($userType == 'dictaminador')  
                                <input id="obs3_2_3"  name="obs3_2_3" class="table-header" type="text">
                            @else
                                <span id="obs3_2_3" name="obs3_2_3" class="table-header"></span>
                            @endif
                            </td>
                        </tr>
                    </thead>
                    </table>
                    <!--Tabla informativa Acreditacion Actividad 3.2-->
                <table>
                    <thead>
                        <tr><br>
                            <th class="acreditacion" scope="col">Acreditacion: </th>

                            <th class="descripcionDDIE"><b>DDIE</b>
                            <th> 
                            @if($userType != '')     
                                <button id="btn3_2" type="submit" class="btn custom-btn printButtonClass">Enviar
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
                                document.getElementById('score3_2').textContent = data.form3_2.score3_2 || '0';
                                document.getElementById('r1').textContent = data.form3_2.r1 || '0';
                                document.getElementById('r2').textContent = data.form3_2.r2 || '0';
                                document.getElementById('r3').textContent = data.form3_2.r3 || '0';
                                document.getElementById('cant1').textContent = data.form3_2.cant1 || '0';
                                document.getElementById('cant2').textContent = data.form3_2.cant2 || '0';
                                document.getElementById('cant3').textContent = data.form3_2.cant3 || '0';


                                // Populate hidden inputs
                                document.querySelector('input[name="user_id"]').value = data.form3_2.user_id || '';
                                document.querySelector('input[name="email"]').value = data.form3_2.email || '';
                                document.querySelector('input[name="user_type"]').value = data.form3_2.user_type || '';

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
                                if (data.form3_2) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';

                                    document.getElementById('score3_2').textContent = data.form3_2.score3_2 || '0';
                                    document.getElementById('r1').textContent = data.form3_2.r1 || '0';
                                    document.getElementById('r2').textContent = data.form3_2.r2 || '0';
                                    document.getElementById('r3').textContent = data.form3_2.r3 || '0';
                                    document.getElementById('cant1').textContent = data.form3_2.cant1 || '0';
                                    document.getElementById('cant2').textContent = data.form3_2.cant2 || '0';
                                    document.getElementById('cant3').textContent = data.form3_2.cant3 || '0';
                                    document.getElementById('comision3_2').textContent = data.form3_2.comision3_2 || '0';
                                    document.querySelector('span[name="prom90_100"]').textContent = data.form3_2.prom90_100 || '0';
                                    document.querySelector('span[name="prom80_90"]').textContent = data.form3_2.prom80_90 || '0';
                                    document.querySelector('span[name="prom70_80"]').textContent = data.form3_2.prom70_80 || '0';
                                    document.querySelector('span[name="obs3_2_1"]').textContent = data.form3_2.obs3_2_1 || '';
                                    document.querySelector('span[name="obs3_2_2"]').textContent = data.form3_2.obs3_2_2 || '';
                                    document.querySelector('span[name="obs3_2_3"]').textContent = data.form3_2.obs3_2_3 || '';

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

                                    console.error('No form3_2 data found for the selected dictaminador.');
                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';
                                    document.getElementById('r1').textContent = '0';
                                    document.getElementById('r2').textContent = '0';
                                    document.getElementById('r3').textContent = '0';
                                    document.getElementById('cant1').textContent = '0';
                                    document.getElementById('cant2').textContent = '0';
                                    document.getElementById('cant3').textContent = '0';
                                    document.getElementById('comision3_2').textContent = '0';
                                    document.querySelector('span[name="prom90_100"]').textContent = '0';
                                    document.querySelector('span[name="prom80_90"]').textContent = '0';
                                    document.querySelector('span[name="prom70_80"]').textContent = '0';
                                    document.querySelector('span[name="obs3_2_1"]').textContent = '';
                                    document.querySelector('span[name="obs3_2_2"]').textContent = '';
                                    document.querySelector('span[name="obs3_2_3"]').textContent = '';

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
            formData['r1'] = document.getElementById('r1').textContent;
            formData['prom90_100'] = document.getElementById('prom90_100').value; // Ensure input value is fetched
            formData['r2'] = document.getElementById('r2').textContent;
            formData['r3'] = document.getElementById('r3').textContent;
            formData['prom80_90'] = document.getElementById('prom80_90').value; // Ensure input value is fetched
            formData['cant1'] = document.getElementById('cant1').textContent;
            formData['cant2'] = document.getElementById('cant2').textContent;
            formData['prom70_80'] = document.getElementById('prom70_80').value; // Ensure input value is fetched
            formData['cant3'] = document.getElementById('cant3').textContent;
            formData['prom90_100'] = form.querySelector('input[id="prom90_100"]').value;
            formData['prom80_90'] = form.querySelector('input[id="prom80_90"]').value;
            formData['prom70_80'] = form.querySelector('input[id="prom70_80"]').value;
            formData['score3_2'] = document.getElementById('score3_2').textContent;
            formData['comision3_2'] = document.getElementById('comision3_2').textContent;

            // Observations
            formData['obs3_2_1'] = form.querySelector('input[name="obs3_2_1"]').value;
            formData['obs3_2_2'] = form.querySelector('input[name="obs3_2_2"]').value;
            formData['obs3_2_3'] = form.querySelector('input[name="obs3_2_3"]').value;


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