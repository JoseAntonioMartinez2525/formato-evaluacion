@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Dedicación en el Desempeño docente</title>
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
                            <nav class="nav flex-column printButtonClass menu">
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
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('rules') }}">Artículo 10 REGLAMENTO
                                        PEDPD</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser llenado
                                        por la
                                        Comisión del PEDPD)</a>
                                </li><br>
                                <li id="jsonDataLink" class="d-none">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de los
                                        Usuarios</a>
                                </li>
                                <li id="reportLink" class="nav-item d-none">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar Reporte</a>
                                </li>
                                <li class="nav-item">
                                @if(Auth::user()->user_type === 'dictaminador')
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                                @else
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('secretaria') }}">Selección de Formatos</a>
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
        <!-- Form for Part 2_2 -->
        <form id="form2_2" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form22', 'form2_2');">
            @csrf
            <div>
                <!-- Activity 2: Commitment in Teaching Performance -->
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4 mt-3" for="">200</label>
                </h4>
            </div>
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Actividad</th>
                        <th class="table-ajust" scope="col">Horas</th>
                        <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                        <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                        <th class="table-ajust" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>2. Dedicación en el Desempeño docente</b></td>
                        <td for=""></td>
                        <td id="hours" name="hours" for=""><label id="hoursText" for="">0</label></td>
                        <td id="actv2Comision" for=""></td>
                        </tr>
                        <tr>
                            <td><label for="">a) Posgrado</label>
                                <label for="">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Semestre </label>
                            </td>
                            <td class="cantidad"><span id="horasPosgrado" name="horasPosgrado" class="horasActv2"></span>
                            </td>
                            <td class="puntajeEvaluar2"><label id="dse" name="dse" class="puntajeEvaluar" type="text"></label></td>
                             @if($userType == 'dictaminador')
                                    <td class="comision actv filled">
                                        <input type="number" id="comisionPosgrado" name="comisionPosgrado" for="" oninput="onActv2Comision()"
                                        value="{{ oldValueOrDefault('comisionPosgrado') }}">
                                    </input>
                                    </td>
                                <td class="filled"><input id="obs2" name="obs2" class="table-header" type="text"></td>

                            @else
                                <td class="comision actv"><span id="comisionPosgrado" name="comisionPosgrado"></span></td>
                                <td><span id="obs2" name="obs2" class="table-header"></span></td>

                            @endif

                        </tr>
                        <tr>
                            <td>b) Licenciatura y TSU
                                <label for="">&nbsp &nbsp &nbsp &nbsp Horas </label>
                            </td>
                            <td class="cantidad"><span id="horasSemestre" name="horasSemestre" class="horasActv2"></span>
                            </td>
                            <td class="puntajeEvaluar2"><label id="dse2" name="dse2" class="puntajeEvaluar" type="text"></label></td>
                            @if($userType == 'dictaminador')
                                <td class="comision actv"><input  type="number" id="comisionLic" name="comisionLic" oninput="onActv2Comision()" 
                                value="{{ oldValueOrDefault('comisionLic') }}"></input>
                                </td>
                                <td><input id="obs2_2" name="obs2_2" class="table-header" type="text"></input></td>
                            @else
                            <td class="comision actv"><span id="comisionLic" name="comisionLic"></span>
                            </td>
                            <td><span id="obs2_2" name="obs2_2" class="table-header"></span></td>
                            @endif
                        </tr>
                        </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <th style="font-weight: normal; text-size: 20px;" scope="col">Acreditacion: </th>
                                    <th style="width:60px;padding-left: 100px;">DSE/DIIP</th>
                                    <th style="font-weight: normal; padding-left: 100px;">8.5 puntos por cada hora/semana/año en cada
                                        caso
                                    </th>
                                    <th>
                                        @if($userType != '')
                                            <button type="submit" class="btn custom-btn printButtonClass" id="form2_2Button">Enviar</button>
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

                            <div style="margin-right: -200px;">
                                <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
                            </div>
                        @endif
                    </footer>
                </center>
    <script>
       document.addEventListener('DOMContentLoaded', async () => {
            const userType = @json($userType);  // Inject user type from backend to JS

            const docenteSelect = document.getElementById('docenteSelect');
            const dictaminadorSelect = document.getElementById('dictaminadorSelect');

            if (docenteSelect && userType == 'dictaminador') {
                try {
                    const response = await fetch('/get-docentes');
                    const docentes = await response.json();

                    docentes.forEach(docente => {
                        const option = document.createElement('option');
                        option.value = docente.email;
                        option.textContent = docente.email;
                        docenteSelect.appendChild(option);
                    });

                    docenteSelect.addEventListener('change', (event) => {
                        const email = event.target.value;
                        if (email) {
                            axios.get('/get-docente-data', { params: { email } })
                                .then(response => {
                                    const data = response.data;
                                    document.getElementById('hoursText').textContent = data.form2_2.hours || '0';
                                    document.getElementById('horasPosgrado').textContent = data.form2_2.horasPosgrado || '0';
                                    document.getElementById('horasSemestre').textContent = data.form2_2.horasSemestre || '0';
                                    document.getElementById('dse').textContent = data.form2_2.dse || '0';
                                    document.getElementById('dse2').textContent = data.form2_2.dse2 || '0';
                                    document.querySelector('input[name="user_id"]').value = data.form2_2.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.form2_2.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.form2_2.user_type || '';

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

            if (dictaminadorSelect && userType == '') {
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
                                if (data.form2_2) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '0';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';
                                    document.querySelector('label[id="hoursText"]').textContent = data.form2_2.hours || '';
                                    document.querySelector('span[id="horasPosgrado"]').textContent = data.form2_2.horasPosgrado || '';
                                    document.querySelector('span[id="horasSemestre"]').textContent = data.form2_2.horasSemestre || '';
                                    document.querySelector('label[id="dse"]').textContent = data.form2_2.dse || '';
                                    document.querySelector('label[id="dse2"]').textContent = data.form2_2.dse2 || '';
                                    document.querySelector('span[id="comisionPosgrado"]').textContent = data.form2_2.comisionPosgrado || '';
                                    document.querySelector('span[id="comisionLic"]').textContent = data.form2_2.comisionLic || '';
                                    document.querySelector('td[id="actv2Comision"]').textContent = data.form2_2.actv2Comision || '';
                                    document.querySelector('span[id="obs2"]').textContent = data.form2_2.obs2 || '';
                                    document.querySelector('span[id="obs2_2"]').textContent = data.form2_2.obs2_2 || '';

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

                                    console.log('No form2_2 data found for the selected dictaminador.');

                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';
                                    document.querySelector('label[id="hoursText"]').textContent = '0';
                                    document.querySelector('span[id="horasPosgrado"]').textContent = '';
                                    document.querySelector('span[id="horasSemestre"]').textContent = '';
                                    document.querySelector('label[id="dse"]').textContent = '';
                                    document.querySelector('label[id="dse2"]').textContent = '';
                                    document.querySelector('span[id="comisionPosgrado"]').textContent = '';
                                    document.querySelector('span[id="comisionLic"]').textContent = '';
                                    document.querySelector('td[id="actv2Comision"]').textContent = '';
                                    document.querySelector('span[id="obs2"]').textContent = '';
                                    document.querySelector('span[id="obs2_2"]').textContent = '';
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


    async function submitForm(url, formId) {
        let formData = {};
        let form = document.getElementById(formId);

        if (!form) {
            console.error(`Form with id "${formId}" not found.`);
            return;
        }

        // Gather relevant information from the form
        formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
        formData['user_id'] = form.querySelector('input[name="user_id"]').value;
        formData['email'] = form.querySelector('input[name="email"]').value;
        formData['hours'] = document.getElementById('hoursText').textContent;
        formData['horasPosgrado'] = document.getElementById('horasPosgrado').textContent;
        formData['horasSemestre'] = document.getElementById('horasSemestre').textContent;
        formData['dse'] = document.getElementById('dse').textContent;
        formData['dse2'] = document.getElementById('dse2').textContent;
        formData['comisionPosgrado'] = form.querySelector('input[name="comisionPosgrado"]').value;
        formData['comisionLic'] = form.querySelector('input[name="comisionLic"]').value;
        formData['actv2Comision'] = document.getElementById('actv2Comision').textContent;
        formData['obs2'] = form.querySelector('input[name="obs2"]').value;
        formData['obs2_2'] = form.querySelector('input[name="obs2_2"]').value;
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

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            let responseData = await response.json();
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