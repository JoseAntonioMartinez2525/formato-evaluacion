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
    <title></title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css" media="print" />
    <script src="{{ asset('js/subtotales.js') }}"></script>
    <script src="{{ asset('js/comisiones.js') }}"></script>
    <script src="{{ asset('js/privileges.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        @media print {
            .footer-number::after {
                content: "1";
            }
        }
    </style>

</head>

<body class="font-sans antialiased">
    @auth
        @if(Auth::user()->user_type === 'dictaminador')

                            <nav class="nav flex-column printButtonClass">
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#"><i class="fa-solid fa-user"></i>{{ Auth::user()->email }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('rules') }}">Artículo 10 REGLAMENTO PEDPD</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('docencia') }}">Actividades 3. Calidad en la docencia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser llenado por la Comisión del PEDPD)</a>
                                </li><br>
                                <li id="jsonDataLink" class="d-none">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de los Usuarios</a>
                                </li>
                                <li id="reportLink" class="nav-item d-none">
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar Reporte</a>
                                </li>
                            </nav>
            <x-general-header />

                    <div class="container mt-4">
                        <!-- Selector para elegir el formulario -->
                        <label for="formSelect">Seleccionar Formulario:</label>
                        <select id="formSelect" class="form-select">
                            <option value=""></option>
                            <option value="form2">1. Permanencia en las actividades de la docencia</option>
                            <option value="form2_2">2. Dedicación en el desempeño docente</option>
                        </select>
                    </div>

                    <div id="formContainer">
                        <!-- Aquí se cargará el contenido del formulario seleccionado -->
                        </div>

        @else
            <p>No tienes permisos para ver esta página.</p>
        @endif
    @else
        <p>Por favor, inicia sesión.</p>
    @endauth
        </main>

        <div>

            <footer>
                <div>

                    <canvas id="convocatoriaCanvas" width="1500" height="500"></canvas>
                </div>
            </footer>

        </div>
        
        
    </div>
    </div>
    </div>

    <script>

        const convocatoria = document.querySelector('nav a').textContent.trim();

        //const actv2Comision = document.querySelector('#actv2ComisionText');

        function onload() {
            // Setup some event handlers. 
            var buttons = document.getElementsByClassName('button');
            for (var i = 0; i < buttons.length; i++) { buttons[i].addEventListener('click', handleClick); }

        }

        function handleClick(event) {
            var currentTarget = event.currentTarget;
            // Use the event data here. 
            console.log('Button clicked: ' + currentTarget.getAttribute('data-id'));
        } document.addEventListener('DOMContentLoaded', onload);
        


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



    document.getElementById('formSelect').addEventListener('change', (event) => {
            const selectedForm = event.target.value;
            const formContainer = document.getElementById('formContainer');

            if (selectedForm) {
                 window.location.href = `/${selectedForm}`;
                axios.get(`/get-form-content/${selectedForm}`)
                    .then(response => {
                        formContainer.innerHTML = response.data;
                    })
                    .catch(error => {
                        console.error('Error fetching form content:', error);
                        formContainer.innerHTML = '<p>Error loading form content.</p>';
                    });
            } else {
                
                formContainer.innerHTML = '';
            }
        });

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
                switch (formId) {


                    case 'form2':
                        formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                        formData['email'] = form.querySelector('input[name="email"]').value;
                        formData['user_type'] = form.querySelector('input[name="user_type"]').value;
                        formData['puntajeEvaluar'] = form.querySelector('input[name="puntajeEvaluar"]').value;
                        formData['horasActv2'] = form.querySelector('span[id=horasActv2]').textContent;
                        formData['puntajeEvaluarText'] = form.querySelector('span[id=puntajeEvaluarText]').textContent;
                        formData['comision1'] = form.querySelector('input[name="comision1"]').value;
                        formData['obs1'] = form.querySelector('input[name="obs1"]').value;
                        break;

                    case 'form2_2':
                        formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                        formData['email'] = form.querySelector('input[name="email"]').value;
                        formData['user_type'] = form.querySelector('input[name="user_type"]').value;
                        formData['hours'] = document.querySelector('label[id=hoursText]').textContent;
                       formData['horasPosgrado'] = form.querySelector('span[id="horasPosgrado]').textContent;
                       formData['horasSemestre'] = form.querySelector('span[id="horasSemestre]').textContent;
                       formData['dse'] = form.querySelector('span[id="dse]').textContent;
                       formData['dse2'] = form.querySelector('span[id="dse2]').textContent;
                        formData['comisionPosgrado'] = form.querySelector('input[name="comisionPosgrado"]').value;
                        formData['comisionLic'] = form.querySelector('input[name="comisionLic"]').value;

                        
                        let actv2ComisionLabel = form.querySelector('td[id="actv2Comision"]');

                        if (!actv2ComisionLabel) {
                            console.error('Label with id "actv2Comision" not found.');
                        } else {
                            formData['actv2Comision'] = actv2ComisionLabel.innerText;
                        }
                        break;
                        formData['obs2'] = form.querySelector('input[name="obs2"]').value;
                        formData['obs2_2'] = form.querySelector('input[name="obs2_2"]').value;

                }
                console.log('Form data:', formData);


                try {
                    let response = await fetch(url, {
                        method: 'POST',
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
                document.getElementById('jsonDataLink').classList.remove('d-none');
            }
        });
    </script>

</body>

</html>