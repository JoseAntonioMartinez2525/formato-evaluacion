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
                                    <form id="form4" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); submitForm('/store-resume', 'form4');" >
                                        @csrf
                                        <div>
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
                                                    <b><span id="actv1Repetido"></span></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="info">1.1 Años de experiencia docente en la institución</td>
                                                <td class="p1">100</td>
                                                <td class="tdResaltado">
                                                    <label class="p2" id="comision1" for="" ></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>2. Dedicación en el desempeño docente</b></td>
                                                <td class="p1"><b>200</b></td>
                                                <td>
                                                    <b><span id="actv2Repetido"></span></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="info">2.1 Carga de trabajo docente frente a grupo</td>
                                                <td class="p1">200</td>
                                                <td class="tdResaltado">
                                                <span class="p2" id="actv2Comision" for=""></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>3. Calidad en la docencia</b></td>
                                                <td class="p1"><b>700</b></td>
                                                <td>
                                                    <b id="actv3Total">
                                                    <!--min(7000, suma((suma de comision totales de actvs 3.1 a 3.8)+
                                                    (suma de comision totales de actvs 3.9 a 3.11)+
                                                    (suma de comision totales de actvs 3.12 a 3.16)+
                                                    (suma de comision totales de actvs 3.17 a 3.19)
                                                    ))--></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3.1 Participación en actividades de diseño curricular</td>
                                                <td class="p1">60</td>
                                                <td class="tdResaltado"><span id="actv3Comision" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td>3.2 Calidad del desempeño docente evaluada por los estudiantes</td>
                                                <td class="p1">50</td>
                                                <td class="tdResaltado"><span id="comision3_2" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td>3.3 Publicaciones relacionadas con la docencia</td>
                                                <td class="p1">100</td>
                                                <td class="tdResaltado"><span id="comision3_3" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td>3.4 Distinciones académicas recibidas por el docente</td>
                                                <td class="p1">60</td>
                                                <td class="tdResaltado"><span id="comision3_4" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td>3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC</td>
                                                <td class="p1">75</td>
                                                <td class="tdResaltado"><span id="comision3_5" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td>3.6 Capacitación y actualización pedagógica recibida</td>
                                                <td class="p1">40</td>
                                                <td class="tdResaltado"><span id="comision3_6" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td>3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento</td>
                                                <td class="p1">40</td>
                                                <td class="tdResaltado "><span id="comision3_7" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td>3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y
                                                capacitación docente</td>
                                                <td class="p1">40</td>
                                                <td class="tdResaltado "><span id="comision3_8" class="p2" for=""></span></td>
                                            </tr>
                                            <tr>
                                                <td><center><b>Subtotal</b></center></td>
                                                <td></td>
                                                <td><b><label id="comision3_1To3_8" for=""  class="p2"></label></b></td>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="subtitle">Tutorias</th>
                                            </tr>
                                            <tr>
                                                <td>3.9 Trabajos dirigidos para la titulación de estudiantes</td>
                                                <td class="p1">200</td>
                                                <td class="tdResaltado"><label id="comision3_9" class="p2"for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.10 Tutorías a estudiantes</td>
                                                <td class="p1">115</td>
                                                <td class="tdResaltado"><label id="comision3_10" class= "p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.11 Asesoría a estudiantes</td>
                                                <td class="p1">95</td>
                                                <td class="tdResaltado"><label id="comision3_11" class= "p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <center><b>Subtotal</b></center>
                                                </td>
                                                <td></td>
                                                <td><b><label id="comision3_9To3_11" for="" class="p2"></label></b></td>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="subtitle">Investigación</th>
                                            </tr>
                                            <tr>
                                                <td>3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte el docente</td>
                                                <td class="p1">150</td>
                                                <td class="tdResaltado"><label id="comision3_12" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.13 Proyectos académicos de investigación</td>
                                                <td class="p1">130</td>
                                                <td class="tdResaltado"><label id="comision3_13" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.14 Participación como ponente en congresos o eventos académicos del área de conocimiento o afines del docente</td>
                                                <td class="p1">40</td>
                                                <td class="tdResaltado"><label id="comision3_14" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.15 Registro de patentes y productos de investigación tecnológica y educativa</td>
                                                <td class="p1">60</td>
                                                <td class="tdResaltado"><label id="comision3_15" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.16 Actividades de arbitraje, revisión, correción y edición</td>
                                                <td class="p1">30</td>
                                                <td class="tdResaltado"><label id="comision3_16" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <center><b>Subtotal</b></center>
                                                </td>
                                                <td></td>
                                                <td><b><label id="comision3_12To3_16" for="" class="p2"></label></b></td>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="subtitle">Cuerpos Colegiados</th>
                                            </tr>
                                            <tr>
                                                <td>3.17 Proyectos académicos de extensión y difusión</td>
                                                <td class="p1">50</td>
                                                <td class="tdResaltado"><label id="comision3_17" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.18 Organización de congresos o eventos institucionales del área de conocimiento del Docente</td>
                                                <td class="p1">40</td>
                                                <td class="tdResaltado"><label id="comision3_18" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3.19 Participación en cuerpos colegiados</td>
                                                <td class="p1">40</td>
                                                <td class="tdResaltado"><label id="comision3_19" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <center><b>Subtotal</b></center>
                                                </td>
                                                <td></td>
                                                <td><b><label id="comision3_17To3_19" for="" class="p2"></label></b></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <center><b>Total logrado en la evaluación</b></center>
                                                </td>
                                                <td></td>
                                                <td><label id="totalComision" for="" class="p2"></label></td>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <td>1. Permanencia en las actividades de la docencia</td>
                                                <td class="p1">100</td>
                                                <td class="tdResaltado"><label id="comision1Total" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>2. Dedicación en el desempeño docente</td>
                                                <td class="p1">200</td>
                                                <td class="tdResaltado"><label id="comision2Total" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>3. Calidad en la docencia</td>
                                                <td class="p1">700</td>
                                                <td class="tdResaltado"><label id="comision3Total" class="p2" for=""></label></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <center><b>Total de puntaje obtenido en la evaluación</b></center>
                                                </td>
                                                <td></td>
                                                <td><b><label id="totalComisionRepetido" for="" class="p2"></label></b></td>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th>Nivel obtenido de acuerdo al artículo 10 del Reglamento</th> 
                                                <th>Mínima de Calidad</th>
                                                <th><b><span id="minimaCalidad"></span></b></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>Mínima Total</th>
                                                <th><b><span id="minimaTotal"></span></b></th>
                                            </tr>
                                        </thead>
                                        </table>
                                        <center>
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </center>
                                        </div>
                                    </form>
                                    <br>
                                    <form id="form5" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); submitForm('/store-evaluator-signature', 'form5');">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                        <table>
                                        <thead>
                                            <tr>
                                                <th><input class="personaEvaluadora" type="text" id="personaEvaluadora1"></th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de la persona evaluadora</td>
                                            </tr>
                                            <tr>
                                                <th><input class="personaEvaluadora" type="text" id="personaEvaluadora2"></th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de la persona evaluadora</td>
                                            </tr>
                                            <tr>
                                                <th><input class="personaEvaluadora" type="text" id="personaEvaluadora3"></th>
                                                <th><input type="file" class="form-control" id="firma" name="firma" accept="image/*"></th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de la persona evaluadora</td>
                                                <td>Firma</td>

                                            </tr>

                                        </thead>
                                        <thead>
                                            <td><button type="submit" class="btn btn-primary">Enviar</button></td>
                                        </thead>
                                        </table>
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
            let form = document.getElementById(formId);
            let formData = new FormData(form);
            formData.append('formId', formId);

            // Recoge los datos dependiendo del formulario actual
            if (formId == 'form4') {
                formData.set('user_id', form.querySelector('input[name="user_id"]').value);
                formData.set('email', form.querySelector('input[name="email"]').value);

                // Obtener valores de los labels y spans
                formData.set('comision_actividad_1_total', document.getElementById('comision1Total').innerText);
                formData.set('comision_actividad_2_total', document.getElementById('comision2Total').innerText);
                formData.set('comision_actividad_3_total', document.getElementById('comision3Total').innerText);
                formData.set('total_puntaje', document.getElementById('totalComisionRepetido').innerText);
                formData.set('minima_calidad', document.getElementById('minimaCalidad').innerText);
                formData.set('minima_total', document.getElementById('minimaTotal').innerText);


                // Log form data to check values
                console.log('Form data: ', formData);
            }else if (formId === 'form5') {
                formData.set('user_id', form.querySelector('input[name="user_id"]').value);
                formData.set('email', form.querySelector('input[name="email"]').value);

                let personaEvaluadora = form.querySelector('.personaEvaluadora');
                if (personaEvaluadora) {
                    formData.set('evaluator_name', personaEvaluadora.value);
                }

                let firma = form.querySelector('input[type="file"][name="firma"]');
                if (firma && firma.files.length > 0) {
                    formData.append('firma', firma.files[0]);
                }
            }

            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const contentType = response.headers.get('Content-Type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Invalid JSON response');
                }

                let data = await response.json();
                console.log('Response received from server:', data);

                if (data.signature_url) {
                    const img = document.createElement('img');
                    img.src = data.signature_url;
                    img.alt = 'Signature';
                    img.style.maxWidth = '300px'; // Adjust as needed
                    document.body.appendChild(img);
                }
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        window.submitForm = submitForm;
    });



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
                    let data2 = await fetchData('/get-data2', { user_id: userId });
                    let data2_2 = await fetchData('/get-data22', { user_id: userId });
                    let data31 = await fetchData('/get-data-31', { user_id: userId });
                    let data32 = await fetchData('/get-data-32', { user_id: userId });
                    let data33 = await fetchData('/get-data-33', { user_id: userId });
                    let data34 = await fetchData('/get-data-34', { user_id: userId });
                    let data35 = await fetchData('/get-data-35', { user_id: userId });
                    let data36 = await fetchData('/get-data-36', { user_id: userId });
                    let data37 = await fetchData('/get-data-37', { user_id: userId });
                    let data38 = await fetchData('/get-data-38', { user_id: userId });
                    let data39 = await fetchData('/get-data-39', { user_id: userId });
                    let data310 = await fetchData('/get-data-310', { user_id: userId });
                    let data311 = await fetchData('/get-data-311', { user_id: userId });
                    let data312 = await fetchData('/get-data-312', { user_id: userId });
                    let data313 = await fetchData('/get-data-313', { user_id: userId });
                    let data314 = await fetchData('/get-data-314', { user_id: userId });
                    let data315 = await fetchData('/get-data-315', { user_id: userId });
                    let data316 = await fetchData('/get-data-316', { user_id: userId });
                    let data317 = await fetchData('/get-data-317', { user_id: userId });
                    
                    let data318 = await fetchData('/get-data-318', { user_id: userId });
                    let data319 = await fetchData('/get-data-319', { user_id: userId });
                    
                    // Populate labels with the retrieved data
                    document.getElementById('comision1').innerText = data2 ? data2.comision1 : '';
                    document.getElementById('actv2Comision').innerText = data2_2 ? data2_2.actv2Comision : '';
                    
                    document.getElementById('actv1Repetido').innerText = data2 ? data2.comision1 : '';
                    document.getElementById('comision1Total').innerText = data2 ? data2.comision1 : '';
                    document.getElementById('actv2Repetido').innerText = data2_2 ? data2_2.actv2Comision : '';
                    document.getElementById('comision2Total').innerText = data2_2 ? data2_2.actv2Comision : '';

                    document.getElementById('actv3Comision').innerText = data31 ? data31.actv3Comision : '';
                    document.getElementById('comision3_2').innerText = data32 ? data32.comision3_2 : '';
                    document.getElementById('comision3_3').innerText = data33 ? data33.comision3_3 : '';
                    document.getElementById('comision3_4').innerText = data34 ? data34.comision3_4 : '';
                    document.getElementById('comision3_5').innerText = data35 ? data35.comision3_5 : '';
                    document.getElementById('comision3_6').innerText = data36 ? data36.comision3_6 : '';
                    document.getElementById('comision3_7').innerText = data37 ? data37.comision3_7 : '';
                    document.getElementById('comision3_8').innerText = data38 ? data38.comision3_8 : '';
                    document.getElementById('comision3_9').innerText = data39 ? data39.comision3_9 : '';
                    document.getElementById('comision3_10').innerText = data310 ? data310.comision3_10 : '';
                    document.getElementById('comision3_11').innerText = data311 ? data311.comision3_11 : '';
                    document.getElementById('comision3_12').innerText = data312 ? data312.comision3_12 : '';
                    document.getElementById('comision3_13').innerText = data313 ? data313.comision3_13 : '';
                    document.getElementById('comision3_14').innerText = data314 ? data314.comision3_14 : '';
                    document.getElementById('comision3_15').innerText = data315 ? data315.comision3_15 : '';
                    document.getElementById('comision3_16').innerText = data316 ? data316.comision3_16 : '';
                    
                    document.getElementById('comision3_17').innerText = data317 ? data317.comision3_17 : '';
                    document.getElementById('comision3_18').innerText = data318 ? data318.comision3_18 : '';
                    document.getElementById('comision3_19').innerText = data319 ? data319.comision3_19 : '';
                    

                    // Calculate the total score
                    calculateTotalScore();
                }

                
                function calculateTotalScore() {
                    
                    let actv3Comision = parseFloat(document.getElementById('actv3Comision').textContent);
                    console.log(actv3Comision);
                    let comision3_2 = parseFloat(document.getElementById('comision3_2').textContent);
                    let comision3_3 = parseFloat(document.getElementById('comision3_3').textContent);
                    let comision3_4 = parseFloat(document.getElementById('comision3_4').textContent);
                    let comision3_5 = parseFloat(document.getElementById('comision3_5').textContent);
                    let comision3_6 = parseFloat(document.getElementById('comision3_6').textContent);
                    let comision3_7 = parseFloat(document.getElementById('comision3_7').textContent);
                    let comision3_8 = parseFloat(document.getElementById('comision3_8').textContent);

                    let comision3_9 = parseFloat(document.getElementById('comision3_9').textContent);
                    let comision3_10 = parseFloat(document.getElementById('comision3_10').textContent);
                    let comision3_11 = parseFloat(document.getElementById('comision3_11').textContent);
                    let comision3_12 = parseFloat(document.getElementById('comision3_12').textContent);               
                    let comision3_13 = parseFloat(document.getElementById('comision3_13').textContent);
                    let comision3_14 = parseFloat(document.getElementById('comision3_14').textContent);
                    let comision3_15 = parseFloat(document.getElementById('comision3_15').textContent);
                    let comision3_16 = parseFloat(document.getElementById('comision3_16').textContent);
                    let comision3_17 = parseFloat(document.getElementById('comision3_17').textContent);
                    let comision3_18 = parseFloat(document.getElementById('comision3_18').textContent);
                    let comision3_19 = parseFloat(document.getElementById('comision3_19').textContent);
                    
                    let comision3_1To3_8 = parseInt(actv3Comision + comision3_2 + comision3_3 + comision3_4 +
                    comision3_5 + comision3_6 + comision3_7 + comision3_8);
                    let comision3_9To3_11 = parseInt(comision3_9+ comision3_10+ comision3_11);
                    let comision3_12To3_16 = parseInt(comision3_12 + comision3_13 + comision3_14 + comision3_15 + comision3_16);
                    let comision3_17To3_19 = parseInt(comision3_17 + comision3_18 + comision3_19);
                    
                    document.getElementById('comision3_1To3_8').innerText = comision3_1To3_8;
                    document.getElementById('comision3_9To3_11').innerText = comision3_9To3_11;
                    document.getElementById('comision3_12To3_16').innerText = comision3_12To3_16;
                    document.getElementById('comision3_17To3_19').innerText = comision3_17To3_19;

                    const actv3Total = min700(comision3_1To3_8, comision3_9To3_11, comision3_12To3_16, comision3_17To3_19);
                    document.getElementById('actv3Total').innerText = actv3Total;

                    const comision3Total = actv3Total;
                    document.getElementById('comision3Total').innerText = comision3Total;
                    
                    total();
                    document.getElementById('totalComisionRepetido').innerText = total();
                    document.getElementById('totalComision').innerText = total();
                    condicionales();
                
                }

                loadAllData();
            });

            function min700(...values){
                const total = values.reduce((acc, val) => acc + val, 0);
                return Math.min(total, 700);
            }

            function total(){
                let suma = (parseFloat(document.getElementById('comision1Total').textContent))+(parseFloat(document.getElementById('comision2Total').textContent))+(parseFloat(document.getElementById('comision3Total').textContent));
                suma = suma >= 700 ? 700 : suma;
                return suma;
            }

            function condicionales(){
                let actv3Total = parseFloat(document.getElementById('actv3Total').textContent);
                let totalComision = parseFloat(document.getElementById('totalComision').textContent);
                
                let minimaCalidad;
                let minimaTotal;
                switch (true) {
                    case (actv3Total >= 210 && actv3Total <= 264):
                        minimaCalidad = 'I';
                        break;
                    case (actv3Total >= 265 && actv3Total <= 319):
                        minimaCalidad = 'II';
                        break;
                    case (actv3Total >= 320 && actv3Total <= 374):
                        minimaCalidad = 'III';
                        break;
                    case (actv3Total >= 375 && actv3Total <= 429):
                        minimaCalidad = 'IV';
                        break;
                    case (actv3Total >= 430 && actv3Total <= 484):
                        minimaCalidad = 'V';
                        break;
                    case (actv3Total >= 485 && actv3Total <= 539):
                        minimaCalidad = 'VI';
                        break;
                    case (actv3Total >= 540 && actv3Total <= 594):
                        minimaCalidad = 'VII';
                        break;
                    case (actv3Total >= 595 && actv3Total <= 649):
                        minimaCalidad = 'VIII';
                        break;
                    case (actv3Total >= 650 && actv3Total <= 700):
                        minimaCalidad = 'IX';
                        break;
                    default:
                        minimaCalidad = 'FALSE';
                }
                document.getElementById('minimaCalidad').innerText = minimaCalidad;
            

            switch (true) {
                case (totalComision >= 301 && totalComision <= 377):
                    minimaTotal = 'I';
                    break;
                case (totalComision >= 378 && totalComision <= 455):
                    minimaTotal = 'II';
                    break;
                case (totalComision >= 456 && totalComision <= 533):
                    minimaTotal = 'III';
                    break;
                case (totalComision >= 534 && totalComision <= 611):
                        minimaTotal = 'IV';
                    break;
                case (totalComision >= 612 && totalComision <= 689):
                    minimaTotal = 'V';
                    break;
                case (totalComision >= 690 && totalComision <= 767):
                    minimaTotal = 'VI';
                    break;
                case (totalComision >= 768 && totalComision <= 845):
                    minimaTotal = 'VII';
                    break;
                case (totalComision >= 846 && totalComision <= 923):
                        minimaTotal = 'VIII';
                    break;
                case (totalComision >= 924 && totalComision <= 1000):
                    minimaTotal = 'IX';
                    break;

                default:
                    minimaTotal = 'FALSE';
            }
            document.getElementById('minimaTotal').innerText = minimaTotal; 
        }

        document.addEventListener('DOMContentLoaded', function () {
                // Obtener el primer input
                var firstInput = document.getElementById('personaEvaluadora1');

                // Obtener los inputs repetidos
                var inputsToUpdate = [
                    document.getElementById('personaEvaluadora2'),
                    document.getElementById('personaEvaluadora3')
                ];

                // Escuchar cambios en el primer input
                firstInput.addEventListener('input', function () {
                    var newValue = firstInput.value;

                    // Actualizar los otros inputs con el nuevo valor
                    inputsToUpdate.forEach(function (input) {
                        input.value = newValue;
                    });
                });
            });

    </script>

</body>

</html>