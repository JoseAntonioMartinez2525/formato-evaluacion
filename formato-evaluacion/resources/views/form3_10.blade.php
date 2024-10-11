@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Tutorías a estudiantes</title>
    <meta charset="utf-10">
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
        <!-- Form for Part 3_10 -->
        <form id="form3_10" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form310', 'form3_10');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <!--3.10 Trabajos dirigidos para la titulación de estudiantes-->
            <h4>Puntaje máximo
                <label class="bg-black text-white px-4 mt-3" for="">115</label>
            </h4>
            <table class="table table-sm tutorias">
                <thead>
                    <tr>
                        <th scope="col" colspan=3>Actividad</th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust" scope="col"></th>
                        <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                        <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                        </th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th id="seccion3_10" class="acreditacion" colspan=2>3.10 Tutorías a estudiantes</th>
                        <th class="acreditacion">Puntaje</th>
                        <th class="acreditacion">cantidad</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th id="score3_10">0</th>
                        <th id="comision3_10">0</th>
                        <th class="acreditacion" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <thead>
                        <tr>
                            <!--Tutorias a estudantes 3_10 individuales, grupales -->
                            <td>a)</td>
                            <td>Por alumno(a) por semestre, grupales</td>
                            <td id="puntajeGrupales"><b>3</b> </td>
                            <td id="grupalesCant"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id="evaluarGrupales"></td>
                            <td id="comisionGrupal">
                            @if ($userType == 'dictaminador')

                                <input type="value" id="comisionGrupal" name="comisionGrupal" oninput="onActv3Comision3_10()"
                                    value="{{ oldValueOrDefault('comisionGrupal') }}">                         
                            @else
                                <span id="comisionGrupal" name="comisionGrupal"></span>
                            @endif    
                            </td>
                            <td id="obsGrupal">
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsGrupal" name="obsGrupal">
                            @else
                            <span id="obsGrupal" name="obsGrupal"></span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>b)</td>
                            <td>Por alumno(a) por semestre, individuales</td>
                            <td id="puntajeIndividual"><b>6</b></td>
                            <td id="individualCant"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id="evaluarIndividual"></td>
                            <td id="comisionIndividual">
                            @if ($userType == 'dictaminador')
                                <input type="value" id="comisionIndividual" name="comisionIndividual" oninput="onActv3Comision3_10()"
                                        value="{{ oldValueOrDefault('comisionIndividual') }}"> 
                            @else
                                <span id="comisionIndividual"  name="comisionIndividual"></span>
                            @endif    
                            </td>
                            <td id="obsIndividual">
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsIndividual" name="obsIndividual">
                            @else
                            <span id="obsIndividual" name="obsIndividual"></span>
                            @endif
                            </td>
                        </tr>
                    </thead>
                    </tbody> 
                    </table>
                    <!--Tabla informativa Acreditacion Actividad 3.10-->
                    <table>
                        <thead>
                            <tr>
                                <th class="acreditacion" scope="col">Acreditacion: </th>

                                <th class="descripcion"><b>DDIE</b> </th>

                                <th>
                                    @if ($userType != '')
                                        <button id="btn3_10" type="submit" class="btn custom-btn printButtonClass">Enviar</button>
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
                                document.getElementById('score3_10').textContent = data.form3_10.score3_10 || '0';
                                document.getElementById('grupalesCant').textContent = data.form3_10.grupalesCant || '0';
                                document.getElementById('evaluarGrupales').textContent = data.form3_10.evaluarGrupales || '0';
                                document.getElementById('individualCant').textContent = data.form3_10.individualCant || '0';
                                document.getElementById('evaluarIndividual').textContent = data.form3_10.evaluarIndividual || '0';

                                // Populate hidden inputs
                                document.querySelector('input[name="user_id"]').value = data.form3_10.user_id || '';
                                document.querySelector('input[name="email"]').value = data.form3_10.email || '';
                                document.querySelector('input[name="user_type"]').value = data.form3_10.user_type || '';

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
                                if (data.form3_10) {
                                    document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';

                                    document.getElementById('grupalesCant').textContent = data.form3_10.grupalesCant || '0';
                                    document.getElementById('evaluarGrupales').textContent = data.form3_10.evaluarGrupales || '0';
                                    document.getElementById('individualCant').textContent = data.form3_10.individualCant || '0';
                                    document.getElementById('evaluarIndividual').textContent = data.form3_10.evaluarIndividual || '0';

                                    document.querySelector('span[name="comisionGrupal"]').textContent = data.form3_10.comisionGrupal || '0';
                                    document.querySelector('span[name="comisionIndividual"]').textContent = data.form3_10.comisionIndividual || '0';
                                    document.querySelector('span[name="obsGrupal"]').textContent = data.form3_10.obsGrupal || '';
                                    document.querySelector('span[name="obsIndividual"]').textContent = data.form3_10.obsIndividual || '';
                                    document.getElementById('score3_10').textContent = data.form3_10.score3_10 || '0';
                                    document.getElementById('comision3_10').textContent = data.form3_10.comision3_10 || '0';

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

                                    console.error('No form3_10 data found for the selected dictaminador.');
                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('grupalesCant').textContent = '0';
                                    document.getElementById('evaluarGrupales').textContent = '0';
                                    document.getElementById('individualCant').textContent = '0';
                                    document.getElementById('evaluarIndividual').textContent = '0';

                                    document.querySelector('span[name="comisionGrupal"]').textContent = '0';
                                    document.querySelector('span[name="comisionIndividual"]').textContent = '0';
                                    document.querySelector('span[name="obsGrupal"]').textContent = '';
                                    document.querySelector('span[name="obsIndividual"]').textContent = '';
                                    document.getElementById('score3_10').textContent = '0';
                                    document.getElementById('comision3_10').textContent = '0';


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
            formData['grupalesCant'] = document.getElementById('grupalesCant').textContent;
            formData['evaluarGrupales'] = document.getElementById('evaluarGrupales').textContent;
            formData['individualCant'] = document.getElementById('individualCant').textContent;
            formData['evaluarIndividual'] = document.getElementById('evaluarIndividual').textContent;
            formData['comisionGrupal'] = form.querySelector('input[id="comisionGrupal"]').value;
            formData['comisionIndividual'] = form.querySelector('input[id="comisionIndividual"]').value;
            formData['obsGrupal'] = document.querySelector('input[name="obsGrupal"]').textContent = '';
            formData['obsIndividual'] = document.querySelector('input[name="obsIndividual"]').textContent = '';
            formData['score3_10'] = document.getElementById('score3_10').textContent;
            formData['comision3_10'] = document.getElementById('comision3_10').textContent;


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