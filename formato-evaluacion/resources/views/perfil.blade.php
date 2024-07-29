@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="{{ $newLocale }}">

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

<body>
<div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            @if (Route::has('login'))
                                                @if (Auth::check())
                                                    <section role="region" aria-label="Response form">
                                                        <form>
                                                            @csrf
                                                            <nav class="nav flex-column">
                                                                <li class="nav-item">
                                                                    <a class="nav-link disabled" href="#"><i
                                                                            class="fa-solid fa-user"></i>{{ Auth::user()->email }}</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" style="width: 200px;" href="{{route('welcome')}}">Formato Evaluación, apartados 1 y 2</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" style="width: 200px;" href="{{route('rules')}}">Artículo 10
                                                                        REGLAMENTO
                                                                        PEDPD</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" style="width: 200px;" href="{{route('docencia')}}">Actividades 3.
                                                                        Calidad en la docencia</a>
                                                                </li><br>
                                                                <li id="jsonDataLink" class="d-none">
                                                                    <a class="nav-link active" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de los Usuarios</a>
                                                                </li>
                                                                <li>
                                                                     <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar Reporte</a>

                                                                </li>

                                                            </nav>
                                                </form>@endif
                                                </section>

                                                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                                                    <div class="flex lg:justify-center lg:col-start-2"></div>
                                                    <nav class="-mx-3 flex flex-1 justify-end"></nav>
                                                </header>
                <form id="form6" method="GET" enctype="multipart/form-data"
                    onsubmit="event.preventDefault(); submitForm('/show-profile', 'form6');">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <h1>Reporte del Perfil de Usuario</h1>

                        <p>Email: 
                            <span id="email"></span>
                        </p>
                        <p>Usuario:
                            <span id="user"></span>
                        </p>
                        <p>Convocatoria:
                            <span id="convocatoria"></span>
                        </p>
                        <p>Comisión Actividad 1 Total: 
                            <span id="comision_actividad_1_total"></span>
                        </p>
                        <p>Comisión Actividad 2 Total: 
                            <span id="comision_actividad_2_total"></span>
                        </p>
                        <p>Comisión Actividad 3 Total: 
                            <span id="comision_actividad_3_total"></span>
                        </p>
                        <p>Total Puntaje: 
                            <span id="total_puntaje"></span>
                        </p>
                        <p>Mínima Calidad: 
                            <span id="minima_calidad"></span>
                        </p>
                        <p>Mínima Total: 
                            <span id="minima_total"></span>
                        </p>


                    <h1>Personas Evaluadoras y Firmas</h1>

                        <table>
                            <thead>
                                <tr>
                                <td>Nombre de la Persona Evaluadora:  <span id="evaluator_name_1"></span></td>    
                                <td><img id="signature_path_1" alt="Signature" style="max-width: 500px;"></td>
                            </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <td>Nombre de la Persona Evaluadora: <span id="evaluator_name_2"></span></td>
                                    <td><img id="signature_path_2" alt="Signature" style="max-width: 500px;"></td>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <td>Nombre de la Persona Evaluadora: <span id="evaluator_name_3"></span></td>
                                    <td><img id="signature_path_3" alt="Signature" style="max-width: 500px;"></td>
                                </tr>
                            </thead>

                        </table>
                        </form>
            @endif
</body>
<script>
             document.addEventListener('DOMContentLoaded', function () {
                    const userId = {{ auth()->user()->id }}; // Assuming you have user data

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

                        console.log('Response from API:', response);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        let data = await response.json();
                        return data;
                    } catch (error) {
                        console.error('There was a problem with the fetch operation:', error);
                    }
                }
        async function loadAllData() {

            const userId = {{ auth()->user()->id }};
            const userEmail = "{{ auth()->user()->email }}";
            
            let dataResume = await fetchData('/get-data-resume', { user_id: userId });
            let dataSignature = await fetchData('/get-evaluator-signature', { user_id: userId , email: userEmail });
            let dataUser = await fetchData('/get-data1', { user_id: userId });

            // Populate labels with the retrieved data
            document.getElementById('email').innerText = dataResume ? dataResume.email : '';
            document.getElementById('user').innerText = dataUser ? dataUser.nombre : '';
            document.getElementById('convocatoria').innerText = dataUser ? dataUser.convocatoria : '';
            document.getElementById('comision_actividad_1_total').innerText = dataResume ? dataResume.comision_actividad_1_total : '';
            document.getElementById('comision_actividad_2_total').innerText = dataResume ? dataResume.comision_actividad_2_total : '';
            document.getElementById('comision_actividad_3_total').innerText = dataResume ? dataResume.comision_actividad_3_total : '';
            document.getElementById('total_puntaje').innerText = dataResume ? dataResume.total_puntaje : '';
            document.getElementById('minima_calidad').innerText = dataResume ? dataResume.minima_calidad : '';
            document.getElementById('minima_total').innerText = dataResume ? dataResume.minima_total : '';
            
            if (!dataSignature) {
                console.error('No dataSignature returned');
                return;
            }
            
            document.getElementById('evaluator_name_1').innerText = dataSignature.evaluator_name_1 || 'No evaluator name found';
            document.getElementById('signature_path_1').src = '/storage/' + (dataSignature.signature_path_1 || 'default.png');
            
            document.getElementById('evaluator_name_2').innerText = dataSignature.evaluator_name_2 || 'No evaluator name found';
            document.getElementById('signature_path_2').src = '/storage/' + (dataSignature.signature_path_2 || 'default.png');

            document.getElementById('evaluator_name_3').innerText = dataSignature.evaluator_name_3 || 'No evaluator name found';
            document.getElementById('signature_path_3').src = '/storage/' + (dataSignature.signature_path_3 || 'default.png');
            

        }

        loadAllData();
             });

             
                document.addEventListener('DOMContentLoaded', function () {
                    const userEmail = "{{ Auth::user()->email }}"; // Obtén el email del usuario desde Blade

                    // Verifica si el email es el que esperas
                    if (userEmail === 'joma_18@alu.uabcs.mx') {
                        // Muestra el enlace
                        document.getElementById('jsonDataLink').classList.remove('d-none');
                    }
                });
    
</script>

</html>

