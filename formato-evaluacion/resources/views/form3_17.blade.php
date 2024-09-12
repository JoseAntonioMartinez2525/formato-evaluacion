@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Proyectos académicos de extensión y difusión</title>
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
        <form id="form3_17" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form317', 'form3_17');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <!--3.17 Proyectos académicos de extensión y difusión-->
            <h4>Puntaje máximo
                <label class="bg-black text-white px-4 mt-3" for="">50</label>
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
                            <h3 style="width: 50px;">Cuerpos Colegiados</h3>
                        </th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th scope="col" colspan=2>Actividad</th>
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
                        <th id="seccion3_17" class="acreditacion" colspan=3> 3.17 Proyectos académicos de
                            extensión y
                            difusión</th>
                        <th class="acreditacion">Puntaje</th>
                        <th class="acreditacion">Cantidad</th>
                        <th></th>
                        <th id="score3_17">0</th>
                        <th id="comision3_17">0</th>
                        <th class="acreditacion" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>a)</td>
                        <td>Inicio de proyectos de extensión y difusión con financiamiento externo</td>
                        <td></td>
                        <td id="puntajeDifusionExt"><b>15</b></td>
                        <td id="cantDifusionExt"></td>
                        <td></td>
                        <td id="subtotalDifusionExt"></td>
                        <td>
                        @if ($userType == 'dictaminador')
                            <input type="value" id="comisionDifusionExt" placeholder="0" oninput="onActv3Comision3_17()">
                        @else
                            <span id="comisionDifusionExt"></span>
                        @endif
                        </td>
                        <td>
                        @if ($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsDifusionExt">
                        @else
                            <span id="obsDifusionExt"></span>
                        @endif
                         </td>
                    </tr>
                    <tr>
                        <td>b)</td>
                        <td>Inicio de proyectos de extensión y difusión internos, aprobados por CAAC
                        </td>
                        <td></td>
                        <td id="puntajeDifusionInt"><b>10</b></td>
                        <td id="cantDifusionInt"></td>
                        <td></td>
                        <td id="subtotalDifusionInt"></td>
                        <td>
                        @if ($userType == 'dictaminador')    
                            <input type="value" id="comisionDifusionInt" placeholder="0" oninput="onActv3Comision3_17()">
                        @else
                             <span id="comisionDifusionInt"></span>
                        @endif
                        </td>
                        <td>
                        @if ($userType == 'dictaminador')      
                            <input class="table-header" type="text" id="obsDifusionInt">
                        @else
                            <span id="obsDifusionInt"></span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>c)</td>
                        <td>Reporte cumplido del periodo anual de proyecto de extensión y difusión con
                            financiamiento
                            externo
                        </td>
                        <td></td>
                        <td id="puntajeRepDifusionExt"><b>35</b></td>
                        <td id="cantRepDifusionExt" ></td>
                        <td></td>
                        <td id="subtotalRepDifusionExt"></td>
                        <td>
                        @if ($userType == 'dictaminador')  
                            <input type="value" id="comisionRepDifusionExt" placeholder="0" oninput="onActv3Comision3_17()">
                        @else
                            <span id="comisionRepDifusionExt"></span>
                        @endif
                        </td>
                        <td>
                        @if ($userType == 'dictaminador')  
                            <input class="table-header" type="text" id="obsRepDifusionExt">
                        @else
                            <span id="obsRepDifusionExt"></span>
                        @endif    
                        </td>
                    </tr>
                    <tr>
                        <td>d)</td>
                        <td>Reporte cumplido del periodo anual de proyecto de extensión y difusión
                            internos, aprobados por
                            CAAC</td>
                        <td></td>
                        <td id="puntajeRepDifusionInt"><b>20</b></td>
                        <td id="cantRepDifusionInt">
                        </td>
                        <td></td>
                        <td id="subtotalRepDifusionInt"></td>
                        <td>
                        @if ($userType == 'dictaminador')      
                            <input type="value" id="comisionRepDifusionInt" placeholder="0" oninput="onActv3Comision3_17()">
                        @else
                            <span id="comisionRepDifusionInt"></span>
                        @endif
                        </td>
                        <td>
                        @if ($userType == 'dictaminador')      
                            <input class="table-header" type="text" id="obsRepDifusionInt">
                        @else
                            <span id="obsRepDifusionInt"></span>
                        @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--Tabla informativa Acreditacion Actividad 3.17-->
            <table>
                <thead>
                    <tr>
                        <th class="acreditacion" scope="col">Acreditacion: </th>
                        <th class="descripcion"><b>CAAC, DDCEU</b></th>
                        <th><button id="btn3_17" type="submit" class="btn custom-btn printButtonClass">Enviar</button></th>
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
                                console.log('Fetched data:', data); 
                                // Populate fields with fetched data
                                document.getElementById('score3_17').textContent = data.form3_17.score3_17 || '0';

                                // Cantidades
                                document.getElementById('cantDifusionExt').textContent = data.form3_17.cantDifusionExt || '0';
                                document.getElementById('cantDifusionInt').textContent = data.form3_17.cantDifusionInt || '0';
                                document.getElementById('cantRepDifusionExt').textContent = data.form3_17.cantRepDifusionExt || '0';
                                document.getElementById('cantRepDifusionInt').textContent = data.form3_17.cantRepDifusionInt || '0';


                                // Subtotales
                                document.getElementById('subtotalDifusionExt').textContent = data.form3_17.subtotalDifusionExt || '0';
                                document.getElementById('subtotalDifusionInt').textContent = data.form3_17.subtotalDifusionInt || '0';
                                document.getElementById('subtotalRepDifusionExt').textContent = data.form3_17.subtotalRepDifusionExt || '0';
                                document.getElementById('subtotalRepDifusionInt').textContent = data.form3_17.subtotalRepDifusionInt || '0';

                                //  hidden inputs
                                document.querySelector('input[name="user_id"]').value = data.form3_17.user_id || '';
                                document.querySelector('input[name="email"]').value = data.form3_17.email || '';
                                document.querySelector('input[name="user_type"]').value = data.form3_17.user_type || '';
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
                                if (data.form3_17) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';
                                    document.getElementById('score3_17').textContent = data.form3_17.score3_17 || '0';
                                    document.getElementById('comision3_17').textContent = data.form3_17.comision3_17 || '0';

                                    // Cantidades
                                    document.getElementById('cantDifusionExt').textContent = data.form3_17.cantDifusionExt || '0';
                                    document.getElementById('cantDifusionInt').textContent = data.form3_17.cantDifusionInt || '0';
                                    document.getElementById('cantRepDifusionExt').textContent = data.form3_17.cantRepDifusionExt || '0';
                                    document.getElementById('cantRepDifusionInt').textContent = data.form3_17.cantRepDifusionInt || '0';


                                    // Subtotales
                                    document.getElementById('subtotalDifusionExt').textContent = data.form3_17.subtotalDifusionExt || '0';
                                    document.getElementById('subtotalDifusionInt').textContent = data.form3_17.subtotalDifusionInt || '0';
                                    document.getElementById('subtotalRepDifusionExt').textContent = data.form3_17.subtotalRepDifusionExt || '0';
                                    document.getElementById('subtotalRepDifusionInt').textContent = data.form3_17.subtotalRepDifusionInt || '0';


                                    // Comisiones
                                    document.querySelector('#comisionDifusionExt').textContent = data.form3_17.comisionDifusionExt || '0';
                                    document.querySelector('#comisionDifusionInt').textContent = data.form3_17.comisionDifusionInt || '0';
                                    document.querySelector('#comisionRepDifusionExt').textContent = data.form3_17.comisionRepDifusionExt || '0';
                                    document.querySelector('#comisionRepDifusionInt').textContent = data.form3_17.comisionRepDifusionInt || '0';


                                    // Observaciones
                                    document.querySelector('#obsDifusionExt').textContent = data.form3_17.obsDifusionExt || '';
                                    document.querySelector('#obsDifusionInt').textContent = data.form3_17.obsDifusionInt || '';
                                    document.querySelector('#obsRepDifusionExt').textContent = data.form3_17.obsRepDifusionExt || '';
                                    document.querySelector('#obsRepDifusionInt').textContent = data.form3_17.obsRepDifusionInt || '';



                                } else {
                                    console.error('No form3_17 data found for the selected dictaminador.');

                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('score3_17').textContent = '0';

                                    // Cantidades
                                    document.getElementById('cantDifusionExt').textContent =  '0';
                                    document.getElementById('cantDifusionInt').textContent = '0';
                                    document.getElementById('cantRepDifusionExt').textContent = '0';
                                    document.getElementById('cantRepDifusionInt').textContent = '0';


                                    // Subtotales
                                    document.getElementById('subtotalDifusionExt').textContent = '0';
                                    document.getElementById('subtotalDifusionInt').textContent = '0';
                                    document.getElementById('subtotalRepDifusionExt').textContent =  '0';
                                    document.getElementById('subtotalRepDifusionInt').textContent =  '0';


                                    // Comisiones
                                    document.querySelector('#comisionDifusionExt').textContent = '0';
                                    document.querySelector('#comisionDifusionInt').textContent = '0';
                                    document.querySelector('#comisionRepDifusionExt').textContent = '0';
                                    document.querySelector('#comisionRepDifusionInt').textContent = '0';


                                    // Observaciones
                                    document.querySelector('#obsDifusionExt').textContent = '';
                                    document.querySelector('#obsDifusionInt').textContent = '';
                                    document.querySelector('#obsRepDifusionExt').textContent = '';
                                    document.querySelector('#obsRepDifusionInt').textContent = '';                                   

                                    document.getElementById('comision3_17').textContent = '0';
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
            formData['cantDifusionExt'] = form.querySelector('td[id="cantDifusionExt"]').textContent;
            formData['cantDifusionInt'] = form.querySelector('td[id="cantDifusionInt"]').textContent;
            formData['cantRepDifusionExt'] = form.querySelector('td[id="cantRepDifusionExt"]').textContent;
            formData['cantRepDifusionInt'] = form.querySelector('td[id="cantRepDifusionInt"]').textContent;


            // Subtotales
            formData['subtotalDifusionExt'] = document.getElementById('subtotalDifusionExt').textContent;
            formData['subtotalDifusionInt'] = document.getElementById('subtotalDifusionInt').textContent;
            formData['subtotalRepDifusionExt'] = document.getElementById('subtotalRepDifusionExt').textContent;
            formData['subtotalRepDifusionInt'] = document.getElementById('subtotalRepDifusionInt').textContent;


            // Comisiones
            formData['comisionDifusionExt'] = form.querySelector('input[id="comisionDifusionExt"]').value;
            formData['comisionDifusionInt'] = form.querySelector('input[id="comisionDifusionInt"]').value;
            formData['comisionRepDifusionExt'] = form.querySelector('input[id="comisionRepDifusionExt"]').value;
            formData['comisionRepDifusionInt'] = form.querySelector('input[id="comisionRepDifusionInt"]').value;

            // Observaciones
            formData['obsDifusionExt'] = form.querySelector('input[id="obsDifusionExt"]').value;
            formData['obsDifusionInt'] = form.querySelector('input[id="obsDifusionInt"]').value;
            formData['obsRepDifusionExt'] = form.querySelector('input[id="obsRepDifusionExt"]').value;
            formData['obsRepDifusionInt'] = form.querySelector('input[id="obsRepDifusionInt"]').value;

            formData['score3_17'] = document.getElementById('score3_17').textContent;
            formData['comision3_17'] = document.getElementById('comision3_17').textContent;

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