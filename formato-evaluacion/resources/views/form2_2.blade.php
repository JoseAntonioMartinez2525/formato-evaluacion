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
    <meta name="csrf-token" content="">

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
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('rules') }}">Artículo 10 REGLAMENTO
                                        PEDPD</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('docencia') }}">Apartado 3</a>
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
        <!-- Form for Part 2_2 -->
        <form id="form2_2" method="POST" onsubmit="event.preventDefault(); submitForm('/store3', 'form2_2');">
            @csrf
            <div>
                <!-- Activity 2: Commitment in Teaching Performance -->
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4 mt-3" for="">200</label>
                </h4>
            </div>
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
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
                        <td id="actv2Comision" name="actv2Comision" for=""></td>
                        </tr>
                        <tr>
                            <td><label for="">a) Posgrado</label>
                                <label for="">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Semestre </label>
                            </td>
                            <td><span id="horasPosgrado" name="horasPosgrado" class="horasActv2"></span>
                            </td>
                            <td class="puntajeEvaluar2"><label id="DSE" name="dse" class="puntajeEvaluar" type="text"></label></td>
                            <td class="comision actv"><input id="comisionPosgrado" placeholder="0" for="" oninput="onActv2Comision()"></input>
                            </td>
                            <td><input id="obs2" name="obs2" class="table-header" type="text"></td>
                        </tr>
                        <tr>
                            <td>b) Licenciatura y TSU
                                <label for="">&nbsp &nbsp &nbsp &nbsp Horas </label>
                            </td>
                            <td><span id="horasSemestre" name="horasSemestre" class="horasActv2"></span>
                            </td>
                            <td class="puntajeEvaluar2"><label id="DSE2" name="dse2" class="puntajeEvaluar" type="text"></label></td>
                            <td class="comision actv"><span id="comisionLic"></span>
                            </td>
                            <td><input id="obs2_2" name="obs2_2" class="table-header" type="text"></input></td>
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
                                        <button type="submit" class="btn btn-primary" id="form2_2Button">Enviar</button>
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
                        const hoursElement = document.getElementById('hoursText');
                        if (hoursElement) {
                            hoursElement.textContent = data.hours || '0';
                        }

                        const horasPosgradoElement = document.getElementById('horasPosgrado');
                        if (horasPosgradoElement) {
                            horasPosgradoElement.textContent = data.horasPosgrado || '0';
                        }

                        const horasSemestreElement = document.getElementById('horasSemestre');
                        if (horasSemestreElement) {
                            horasSemestreElement.textContent = data.horasSemestre || '0';
                        }

                        const dseElement = document.getElementById('dse');
                        if (dseElement) {
                            dseElement.textContent = data.dse || '0';
                        }

                        const dse2Element = document.getElementById('dse2');
                        if (dse2Element) {
                            dse2Element.textContent = data.dse2 || '0';
                        }

                        // Optional: Populate hidden fields if necessary
                        document.querySelector('input[name="user_id"]').value = data.user_id || '';
                        document.querySelector('input[name="email"]').value = data.email || '';

                        console.log('hoursElement:', hoursElement);
                        console.log('horasPosgradoElement:', horasPosgradoElement);
                        console.log('horasSemestreElement:', horasSemestreElement);
                        console.log('dseElement:', dseElement);
                        console.log('dse2Element:', dse2Element);
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
        formData['hours'] = document.getElementById('hoursText').textContent;
        formData['horasPosgrado'] = document.getElementById('horasPosgrado').textContent;
        formData['horasSemestre'] = document.getElementById('horasSemestre').textContent;
        formData['dse'] = document.getElementById('dse').textContent;
        formData['dse2'] = document.getElementById('dse2').textContent;
        formData['comisionPosgrado'] = form.querySelector('input[name="comisionPosgrado"]').value;
        formData['comisionLic'] = form.querySelector('input[name="comisionLic"]').value;
        formData['actv2Comision'] = form.querySelector('input[name="actv2Comision"]').value;
        formData['obs2'] = form.querySelector('input[name="obs2"]').value;
        formData['obs2_2'] = form.querySelector('input[name="obs2_2"]').value;

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
    </script>
</body>

</html>