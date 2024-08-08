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
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('docencia') }}">Actividades 3. Calidad
                                        en la
                                        docencia</a>
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
                            </nav>
                        </form>
                    </section>
                @endif
            @endif
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
                        <td><span id="hours">0</span></td>
                        <td class="puntajeEvaluar2"><label id="DSE" class="puntajeEvaluar" type="text"></label></td>
                        <td class="comision actv"><input id="comisionPosgrado" placeholder="0" type="number"
                                oninput="onActv2Comision()"></input></td>
                        <td><input id="obs2" name="obs2" class="table-header" type="text"></input></td>
                    </tr>
                    <tr>
                        <td><label for="">a) Posgrado</label> <label for="">Semestre</label></td>
                        <td><span id="horasPosgrado"></span></td>
                        <td class="puntajeEvaluar2"><label id="DSE2" class="puntajeEvaluar" type="text"></label></td>
                        <td class="comision actv"><input id="comisionLic" placeholder="0" type="number"
                                oninput="onActv2Comision()"></input></td>
                        <td><input id="obs2_2" name="obs2_2" class="table-header" type="text"></input></td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <tr>
                        <th style="font-weight: normal; text-size: 20px;" scope="col">Acreditación: </th>
                        <th style="width:60px;padding-left: 100px;">DSE/DIIP</th>
                        <th style="font-weight: normal; padding-left: 100px;">8.5 puntos por cada hora/semana/año en
                            cada caso</th>
                        <th><button type="submit" class="btn btn-primary" id="form2_2Button">Enviar</button></th>
                    </tr>
                </thead>
            </table>
        </form>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            
            // Step 3: Load data from localStorage into form fields
            const data = JSON.parse(localStorage.getItem('docenteData'));

            if (data) {
                // Update the spans with the data
                document.getElementById('hours').textContent = data.hours || '0';
                document.getElementById('horasPosgrado').textContent = data.horasPosgrado || '0';
                document.getElementById('horasSemestre').textContent = data.horasSemestre || '0';
                document.getElementById('dse').textContent = data.dse || '0';
                document.getElementById('dse2').textContent = data.dse2 || '0';

                // Optional: Populate hidden fields if necessary
                document.querySelector('input[name="user_id"]').value = data.user_id || '';
                document.querySelector('input[name="email"]').value = data.email || '';
            }
        });
    </script>
</body>

</html>