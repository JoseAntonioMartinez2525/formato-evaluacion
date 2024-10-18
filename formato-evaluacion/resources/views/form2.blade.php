@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Permanencia en las actividades de la docencia</title>
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
                    <form>
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
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('rules') }}">Artículo 10 REGLAMENTO PEDPD</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser llenado por la
                                Comisión del PEDPD)</a>
                        </li><br>
                        <li id="jsonDataLink" class="d-none">
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de los Usuarios</a>
                        </li>
                        <li id="reportLink" class="nav-item d-none">
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('perfil') }}">Mostrar Reporte</a>
                        </li>
                        <li class="nav-item">
                        @if(Auth::user()->user_type === 'dictaminador')
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                        @else
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('secretaria') }}">Selección de Formatos </a>
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

<div class="container mt-4">
    @if($userType !== 'docente')
        <!-- Select para dictaminador seleccionando docentes -->
        <label for="docenteSelect">Seleccionar Docente:</label>
        <select id="docenteSelect" class="form-select"> <!--name="docentes[]" multiple-->
            <option value="">Seleccionar un docente</option>
            <!-- Aquí se llenarán los docentes con JavaScript -->
        </select>
        <!--
    @elseif($userType == '')
        Select para usuario con user_type vacío seleccionando dictaminadores 
        <label for="dictaminadorSelect">Seleccionar Dictaminador:</label>
        <select id="dictaminadorSelect" class="form-select">
            <option value="">Seleccionar un dictaminador</option>
            Aquí se llenarán los dictaminadores con JavaScript 
        </select>
    @else
        Select por defecto para otros usuarios seleccionando docentes 
        <label for="docenteSelect">Seleccionar Docente:</label>
        <select id="docenteSelect" class="form-select">
            <option value="">Seleccionar un docente</option>
            Aquí se llenarán los docentes con JavaScript 
        </select> -->
    @endif
</div>


    <main class="container">
        <!-- Form for Part 2 -->
        <form id="form2" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form2', 'form2');">
            @csrf
            <div>
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4" for="">100</label>
                </h4>
            </div>
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <input type="hidden" id="puntajeEvaluarInput" name="puntajeEvaluar" value="0">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Actividad</th>
                        <th class="table-ajust" scope="col">Años</th>
                        <th class="table-ajust" scope="col">Puntaje a evaluar</th>
                        <th class="table-ajust" scope="col">Puntaje de la Comisión Dictaminadora</th>
                        <th class="table-ajust" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="margin-right: auto;"><b>1. Permanencia en las actividades de la docencia</b></td>
                        <td class="horasActv2">
                            <span id="horasActv2"></span>
                        </td>
                        <td class="puntajeEvaluar">
                            <span id="puntajeEvaluarText">0</span>
                        </td>
                        <td class="table-header comision">
                            <div class="filled">
                        @if($userType == 'dictaminador')
                            <!-- Mostrar input si es 'dictaminador' -->
                            <input type="number" id="comision1" name="comision1" class="table-header comision" step="any"
                            value="{{ oldValueOrDefault('comision1') }}">
                        @else
                            <!-- Mostrar span si es otro tipo de usuario -->
                            <span id="comision1" class="table-header comision"></span>
                        @endif
                             </div>
                        </td>
                        <td>
                            <div class="filled">
                        @if($userType == 'dictaminador')
                            <!-- Mostrar input si es 'dictaminador' -->
                            <input id="obs1" name="obs1" class="table-header" type="text">
                        @else
                            <!-- Mostrar span si es otro tipo de usuario -->
                            <span id="obs1" class="table-header"></span>
                        @endif
                            </div>
                        </td>
                        <td>@if($userType != '')
                            <button type="submit" class="btn custom-btn printButtonClass">Enviar</button>
                        @else
                            <span></span>
                        @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <tr>
                        <th style="font-weight: normal; text-size: 20px;" scope="col">Acreditación: </th>
                        <th style="width:60px;padding-left: 100px;">SG</th>
                        <th style="font-weight: normal; padding-left: 100px;">6.25 puntos por cada año de experiencia
                            docente cumplido. A partir de los 16 años de experiencia docente se otorgarán los 100 puntos
                        </th>
                    </tr>
                </thead>
            </table>
        </form>
    </main>
    <center><footer id="convocatoria">
    <!-- Mostrar convocatoria -->
