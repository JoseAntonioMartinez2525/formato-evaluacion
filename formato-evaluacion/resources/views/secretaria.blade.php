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

    <x-head-resources />
    <style>
        @media print {
            .footer-number::after {
                content: "1";
            }
        }
    </style>

</head>

<body class="font-sans antialiased">
    <x-general-header />
    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            @if (Route::has('login'))
                @if (Auth::check() && Auth::user()->user_type === '')
                        <section role="region" aria-label="Response form">
                         <form>
                                @csrf
                            <nav class="nav flex-column" style="padding-top: 50px; height: 900px; background-color: #afc7ce;">
                                <div class="nav-header" style="display: flex; align-items: center; padding-top: 50px;">
                                    <li class="nav-item">
                                        <a class="nav-link disabled enlaceSN" style="font-size: medium;" href="#">
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
                                        <a class="nav-link active enlaceSN" style="width: 200px;" href="{{route('rules')}}">Artículo 10
                                            REGLAMENTO
                                            PEDPD</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active enlaceSN" style="width: 200px;" href="{{route('resumen_comision')}}">Resumen (A ser
                                            llenado por la Comisión del PEDPD)</a>
                                    </li><br>
                                </nav>
                    </form>
                @endif
                </section>

                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2"></div>

                    <nav class="-mx-3 flex flex-1 justify-end"></nav>

                <div class="container mt-4">
                    <!-- Selector para elegir el formulario -->
                    <label for="formSelect">Seleccionar Formulario:</label>
                    <select id="formSelect" class="form-select">
                        <option value=""></option>
                        <option value="form2">1. Permanencia en las actividades de la docencia</option>
                        <option value="form2_2">2. Dedicación en el desempeño docente</option>
                        <option value="form3_1">    3.1 Participación en actividades de diseño curricular</option>
                        <option value="form3_2">    3.2 Calidad del desempeño docente evaluada por el alumnado</option>
                        <option value="form3_3">    3.3 Publicaciones relacionadas con la docencia</option>
                        <option value="form3_4">    3.4 Distinciones académicas recibidas por el docente</option>
                        <option value="form3_5">    3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC</option>
                        <option value="form3_6">    3.6 Capacitación y actualización pedagógica recibida</option>
                        <option value="form3_7">    3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento</option>
                        <option value="form3_8">    3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente</option>
                        <option value="form3_9">    3.9 Trabajos dirigidos para la titulación de estudianteso</option>
                        <option value="form3_10">   3.10 Tutorías a estudiantes</option>
                        <option value="form3_11">   3.11 Asesoría a estudiantes</option>
                        <option value="form3_12">   3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte el docente</option>
                        <option value="form3_13">   3.13 Proyectos académicos de investigación</option>
                        <option value="form3_14">   3.14 Participación como ponente en congresos o eventos académicos del área de conocimiento o afines del docente</option>
                        <option value="form3_15">   3.15 Registro de patentes y productos de investigación tecnológica y educativa</option>
                        <option value="form3_16">   3.16 Actividades de arbitraje, revisión, correción y edición</option>
                        <option value="form3_17">   3.17 Proyectos académicos de extensión y difusión</option>
                        <option value="form3_18">   3.18 Organización de congresos o eventos institucionales del área de conocimiento del Docente</option>
                        <option value="form3_19">   3.19 Participación en cuerpos colegiados</option>


                    </select>
                </div>

                <div id="formContainer">
                    <!-- Aquí se cargará el contenido del formulario seleccionado -->
                </div>


            @endif
        </div>
        </main>

        <div>

            <footer>
                <div>

                    <canvas id="convocatoriaCanvas" width="1500" height="500"></canvas>
                </div>
                <!--
