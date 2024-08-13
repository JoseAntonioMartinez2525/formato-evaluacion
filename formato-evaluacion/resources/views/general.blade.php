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
    <link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css" media="print" />
    <script src="{{ asset('js/subtotales.js') }}"></script>
    <script src="{{ asset('js/comisiones.js') }}"></script>
    <script src="{{ asset('js/privileges.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>


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
                                    <a class="nav-link active" style="width: 200px;" href="{{route('welcome')}}">Formato
                                        Evaluación, apartados 1 y 2</a>
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
                                    <a href="{{ route('json-generator') }}" class="btn btn-primary">Mostrar datos de los
                                        Usuarios</a>
                                </li>
                                <li>
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                        Reporte</a>

                                </li>

                            </nav>
                </form>@endif
                </section>

                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <x-general-header />
                    <div class="flex lg:justify-center lg:col-start-2"></div>
                    <nav class="-mx-3 flex flex-1 justify-end"></nav>
                </header>

            @endif
            </div>
            </div>
            <section id="userReports">
            <h1>Seleccionar Usuarios</h1>
            
            <form id="filter-form">
                <label for="user-email">Seleccionar Email:</label>
                <select id="user-email" name="user-email">
                    @foreach ($users as $user)
                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                    @endforeach
                </select>
                <button type="submit">Mostrar Datos</button>
            </form>
            
            <div id="user-data">
                <!-- Aquí se mostrará la información del usuario -->
            </div>
        </section>
            
</body>
<script>
    document.getElementById('filter-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const email = document.getElementById('user-email').value;

            try {
                const response = await fetch(`/show-profile?email=${email}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.error) {
                    document.getElementById('user-data').innerHTML = `<p>${data.error}</p>`;
                    return;
                }

                // Mostrar datos del usuario en la vista
                document.getElementById('user-data').innerHTML = `
                <h2>Datos del Usuario</h2>
                <p>Email: ${data.user.email || 'No disponible'}</p>
                <p>Nombre: ${data.user.name || 'No disponible'}</p>
                <p>Convocatoria: ${data.responseForm1.convocatoria || 'No disponible'}</p>
                <p>Comisión Actividad 1 Total: ${data.resume.comision_actividad_1_total || 'No disponible'}</p>
                <p>Comisión Actividad 2 Total: ${data.resume.comision_actividad_2_total || 'No disponible'}</p>
                <p>Comisión Actividad 3 Total: ${data.resume.comision_actividad_3_total || 'No disponible'}</p>
                <p>Total Puntaje: ${data.resume.total_puntaje || 'No disponible'}</p>
                <p>Mínima Calidad: ${data.resume.minima_calidad || 'No disponible'}</p>
                <p>Mínima Total: ${data.resume.minima_total || 'No disponible'}</p>
                <h2>Persona Evaluadora y Firma: </h2>
                <p>Persona Evaluadora: ${data.signature.evaluator_name_1 || 'No disponible'} 
                <span style="margin-left: 50px;">Firma:</span> ${data.signature.signature_path_1 ? `<img src="/storage/${data.signature.signature_path_1}" alt="Firma" style="max-width: 200px;"/>` : 'No disponible'}</p>
                <p>Persona Evaluadora: ${data.signature.evaluator_name_2 || 'No disponible'}
                <span style="margin-left: 50px;">Firma:</span> ${data.signature.signature_path_2 ? `<img src="/storage/${data.signature.signature_path_2}" alt="Firma" style="max-width: 200px;"/>` : 'No disponible'}
                </p>
                <p>Persona Evaluadora: ${data.signature.evaluator_name_3 || 'No disponible'}
                <span style="margin-left: 50px;">Firma:</span> ${data.signature.signature_path_3 ? `<img src="/storage/${data.signature.signature_path_3}" alt="Firma" style="max-width: 200px;"/>` : 'No disponible'}
                </p>
            `;

            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                document.getElementById('user-data').innerHTML = `<p>Error al obtener datos del usuario.</p>`;
            }
        });
    </script>
</script>

</html>