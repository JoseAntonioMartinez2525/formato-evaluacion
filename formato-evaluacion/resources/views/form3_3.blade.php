@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Publicaciones relacionadas con la docencia</title>
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
        <form id="form3_3" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form33', 'form3_3');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <div>
                <!-- Actividad 3.3 Publicaciones relacionadas con la docencia -->
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4 mt-3" for="">100</label>
                </h4>
            </div>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Actividad</th>
                        <th class="table-ajust" scope="col"></th>
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
                            <td id="seccion3_3">3.3 Publicaciones relacionadas con la docencia</td>
                            <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                            <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                            <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                            <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                            <td id="score3_3" for="">0</td>
                            <td id="comision3_3">0</td>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <td colspan=6>
                            </td>
                        </tr>
                        <tr>
                            <td class="incisos">Incisos</td>
                            <td class="obra">Obra</td>
                            <td>Actividad</td>
                            <td>Puntaje</td>
                            <td id="cantidadTd">Cantidad</td>
                            <td>SubTotal</td>
            
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <td>a)</td>
                            <td>Libro de texto con editorial de reconocido prestigio</td>
                            <td>Autor(a)</td>
                            <td id="p100">
                                <center><b>100</b></center>
                            </td>
                            <td class="elabInput"><span id="rc1"></span>
                            </td>
                            <td id="stotal1"></td>
                            <td class="comision actv">
                            @if($userType == 'dictaminador')
                                <input  type="number" id="comIncisoA" for=""
                                    oninput="onActv3Comision3()" value="{{ oldValueOrDefault('comIncisoA') }}">
                                </input>
                            @else
                            <span id="comIncisoA" name="comIncisoA"></span>
                            @endif
                            </td>
                            <td>
                            @if($userType == 'dictaminador')
                                <input id="obs3_3_1" name="obs3_3_1" class="table-header" type="text">
                            @else 
                            <span id="obs3_3_1" name="obs3_3_1"></span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>b)</td>
                            <td>1. Paquete didáctico, 2. Manual de operaciones</td>
                            <td>Autor(a)</td>
                            <td id="p50">
                                <center><b>50</b></center>
                            </td>
                            <td class="elabInput"><span id="rc2" name="rc2"></span></td>
                            <td id="stotal2"></td>
                            <td class="comision actv">
                             @if($userType == 'dictaminador')   
                                <input id="comIncisoB" for="" type="number"
                                    oninput="onActv3Comision3()" value="{{ oldValueOrDefault('comIncisoB') }}"></input>
                             @else    
                             <span id="comIncisoB" name="comIncisoB"></span>
                             @endif
                            </td>
                            <td>
                            @if($userType == 'dictaminador')
                                <input id="obs3_3_2" name="obs3_3_2" class="table-header" type="text">
                            @else  
                            <span id="obs3_3_2" name="obs3_3_2"></span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>c)</td>
                            <td>1. Capítulo de libro, 2. Elaboración de Manuales de laboratorio o
                                instructivos, 3. Diseño
                                y
                                construcción de equipo de laboratorio, 4. Elaboración de material
                                audiovisual, 5.
                                Elaboración
                                de
                                software educativo, 6. Notas de curso, 7. Antología comentada, 8.
                                Monografía.</td>
                            <td>Autor(a)</td>
                            <td id="p30">
                                <center><b>30</b></center>
                            </td>
                            <td class="elabInput"><span id="rc3"></span></td>
                            <td id="stotal3"></td>
                            <td class="comision actv">
                            @if($userType == 'dictaminador')    
                                <input id="comIncisoC" for="" type="number"
                                    oninput="onActv3Comision3()" value="{{ oldValueOrDefault('comIncisoC') }}">
                                </input>
                            @else 
                            <span id="comIncisoC" name="comIncisoC"></span>
                            @endif
                            </td>
                            <td>
                            @if($userType == 'dictaminador')    
                                <input id="obs3_3_3" name="obs3_3_3" class="table-header" type="text">
                            @else 
                                 <span id="obs3_3_3" name="obs3_3_3"></span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>d)</td>
                            <td>1. Traducción de libro, 2.Traducción de material de apoyo didáctico,
                                3. Traducciones
                                publicadas de artículos.</td>
                            <td>Autor(a)</td>
                            <td id="p25">
                                <center><b>25</b></center>
                            </td>
                            <td class="elabInput"><span id="rc4"></span>
                            </td>
                            <td id="stotal4"></td>
                            <td class="comision actv">
                            @if($userType == 'dictaminador')
                                <input id="comIncisoD"  for="" type="number"
                                    oninput="onActv3Comision3()" value="{{ oldValueOrDefault('comIncisoD') }}"></input>
                            @else 
                                <span id="comIncisoD" name="comIncisoD"></span>
                            @endif
                            </td>
                            <td>
                            @if($userType == 'dictaminador')    
                                <input id="obs3_3_4" name="obs3_3_4" class="table-header" type="text">
                            @else 
                                <span id="obs3_3_4" name="obs3_3_4"></span>
                            @endif
                            </td>
                        </tr>
                    </thead>
                </tbody>
            </table>
            <!--Tabla informativa Acreditacion Actividad 3.3-->
            <table>
                <thead>
                    <tr><br>
                        <th class="acreditacion" scope="col">Acreditacion: </th>
            
                        <th class="descripcionCAAC"><b>CAAC, Instancia que la otorga</b></th>
                        <th>
                        @if ($userType != '')
                            <button id="btn3_3" type="submit" class="btn custom-btn printButtonClass">Enviar
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
                                document.getElementById('score3_3').textContent = data.form3_3.score3_3 || '0';
                                document.getElementById('rc1').textContent = data.form3_3.rc1 || '0';
                                document.getElementById('rc2').textContent = data.form3_3.rc2 || '0';
                                document.getElementById('rc3').textContent = data.form3_3.rc3 || '0';
                                document.getElementById('rc4').textContent = data.form3_3.rc4 || '0';
                                document.getElementById('stotal1').textContent = data.form3_3.stotal1 || '0';
                                document.getElementById('stotal2').textContent = data.form3_3.stotal2 || '0';
                                document.getElementById('stotal3').textContent = data.form3_3.stotal3 || '0';
                                document.getElementById('stotal4').textContent = data.form3_3.stotal4 || '0';

                                // Populate hidden inputs
                                document.querySelector('input[name="user_id"]').value = data.form3_3.user_id || '';
                                document.querySelector('input[name="email"]').value = data.form3_3.email || '';
                                document.querySelector('input[name="user_type"]').value = data.form3_3.user_type || '';

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
                                if (data.form3_3) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';

                                    document.getElementById('score3_3').textContent = data.form3_3.score3_3 || '0';
                                    document.getElementById('rc1').textContent = data.form3_3.rc1 || '0';
                                    document.getElementById('rc2').textContent = data.form3_3.rc2 || '0';
                                    document.getElementById('rc3').textContent = data.form3_3.rc3 || '0';
                                    document.getElementById('rc4').textContent = data.form3_3.rc4 || '0';
                                    document.getElementById('stotal1').textContent = data.form3_3.stotal1 || '0';
                                    document.getElementById('stotal2').textContent = data.form3_3.stotal2 || '0';
                                    document.getElementById('stotal3').textContent = data.form3_3.stotal3 || '0';
                                    document.getElementById('stotal4').textContent = data.form3_3.stotal4 || '0';
                                    document.getElementById('comision3_3').textContent = data.form3_3.comision3_3 || '0';
                                    document.querySelector('span[name="comIncisoA"]').textContent = data.form3_3.comIncisoA || '0';
                                    document.querySelector('span[name="comIncisoB"]').textContent = data.form3_3.comIncisoB || '0';
                                    document.querySelector('span[name="comIncisoC"]').textContent = data.form3_3.comIncisoC || '0';
                                    document.querySelector('span[name="comIncisoD"]').textContent = data.form3_3.comIncisoD || '0';
                                    document.querySelector('span[name="obs3_3_1"]').textContent = data.form3_3.obs3_3_1 || '';
                                    document.querySelector('span[name="obs3_3_2"]').textContent = data.form3_3.obs3_3_2 || '';
                                    document.querySelector('span[name="obs3_3_3"]').textContent = data.form3_3.obs3_3_3 || '';
                                    document.querySelector('span[name="obs3_3_4"]').textContent = data.form3_3.obs3_3_4 || '';

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

                                    console.error('No form3_3 data found for the selected dictaminador.');
                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('score3_3').textContent ='0';
                                    document.getElementById('rc1').textContent = '0';
                                    document.getElementById('rc2').textContent = '0';
                                    document.getElementById('rc3').textContent =  '0';
                                    document.getElementById('rc4').textContent = '0';
                                    document.getElementById('stotal1').textContent = '0';
                                    document.getElementById('stotal2').textContent =  '0';
                                    document.getElementById('stotal3').textContent = '0';
                                    document.getElementById('stotal4').textContent = '0';
                                    document.getElementById('comision3_3').textContent = '0';
                                    document.querySelector('span[name="comIncisoA"]').textContent =  '0';
                                    document.querySelector('span[name="comIncisoB"]').textContent =  '0';
                                    document.querySelector('span[name="comIncisoC"]').textContent =  '0';
                                    document.querySelector('span[name="comIncisoD"]').textContent =  '0';
                                    document.querySelector('span[name="obs3_3_1"]').textContent = '';
                                    document.querySelector('span[name="obs3_3_2"]').textContent = '';
                                    document.querySelector('span[name="obs3_3_3"]').textContent = '';
                                    document.querySelector('span[name="obs3_3_4"]').textContent =  '';
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
            formData['rc1'] = document.getElementById('rc1').textContent;
            formData['comIncisoA'] = document.getElementById('comIncisoA').value; // Ensure input value is fetched
            formData['rc2'] = document.getElementById('rc2').textContent;
            formData['rc3'] = document.getElementById('rc3').textContent;
            formData['comIncisoB'] = document.getElementById('comIncisoB').value; // Ensure input value is fetched
            formData['rc4'] = document.getElementById('rc4').textContent;
            formData['stotal1'] = document.getElementById('stotal1').textContent;
            formData['comIncisoC'] = document.getElementById('comIncisoC').value; // Ensure input value is fetched
            formData['stotal2'] = document.getElementById('stotal2').textContent;
            formData['stotal3'] = document.getElementById('stotal3').textContent;
            formData['comIncisoD'] = document.getElementById('comIncisoD').value; // Ensure input value is fetched
            formData['stotal4'] = document.getElementById('stotal4').textContent;
            formData['comIncisoA'] = form.querySelector('input[id="comIncisoA"]').value;
            formData['comIncisoB'] = form.querySelector('input[id="comIncisoB"]').value;
            formData['comIncisoC'] = form.querySelector('input[id="comIncisoC"]').value;
            formData['comIncisoD'] = form.querySelector('input[id="comIncisoD"]').value;
            formData['score3_3'] = document.getElementById('score3_3').textContent;
            formData['comision3_3'] = document.getElementById('comision3_3').textContent;

            // Observations
            formData['obs3_3_1'] = form.querySelector('input[name="obs3_3_1"]').value;
            formData['obs3_3_2'] = form.querySelector('input[name="obs3_3_2"]').value;
            formData['obs3_3_3'] = form.querySelector('input[name="obs3_3_3"]').value;
            formData['obs3_3_4'] = form.querySelector('input[name="obs3_3_4"]').value;

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