@component('components.pie-pag', ['number' => '0'])
@endcomponent-->
            </footer>

        </div>
    </div>
    </div>
    </div>

    <script>

       
        function handleClick(event) {
            var currentTarget = event.currentTarget;
            // Use the event data here. 
            console.log('Button clicked: ' + currentTarget.getAttribute('data-id'));
        } document.addEventListener('DOMContentLoaded', onload);
        function onChange() {
            // Obtener los valores de los inputs
            const puntajePosgrado = parseFloat(document.getElementById("horasPosgrado").value);
            const puntajeSemestre = parseFloat(document.getElementById("horasSemestre").value);
            const h = parseFloat(document.querySelector('#hoursText'));

            // Realizar los cálculos
            const dsePosgrado = puntajePosgrado * 8.5;
            const dseSemestre = puntajeSemestre * 8.5;
            const hora = (dsePosgrado + dseSemestre);

            // Actualizar el contenido de las etiquetas <label>
            document.getElementById("DSE").innerText = dsePosgrado;
            document.getElementById("DSE2").innerText = dseSemestre;

            // Mostrar los valores actualizados en la consola
            console.log(dsePosgrado);
            console.log(dseSemestre);

            const minimo = minWithSum(dsePosgrado, dseSemestre);

            document.getElementById("hoursText").innerText = minimo;
            console.log(minimo);


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

        function minWithSum(value1, value2) {
            const sum = value1 + value2;
            return Math.min(sum, 200);


        }

        function min40(...values) {
            const sum40 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum40, 40);
        }

        function min30(...values) {
            const sum30 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum30, 30);
        }

        function subtotal(value1, value2) {
            const st = value1 * value2;
            return st;
        }

        function min60(...values) {
            const sum60 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum60, 60);
        }

        function minWithSumThree(value1, value2, value3, value4) {
            const ms = value1 + value2 + value3 + value4;
            return Math.min(ms, 100);
        }

        function min50(...values) {
            const ms = values.reduce((acc, val) => acc + val, 0);
            return Math.min(ms, 50);
        }

        function minWithSumThreeFive(value1, value2) {
            const ms = value1 + value2;
            return Math.min(ms, 75);
        }

        function minTutorias() {
            // convert the arguments object to an array
            const values = Array.from(arguments);

            // use reduce to sum the values
            const ms = values.reduce((acc, current) => {
                return acc + current;
            }, 0);

            // return the minimum of ms and 200
            return Math.min(ms, 200);
        }

        function min700(...values) {
            const ms = values.reduce((acc, val) => acc + val, 0);
            return Math.min(ms, 700);
        }

        // Función para actualizar el objeto data con los valores de los campos del formulario
        function actualizarData() {
            data[this.id] = this.value;
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
                switch (formId) {
                    case 'form1':
                        formData['convocatoria'] = form.querySelector('input[name="convocatoria"]').value;
                        formData['periodo'] = form.querySelector('input[name="periodo"]').value;
                        formData['nombre'] = form.querySelector('input[name="nombre"]').value;
                        formData['area'] = form.querySelector('select[name="area"]').selectedOptions[0].textContent;
                        formData['departamento'] = form.querySelector('select[name="departamento"]').selectedOptions[0].textContent;
                        break;

                    case 'form2':
                        formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                        formData['email'] = form.querySelector('input[name="email"]').value;
                        formData['horasActv2'] = form.querySelector('input[name="horasActv2"]').value;
                        formData['puntajeEvaluar'] = form.querySelector('input[name="puntajeEvaluar"]').value;
                        //formData['comision1'] = form.querySelector('input[name="comision1"]').value;
                        formData['obs1'] = form.querySelector('input[name="obs1"]').value;
                        break;

                    case 'form2_2':
                        formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                        formData['email'] = form.querySelector('input[name="email"]').value;
                        let hoursLabel = form.querySelector('label[id="hoursText"]');
                        //let actv2ComisionLabel = form.querySelector('td[id="actv2Comision"]');

                        if (!hoursLabel) {
                            console.error('Label with id "hoursText" not found.');
                        } else {
                            formData['hours'] = hoursLabel.innerText;
                        }

                        /*if (!actv2ComisionLabel) {
                          console.error('Label with id "actv2Comision" not found.');
                        } else {
                          formData['actv2Comision'] = actv2ComisionLabel.innerText;
                        }*/

                        formData['obs2'] = form.querySelector('input[name="obs2"]').value;
                        formData['obs2_2'] = form.querySelector('input[name="obs2_2"]').value;
                        break;

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

                    let responseText = await response.text(); // Obtener el texto de la respuesta
                    console.log('Raw response from server:', responseText);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    let data = JSON.parse(responseText);
                    console.log('Response received from server:', data);
                } catch (error) {
                    console.error('There was a problem with the fetch operation:', error);
                }
            }

            window.submitForm = submitForm;
        });


        // Función para actualizar el label en el footer con la convocatoria y periodo de evaluación
        function actualizarLabelConvocatoriaPeriodo(convocatoria, periodo) {
            const label = document.getElementById('convocatoriaPeriodoLabel');
            label.textContent = `Convocatoria: ${convocatoria}, Período: ${periodo}`;
        }

        // Captura la convocatoria y periodo de evaluación al enviar el formulario form1
        document.addEventListener('DOMContentLoaded', function () {
            const form1 = document.getElementById('form1');
            form1.addEventListener('submit', function (event) {
                event.preventDefault(); // Evita el envío del formulario para manejarlo con JavaScript

                // Captura los valores del formulario form1
                const convocatoria = document.getElementById('convocatoria').value;
                const periodo = document.getElementById('periodo').value;

                // Actualiza el label en el footer con los valores capturados
                actualizarLabelConvocatoriaPeriodo(convocatoria, periodo);
                console.log(label);
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Get the canvas element
            var canvas = document.getElementById('convocatoriaCanvas');
            var context = canvas.getContext('2d');

            // Function to update the canvas with 'Convocatoria' value
            function updateCanvas(text) {
                // Clear the canvas
                context.clearRect(200, 100, canvas.width, canvas.height);

                // Set text properties
                context.font = '20px Arial';
                context.fillStyle = 'black';
                context.textAlign = 'right';
                context.textBaseline = 'middle';

                // Draw the text
                context.fillText(text, canvas.width / 2, canvas.height / 2);
            }

            // Get the input element with id 'convocatoria'
            var convocatoriaInput = document.getElementById('convocatoria');
            if (convocatoriaInput) {
                // Update the canvas initially with the placeholder value or empty
                updateCanvas(convocatoriaInput.placeholder);

                // Listen for input events to dynamically update the canvas
                convocatoriaInput.addEventListener('input', function () {
                    var newValue = convocatoriaInput.value;
                    updateCanvas(newValue);
                });
            }
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
                            formContainer.innerHTML = '<p style="margin-left: 120px;">Cargando formulario.....</p>';
                        });
                } else {

                    formContainer.innerHTML = '';
                }
            });
    </script>

</body>

</html>