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

    <x-head-resources />

</head>


    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            @if (Route::has('login'))
                @if (Auth::check())
                    <section role="region" aria-label="Response form">
                        <form>
                            @csrf
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