@if(isset($convocatoria))

    <div style="margin-right: -700px;">
        <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
    </div>
@endif
</footer></center>

    <script>
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
                                    document.getElementById('horasActv2').textContent = data.form2.horasActv2 || '0';
                                    document.getElementById('puntajeEvaluarText').textContent = data.form2.puntajeEvaluar || '0';
                                    document.querySelector('input[name="user_id"]').value = data.form2.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.form2.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.form2.user_type || '';

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
                                })
                                .catch(error => {
                                    console.error('Error fetching docente data:', error);
                                });
                            await asignarDocentes(user_identity, email);
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
                            // Lógica para obtener datos de DictaminatorsResponseForm2
                            try {
                                const response = await fetch('/get-dictaminators-responses');
                                const dictaminatorResponses = await response.json();
                                // Filtrar la entrada correspondiente al email seleccionado
                                const selectedResponse = dictaminatorResponses.find(res => res.email === email);
                                if (selectedResponse) {
                                    // Si se encuentra la respuesta correspondiente, asigna sus valores a los campos
                                    document.getElementById('horasActv2').textContent = selectedResponse.horasActv2 || '0';
                                    document.getElementById('puntajeEvaluarText').textContent = selectedResponse.puntajeEvaluar || '0';
                                    document.querySelector('input[name="user_id"]').value = selectedResponse.user_id || '';
                                    document.querySelector('input[name="email"]').value = selectedResponse.email || '';
                                    document.querySelector('input[name="user_type"]').value = selectedResponse.user_type || '';
                                    document.querySelector('span[id="comision1"]').textContent = selectedResponse.comision1 || '';
                                    document.querySelector('span[id="obs1"]').textContent = selectedResponse.obs1 || '';
                                } else {
                                    // Si no se encuentra ningún dato, puedes limpiar los campos o mostrar un mensaje
                                    console.log('No se encontraron respuestas para este email.');
                                    document.getElementById('horasActv2').textContent = '0';
                                    document.getElementById('puntajeEvaluarText').textContent = '0';
                                    document.querySelector('span[id="comision1"]').textContent = '';
                                    document.querySelector('span[id="obs1"]').textContent = '';
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
            
/*
            if (dictaminadorSelect && userType === '') {
                try {
                    const response = await fetch('/get-dictaminadores');
                    const dictaminadores = await response.json();

                    dictaminadores.forEach(dictaminador => {
                        const option = document.createElement('option');
                        option.value = dictaminador.id;  // Use dictaminador ID as the value
                        option.dataset.email = dictaminador.email; // Store email in data attribute
                        option.textContent = dictaminador.email;
                        dictaminadorSelect.appendChild(option);
                    });

                    dictaminadorSelect.addEventListener('change', async (event) => {
                        const dictaminadorId = event.target.value;
                        const email = event.target.options[event.target.selectedIndex].dataset.email;  // Get email from selected option
                        if (dictaminadorId) {
                            try {
                                console.log('Email:', email);
                                console.log('Dictaminador ID:', dictaminadorId);
                                const response = await axios.get('/get-dictaminador-data', {
                                    params: { email: email, dictaminador_id: dictaminadorId }  // Send both ID and email
                                });
                                const data = response.data;
                                if (data.form2) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';
                                    document.querySelector('span[id="horasActv2"]').textContent = data.form2.horasActv2 || '0';
                                    document.querySelector('span[id="puntajeEvaluarText"]').textContent = data.form2.puntajeEvaluar || '0';
                                    document.querySelector('span[id="comision1"]').textContent = data.form2.comision1 || '';
                                    document.querySelector('span[id="obs1"]').textContent = data.form2.obs1 || '';
                                     
                                    

                                   */ 

                                    /*
                                    
                                } else {
                                    console.log('No form2 data found for the selected dictaminador.');
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';
                                    document.querySelector('span[id="horasActv2"]').textContent = '0';
                                    document.querySelector('span[id="puntajeEvaluarText"]').textContent = '0';
                                    document.querySelector('span[id="comision1"]').textContent = '';
                                    document.querySelector('span[id="obs1"]').textContent = '';
                                                                // Actualizar convocatoria
                                    document.getElementById('convocatoria').textContent = data.responseForm1.convocatoria = '';
                                }
                            } catch (error) {
                                console.error('Error fetching dictaminador data:', error);
                            }
                        }
                        if(userType === ''){
                                if (dictaminadorId) {
                                // Limpiar el select de docentes
                                docenteSelect.innerHTML = '<option value="">Seleccionar un docente</option>';

                                try {
                                    const response = await fetch(`/get-docentes-by-dictaminador?dictaminador_id=${dictaminadorId}`);
                                    const docentes = await response.json();

                                    docentes.forEach(docente => {
                                        const option = document.createElement('option');
                                        option.value = docente.email;
                                        option.textContent = docente.email;
                                        docenteSelect.appendChild(option);
                                    });

                                    // Ahora puedes manejar el cambio del select de docentes
                                    docenteSelect.addEventListener('change', (event) => {
                                        const email = event.target.value;
                                        if (email) {
                                            // Aquí puedes manejar el fetch para obtener los datos del docente seleccionado
                                            axios.get('/get-docente-data', { params: { email } })
                                                .then(response => {
                                                    const data = response.data;
                                                    // Rellena los campos con los datos del docente
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching docente data:', error);
                                                });
                                        }
                                    });
                                } catch (error) {
                                    console.error('Error fetching docentes:', error);
                                }
                            } 
                        }
                    });
                } catch (error) {
                    console.error('Error fetching dictaminadores:', error);
                    alert('No se pudo cargar la lista de dictaminadores.');
                }
            }
*/
        // Ejemplo de cómo enviar datos dinámicamente usando fetch
        /*
        async function asignarDocentes(dictaminadorId, docenteEmail) {
            try {
                const response = await fetch(`/asignar-docentes/${dictaminadorId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ docentes: docenteEmail })
                });
                const data = await response.json();
                console.log('Docentes asignados correctamente:', data);
            } catch (error) {
                console.error('Error asignando docentes:', error);
            }
        }
        
        async function agregarDocente(dictaminadorId, docenteEmail) {
            try {
                const response = await fetch(`/agregar-docente/${dictaminadorId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ docente_email: docenteEmail })
                });
                const data = await response.json();
                console.log('Docente agregado correctamente:', data);
            } catch (error) {
                console.error('Error agregando docente:', error);
            }
        }
             */
        });

        async function submitForm(url, formId) {
            const user_identity = @json($user_identity); 
            let formData = {};
            let form = document.getElementById(formId);

            if (!form) {
                console.error(`Form with id "${formId}" not found.`);
                return;
            }

            formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
            formData['user_id'] = form.querySelector('input[name="user_id"]').value;
            formData['email'] = form.querySelector('input[name="email"]').value;
            formData['horasActv2'] = document.getElementById('horasActv2').textContent;
            formData['puntajeEvaluar'] = document.getElementById('puntajeEvaluarText').textContent;
            formData['comision1'] = form.querySelector('input[name="comision1"]').value;
            formData['obs1'] = form.querySelector('input[name="obs1"]').value;
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;

            console.log('Form data:', formData);

            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });

                const text = await response.text();
                console.log('Status Code:', response.status);
                console.log('Raw response:', text);

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                let responseData = JSON.parse(text);
                console.log('Response received from server:', responseData);
                 await agregarDocentes(user_identity, formData['email']);
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form2 = document.getElementById('form2');
            if (form2) {
                form2.onsubmit = function (event) {
                    event.preventDefault();
                    submitForm('/store-form2', 'form2');
                    
                };
            }
        });





    </script>
</body>


</html>