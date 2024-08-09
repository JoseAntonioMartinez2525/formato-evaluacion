@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Perfil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/resume.css') }}" rel="stylesheet">
    <script src="{{ asset('js/subtotales.js') }}"></script>
    <script src="{{ asset('js/comisiones.js') }}"></script>
    <script src="{{ asset('js/privileges.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body class="bg-gray-50 text-black/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        @if (Route::has('login'))
            @if (Auth::check())
                <section role="region" aria-label="Response form">
                    <form>
                        @csrf
                    <nav class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#"><i class="fa-solid fa-user"></i>{{ Auth::user()->email }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" style="width: 200px;" href="{{ route('rules') }}">Artículo 10 REGLAMENTO PEDPD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" style="width: 200px;" href="{{ route('docencia') }}">Actividades 3. Calidad en la
                                docencia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser llenado por la
                                Comisión del PEDPD)</a>
                        </li><br>
                        <li id="jsonDataLink" class="d-none">
                            <a class="nav-link active" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de los Usuarios</a>
                        </li>
                        <li id="reportLink" class="nav-item d-none">
                            <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar Reporte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" style="width: 200px;" href="{{ route('comision_dictaminadora') }}">Apartados 1 y 2</a>
                        </li>
                    </nav>
                    </form>
                </section>
            @endif
        @endif
    </div>
    <x-general-header />
    <div class="container mt-4">
        <label for="docenteSelect">Seleccionar Docente:</label>
        <select id="docenteSelect" class="form-select">
            <option value="">Seleccionar un docente</option>
            <!-- Aquí se llenarán los docentes con JavaScript -->
        </select>
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
                            <input type="number" id="comision1" name="comision1" class="table-header comision"
                                step="any">
                        </td>
                        <td>
                            <input id="obs1" name="obs1" class="table-header" type="text">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">Enviar</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const docenteSelect = document.getElementById('docenteSelect');

            // Step 1: Load the list of docentes
            const response = await fetch('/get-docentes'); // URL to fetch docentes, adjust as necessary
            const docentes = await response.json();

            docentes.forEach(docente => {
                const option = document.createElement('option');
                option.value = docente.email;
                option.textContent = docente.email;
                docenteSelect.appendChild(option);
            });

            // Manejar el cambio en la selección de docentes
            document.getElementById('docenteSelect').addEventListener('change', (event) => {
                const email = event.target.value;
                if (email) {
                    axios.get('/get-docente-data', { params: { email } })
                        .then(response => {
                            const data = response.data;
                            document.getElementById('horasActv2').textContent = data.form2.horasActv2 || '0';
                            document.getElementById('puntajeEvaluarText').textContent = data.form2.puntajeEvaluar || '0';
                            document.querySelector('input[name="user_id"]').value = data.form2.user_id || '';
                            document.querySelector('input[name="email"]').value = data.form2.email || '';
                        })
                        .catch(error => {
                            console.error('Error fetching docente data:', error);
                        });
                }

                

            });
        });


    async function submitForm(url, formId) {
        let formData = {};
        let form = document.getElementById(formId);

        if (!form) {
            console.error(`Form with id "${formId}" not found.`);
            return;
        }

        // Gather relevant information from the form
        formData['user_id'] = form.querySelector('input[name="user_id"]').value;
        formData['email'] = form.querySelector('input[name="email"]').value;
        formData['horasActv2'] = document.getElementById('horasActv2').textContent;
        formData['puntajeEvaluarText'] = document.getElementById('puntajeEvaluarText').textContent;
        formData['comision1'] = form.querySelector('input[name="comision1"]').value;
        formData['obs1'] = form.querySelector('input[name="obs1"]').value;

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
    </script>
</body>

</html>