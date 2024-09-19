    @php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Resumen de la PEDPD(solo firmas)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<x-head-resources />
<link href="{{ asset('css/resume.css') }}" rel="stylesheet">
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

    @if($userType != 'docente')
        <!-- Select para usuario con user_type vacío seleccionando dictaminadores -->
        <label for="dictaminadorSelect">Seleccionar Dictaminador:</label>
        <select id="dictaminadorSelect" class="form-select">
            <option value="">Seleccionar un dictaminador</option>
            <!-- Aquí se llenarán los dictaminadores con JavaScript -->
        </select>
    @endif
</div>
                    <br><br><br><br>               
                  <main class="container">
                        <form id="form5" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); submitForm('/store-evaluator-signature', 'form5');">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="user_type" value="{{Auth()->user()->user_type}}">
                            <table>
                            <thead>
                                <tr>
                                    <th><input class="personaEvaluadora1" type="text" id="personaEvaluadora1"></th>
                                    <th>
                                        <input type="file" class="form-control" id="firma1" name="firma1" accept="image/*" style="margin-left: -400px;">
                                    </th>
                                </tr>
                                <tr>
                                    <td class="p-2">Nombre de la persona evaluadora</td>
                                    <td class="p-2"><span id="firmaTexto">Firma</span> 
                                <small class="text-muted">Tamaño máximo permitido: 2MB</small></td>


                                </tr>
                                <tr>
                                    <th><input class="personaEvaluadora2" type="text" id="personaEvaluadora2"></th>
                                    <th>
                                        <input type="file" class="form-control" id="firma2" name="firma2" accept="image/*" style="margin-left: -400px;">
                                    </th>
                                </tr>
                                <tr>
                                    <td class="p-2">Nombre de la persona evaluadora</td>
                                    <td class="p-2"><span id="firmaTexto2">Firma</span> 
                                <small class="text-muted">Tamaño máximo permitido: 2MB</small></td>


                                </tr>
                                <tr>
                                    <th><input class="personaEvaluadora3" type="text" id="personaEvaluadora3"></th>
                                    <th>
                                        <input type="file" class="form-control" id="firma3" name="firma3" accept="image/*" style="margin-left: -400px;">
                                    </th>

                                </tr>
                                <tr>
                                    <td class="p-2 mr-2">Nombre de la persona evaluadora</td>
                                    <td class="p-2"><span id="firmaTexto3">Firma</span>
                                <small class="text-muted">Tamaño máximo permitido: 2MB</small></td>


                                </tr>

                            </thead>
                            <thead>
                                <tr>
                                    <td style="padding-left: 650px;"><button type="submit" class="btn custom-btn buttonSignature2">Enviar</button></td>   
                                </tr>

                            </thead>
                            </table>
                        </form>
                        <br>
        </body>
