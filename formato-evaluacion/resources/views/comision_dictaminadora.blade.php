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
    <title>Comision Dictaminadora</title>

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
    @auth
        @if(Auth::user()->user_type === 'dictaminador')

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
                            <option value="form3_1">  3.1 Participación en actividades de diseño curricular</option>
                            <option value="form3_2">  3.2 Calidad del desempeño docente evaluada por el alumnado</option>
                            <option value="form3_3">  3.3 Publicaciones relacionadas con la docencia</option>
                            <option value="form3_4">  3.4 Distinciones académicas recibidas por el docente</option>
                            <option value="form3_5">  3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC</option>
                            <option value="form3_6">  3.6 Capacitación y actualización pedagógica recibida</option>
                            <option value="form3_7">  3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento</option>
                            <option value="form3_8">  3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y
                            capacitación docente</option>
                            <option value="form3_9">  3.9 Trabajos dirigidos para la titulación de estudiantes</option>
                            <option value="form3_10"> 3.10 Tutorías a estudiantes</option>
                            <option value="form3_11"> 3.11 Asesoría a estudiantes</option>
                            <option value="form3_12"> 3.12      </option>
                            <option value="form3_13"> 3.13 Proyectos académicos de investigación</option>



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
                        formContainer.innerHTML = '<p style="margin-left: 150px;">Cargando formulario.....</p>';
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
                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                formData['email'] = form.querySelector('input[name="email"]').value;
                formData['user_type'] = form.querySelector('input[name="user_type"]').value;
                switch (formId) {


                    case 'form2':

                        formData['puntajeEvaluar'] = form.querySelector('input[name="puntajeEvaluar"]').value;
                        formData['horasActv2'] = form.querySelector('span[id=horasActv2]').textContent;
                        formData['puntajeEvaluarText'] = form.querySelector('span[id=puntajeEvaluarText]').textContent;
                        formData['comision1'] = form.querySelector('input[name="comision1"]').value;
                        formData['obs1'] = form.querySelector('input[name="obs1"]').value;
                        break;

                    case 'form2_2':

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
                        formData['obs2'] = form.querySelector('input[name="obs2"]').value;
                        formData['obs2_2'] = form.querySelector('input[name="obs2_2"]').value; 
                        break;

                    case 'form3_1':

                        formData['elaboracion'] = document.getElementById('elaboracion').textContent;
                        formData['elaboracionSubTotal1'] = document.getElementById('elaboracionSubTotal1').textContent;
                        formData['comisionIncisoA'] = document.getElementById('comisionIncisoA').value;
                        formData['elaboracion2'] = document.getElementById('elaboracion2').textContent;
                        formData['elaboracionSubTotal2'] = document.getElementById('elaboracionSubTotal2').textContent;
                        formData['comisionIncisoB'] = document.getElementById('comisionIncisoB').value;
                        formData['elaboracion3'] = document.getElementById('elaboracion3').textContent;
                        formData['elaboracionSubTotal3'] = document.getElementById('elaboracionSubTotal3').textContent;
                        formData['comisionIncisoC'] = document.getElementById('comisionIncisoC').value;
                        formData['elaboracion4'] = document.getElementById('elaboracion4').textContent;
                        formData['elaboracionSubTotal4'] = document.getElementById('elaboracionSubTotal4').textContent;
                        formData['comisionIncisoD'] = document.getElementById('comisionIncisoD').value;
                        formData['elaboracion5'] = document.getElementById('elaboracion5').textContent;
                        formData['elaboracionSubTotal5'] = document.getElementById('elaboracionSubTotal5');
                        formData['comisionIncisoE'] = document.getElementById('comisionIncisoE').value;                             
                        formData['score3_1'] = document.getElementById('score3_1').textContent;
                        formData['actv3Comision'] = document.getElementById('actv3Comision').textContent;

                        formData['obs3_1_1'] = form.querySelector('input[name="obs3_1_1"]').value;
                        formData['obs3_1_2'] = form.querySelector('input[name="obs3_1_2"]').value;
                        formData['obs3_1_3'] = form.querySelector('input[name="obs3_1_3"]').value;
                        formData['obs3_1_4'] = form.querySelector('input[name="obs3_1_4"]').value;
                        formData['obs3_1_5'] = form.querySelector('input[name="obs3_1_5"]').value;
                        break;

                    case 'form3_2':
                        formData['score3_1'] = document.getElementById('score3_2').textContent;
                        formData['comision3_2'] = document.getElementById('comision3_2').textContent;
                        formData['prom90_100'] = document.getElementById('prom90_100').textContent;
                        formData['prom80_90'] = document.getElementById('prom80_90').textContent;
                        formData['prom70_80'] = document.getElementById('prom70_80').textContent;                     
                        formData['r1'] = document.getElementById('r1').value;
                        formData['r2'] = document.getElementById('r2').value;
                        formData['r3'] = document.getElementById('r3').value;
                        formData['cant1'] = document.getElementById('cant1').textContent;
                        formData['cant2'] = document.getElementById('cant2').textContent;
                        formData['cant3'] = document.getElementById('cant3').textContent;
                        formData['obs3_2_1'] = form.querySelector('input[name="obs3_2_1"]').value;
                        formData['obs3_2_2'] = form.querySelector('input[name="obs3_2_2"]').value;
                        formData['obs3_2_3'] = form.querySelector('input[name="obs3_2_3"]').value;
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