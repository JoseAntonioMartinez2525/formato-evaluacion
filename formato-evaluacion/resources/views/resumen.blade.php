@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="{{ $newLocale }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formato de Evaluación docente</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/resume.css') }}" rel="stylesheet">
    <script src="{{ asset('js/subtotales.js') }}"></script>
    <script src="{{ asset('js/comisiones.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</head>

<body class="font-sans antialiased">
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
                                <li>
                                    <a href="{{ route('json-generator') }}" class="btn btn-primary">Get JSON Data</a>
                                </li>

                            </nav>
                </form>@endif
                </section>

                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2"></div>
                    <nav class="-mx-3 flex flex-1 justify-end"></nav>
                </header>
                <main class="container">
                    <form id="form4" method="POST" onsubmit="event.preventDefault(); submitForm('/store', 'form4');">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                        <center>
                        <h2 id="resumen">Resumen</h2>
                        <h4>A ser llenado por la Comisión del PEDPD</h4></center>
                        <table class="resumenTabla">
                           <thead>
                            <tr>
                            <th id="actv">Actividad</th>
                            <th id="pMaximo">Puntaje máximo</th>
                            <th id="pComision">Puntaje otorgado Comisión PEDPD</th>
                           </tr>
                        </thead> 
                        <thead>
                            <tr>
                                <td><b>1. Permanencia en las actividades de la docencia</b></td>
                                <td  class="p1"><b>100</b></td>
                                <td>
                                    <input type="number" name="actividad1" id="a1" placeholder="0">
                                </td>
                            </tr>
                            <tr>
                                <td>1.1 Años de experiencia docente en la institución</td>
                                <td class="p1">100</td>
                                <td>
                                    <label for="">

                             <!--get comision1 de welcome.blade.php-->    

                                    </label>

                                </td>
                            </tr>
                            <tr>
                                <td><b>2. Dedicación en el desempeño docente</b></td>
                                <td class="p1"><b>200</b></td>
                                <td>
                                    <b></b>
                                <!--get actv2Comision de welcome.blade.php-->
                                </td>
                            </tr>
                            <tr>
                                <td>2.1 Carga de trabajo docente frente a grupo</td>
                                <td>200</td>
                                <td>
                                    <!--get actv2Comision de welcome.blade.php-->
                                </td>
                            </tr>
                            <tr>
                                <td><b>3. Calidad en la docencia</b></td>
                                <td class="p1"><b>700</b></td>
                                <td>
                                    <b></b>
                                    <!--min(7000, suma((suma de comision totales de actvs 3.1 a 3.8)+
                                    (suma de comision totales de actvs 3.9 a 3.11)+
                                    (suma de comision totales de actvs 3.12 a 3.16)+
                                    (suma de comision totales de actvs 3.17 a 3.19)
                                    ))-->
                                </td>

                            </tr>
                        </thead>
                        </table>
                        <!--<center><button type="submit" class="btn btn-primary" id="btn1">Enviar</button>-->
                        </center>
                        </div>

                    </form>
            @endif
        </div>
        </main>

        <div>

            <footer>
                <div>
                    <label id="convocatoriaPeriodoLabel" style="color:black;"></label>
                </div>
            </footer>

        </div>
    </div>
    </div>
    </div>

    <script>


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
                let formData = {};
                let gridOptions = {};
                let form = document.getElementById(formId);
                // Ensure the form element exists
                if (!form) {
                    console.error(`Form with id "${formId}" not found.`);
                    return;
                }

                //Recoge los datos dependiendo del formulario actual
                if(formId=='form4') {
                    
                        formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                        formData['email'] = form.querySelector('input[name="email"]').value;

                        

                }
                console.log('Form data:', formData); // Log form data to check values
                //if (!formData.hasOwnProperty('score3_1')) {
                // Si score3_1 no está en formData, proporciona un valor predeterminado
                //formData['score3_1'] = ''; // Aquí puedes proporcionar cualquier valor predeterminado que desees
                //}


                try {
                    let response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData),
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    let data = await response.json();
                    console.log('Response received from server:', data);
                } catch (error) {
                    console.error('There was a problem with the fetch operation:', error);
                }
            }

            window.submitForm = submitForm;
        });


    </script>

</body>

</html>