<script>

    const dictaminadorSelect = document.getElementById('dictaminadorSelect');
 // Fetch dictaminador options if user type is null or empty
    if (dictaminadorSelect && userType != 'docente') {
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
            })}catch (error) {
            console.error('Error fetching dictaminador data:', error);
            }
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
            nav.style.transition = 'display 0.5s ease';
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


    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        async function submitForm(url, formId) {
            // Get form data
            let form = document.getElementById(formId);
            let formData = new FormData(form);
            formData.append('formId', formId);

            // Recoge los datos dependiendo del formulario actual
            if (formId === 'form5') {
                formData.set('user_id', form.querySelector('input[name="user_id"]').value);
                formData.set('email', form.querySelector('input[name="email"]').value);
                formData.set('dictaminador_id', form.querySelector('input[name="dictaminador_id"]').value);
                formData.set('user_type', form.querySelector('input[name="user_type"]').value);
                console.log('user_type value: ', formData['user_type']);

                // evaluator names
                let evaluatorName1 = form.querySelector('#personaEvaluadora1').value;
                let evaluatorName2 = form.querySelector('#personaEvaluadora2').value;
                let evaluatorName3 = form.querySelector('#personaEvaluadora3').value;

                formData.set('evaluator_name_1', evaluatorName1);
                formData.set('evaluator_name_2', evaluatorName2);
                formData.set('evaluator_name_3', evaluatorName3);

                // Add files to formData
                let firma1 = form.querySelector('#firma1');
                if (firma1.files.length > 0) {
                    formData.append('firma1', firma1.files[0]);
                }

                let firma2 = form.querySelector('#firma2');
                if (firma2.files.length > 0) {
                    formData.append('firma2', firma2.files[0]);
                }

                let firma3 = form.querySelector('#firma3');
                if (firma3.files.length > 0) {
                    formData.append('firma3', firma3.files[0]);
                }
            }
            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData,
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

                if (formId === 'form5') {
                    document.getElementById('reportLink').classList.remove('d-none');
                }

                if (data.signature_url) {
                    const img = document.createElement('img');
                    img.src = data.signature_url;
                    img.alt = 'Signature';
                    img.style.maxWidth = '400px';
                    img.style.maxHeight = '400px';
                    img.style.marginLeft = '1000px';
                    img.style.marginTop = '-150px';
                    document.body.appendChild(img);
                }
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        window.submitForm = submitForm;
    });



    document.addEventListener('DOMContentLoaded', function () {
        const userId = {{ auth()->user()->id }};

    async function fetchData(url, params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const fullUrl = `${url}?${queryString}`;

        try {
            let response = await fetch(fullUrl, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            });


            let data = await response.json();
            return data;
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error.message);
            alert(error.message);
        }
    }

    async function loadAllData() {
        let data = await fetchData('/get-form-data', { dictaminador_id: userId });

        if (data && data.dictaminador.dictaminador_id) {
            // Asignar los valores de las comisiones automáticamente
            if (data.form_data) {
                Object.keys(data.form_data).forEach(formKey => {
                    const form = data.form_data[formKey];
                    const comisionField = formKey.replace('DictaminatorsResponse', '').toLowerCase() + 'Comision';
                    if (form && document.getElementById(comisionField)) {
                        document.getElementById(comisionField).textContent = form.comision || '0';
                    }
                });

                // Calcular el puntaje total
                calculateTotalScore();
            }
        } else {
            console.error('Error: Dictaminador not found or user type is invalid.');
        }
    }


    function calculateTotalScore() {
        let comisionTotal = 0;
        for (let i = 2; i <= 19; i++) {
            let comision = parseFloat(document.getElementById(`comision3_${i}`).textContent) || 0;
            comisionTotal += comision;
        }

        document.getElementById('comision3Total').innerText = comisionTotal;
        total();
        document.getElementById('totalComisionRepetido').innerText = total();
        document.getElementById('totalComision').innerText = total();
        condicionales();
    }

    loadAllData();
    });


    function min700(...values) {
        const total = values.reduce((acc, val) => acc + val, 0);
        return Math.min(total, 700);
    }

    function total() {
        const comision1 = parseFloat(document.getElementById('comision1Total').textContent) || 0;
        const comision2 = parseFloat(document.getElementById('comision2Total').textContent) || 0;
        const comision3 = parseFloat(document.getElementById('comision3Total').textContent) || 0;

        let suma = comision1 + comision2 + comision3;
        return Math.min(suma, 700);
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
            document.getElementById('reportLink').classList.remove('d-none');
        }
    });

    document.addEventListener('DOMContentLoaded', async () => {


        // Current user type from the backend
        const userType = @json($userType);  // Get user type from backend

        // Fetch dictaminador options if user type is null or empty

            try {
                const response = await fetch('/get-dictaminadores');
                const dictaminadores = await response.json();
                const dictaminadorId = event.target.value;


                if (dictaminadorId) {
                    try {
                        const response = await axios.get('/get-dictaminador-data', {
                            params: { email: email, dictaminador_id: dictaminadorId }  // Send both ID and email
                        });
                        const data = response.data;

                        document.getElementById('comision1').textContent = data.form2.comision1 || '0';
                        document.getElementById('actv2Comision').textContent = data.form2_2.actv2Comision || '0';
                        document.getElementById('actv3Comision').textContent = data.form3_1.actv3Comision || '0';

                        // Populate fields with fetched data
                        for (let i = 2; i <= 19; i++) {
                            const elementId = 'comision3_' + i;
                            const formId = 'form3_' + i;

                            const scoreValue = data[formId]['comision3_' + i] || '0';

                            document.getElementById(elementId).textContent = scoreValue;
                        }

                        console.error('No form data found for the selected dictaminador.');

                        // Reset input values if no data found
                        document.querySelector('input[name="dictaminador_id"]').value = '0';
                        document.querySelector('input[name="user_id"]').value = '0';
                        document.querySelector('input[name="email"]').value = '';
                        document.querySelector('input[name="user_type"]').value = '';


                    } catch (error) {
                        console.error('Error fetching dictaminador data:', error);
                    }
                }

            } catch (error) {
                console.error('Error fetching dictaminadores:', error);

            }
        
    });

    function minWithSum(value1, value2) {
        const sum = value1 + value2;
        return Math.min(sum, 200);


    }

</script>
</html>