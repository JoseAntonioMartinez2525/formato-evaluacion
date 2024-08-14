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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/resume.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css" media="print" />
    <script src="{{ asset('js/subtotales.js') }}"></script>
    <script src="{{ asset('js/comisiones.js') }}"></script>
    <script src="{{ asset('js/minimos.js') }}"></script>
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
                        <nav class="nav flex-column printButtonClass">
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#"><i
                                        class="fa-solid fa-user"></i>{{ Auth::user()->email }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('rules') }}">Artículo 10
                                    REGLAMENTO
                                    PEDPD</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser
                                    llenado
                                    por la
                                    Comisión del PEDPD)</a>
                            </li><br>
                            <li id="jsonDataLink" class="d-none">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de
                                    los
                                    Usuarios</a>
                            </li>
                            <li id="reportLink" class="nav-item d-none">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                    Reporte</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="width: 200px;"
                                    href="{{ route('comision_dictaminadora') }}">Apartados 1 y 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="width: 200px;" href="{{ route('docencia') }}">Apartado 3</a>
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
        <!-- Form for Part 3_1 -->
        <form id="form3_1" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form31', 'form3_1');">
            @csrf
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <div>
                <!-- Actividad 3.1 Participación en actividades de diseño curricular -->
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4" id="pMax60" for="">60</label>
                </h4>
            </div>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Actividad</th>
                        <th class="table-ajust2" scope="col"></th>
                        <th class="table-ajust2 cd" scope="col">Puntaje a evaluar</th>
                        <th class="table-ajust2 cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                        <th class="table-ajust2" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>3. Calidad en la docencia</b></td>
                        <td for=""></td>
                        <td for="" id="docencia"></td>
                        <td id="actv3Comision" for=""></td>
        
                        <thead>
                            <tr>
                                <td id="seccion3_1">3.1 Participación en actividades de diseño curricular
                                </td>
                                <td for=""></td>
                                <td id="score3_1" for=""></td>
                            </tr>
                            <thead>
                                <tr>
        
                                <tr>
                                    <td scope="col">
                                        <span class="actividades">Incisos</span>
                                        <span class="actividades">&nbsp &nbsp &nbsp &nbsp Documento</span>
                                        <span class="actividades">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                            &nbsp
                                            Actividad</span>
                                        <span class="actividades"> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                            &nbsp &nbsp &nbsp
                                            &nbsp
                                            Puntaje</span>
                                    </td>
                                    <td><label class="actividades">Cantidad</label></td>
                                    <td><label class="actividades">Subtotal</label></td>
                                </tr>
                                <tr>
                                    <td>a) <label for="">&nbsp</label><label for="">&nbsp</label><label
                                            for="">&nbsp</label><label for="">&nbsp</label><label for="">&nbsp</label><label
                                            for="">&nbsp</label><label for="">&nbsp</label><label for="">&nbsp</label>
                                        <label style="height:84px; width: 170px;">Plan de estudios de una
                                            carrera o posgrado
                                            nuevo
                                            o
                                            actualización</label>
                                        <label style="height:94px; width: 180px;">Responsable de la Comisión
                                            para la elaboración
                                            del
                                            documento</label>
                                        <label for=""></label>
                                        <label for=""></label>
                                        <label for=""></label>
                                        <label for=""></label>
                                        <label id="puntaje60" for=""><b>60</b></label>
        
                                    </td>
        
                                    <td class="elabInput"><label id="elaboracion">0</label></td>
                                    <td><label id="elaboracionSubTotal1" for="" type="text"></label></td>
                                    <td class="comision actv"><input id="comisionIncisoA" placeholder="0" for=""
                                            oninput="onActv3Comision()"></input></td>
                                    <td><input id="obs3_1_1" name="obs3_1_1" class="table-header" type="text"></td>
                                    <thead>
                                        <tr>
                                            <td>b)
                                                <label for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label>
                                                <label style="height:84px; width: 170px;">Plan de estudios
                                                    de una carrera o posgrado
                                                    nuevo
                                                    o actualización</label>
                                                <label style="height:84px; width: 180px;">Colaboración en la
                                                    Comisión para la
                                                    elaboración
                                                    del documento</label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label id="puntaje40" for=""><b>40</b></label>
                                            </td>
                                            <td class="elabInput"><label id="elaboracion2">0</label></td>
                                            <td><label id="elaboracionSubTotal2" for="" type="text"></label>
                                            </td>
                                            <td class="comision actv"><input id="comisionIncisoB" placeholder="0" for=""
                                                    oninput="onActv3Comision()"></input></td>
                                            <td><input id="obs3_1_2" name="obs3_1_2" class="table-header" type="text"></td>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td>c)
                                                <label for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label>
                                                <label style="height:84px; width: 170px;">Plan de estudios
                                                    de una carrera o posgrado
                                                    nuevo
                                                    o actualización</label>
                                                <label style="height:84px; width: 180px;">Elaboración de
                                                    contenidos mínimos</label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label id="puntaje10" for=""><b>10</b></label>
                                            </td>
                                            <td class="elabInput"><label id="elaboracion3">0</label></td>
                                            <td><label id="elaboracionSubTotal3" for="" type="text"></label>
                                            </td>
                                            <td class="comision actv"><input id="comisionIncisoC" placeholder="0" for=""
                                                    oninput="onActv3Comision()"></input></td>
                                            <td><input id="obs3_1_3" name="obs3_1_3" class="table-header" type="text"></td>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td>d)
                                                <label for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label>
                                                <label style="height:84px; width: 170px;">Plan de estudios
                                                    de una carrera o posgrado
                                                    nuevo
                                                    o actualización</label>
                                                <label style="height:84px; width: 180px;">Elaboración de
                                                    programas de
                                                    asignatura</label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label for=""></label>
        
                                                <label id="puntaje20" for=""><b>20</b></label>
                                            </td>
                                            <td class="elabInput"><label id="elaboracion4">0</label></td>
                                            <td><label id="elaboracionSubTotal4" for="" type="text"></label>
                                            </td>
                                            <td class="comision actv"><input id="comisionIncisoD" placeholder="0" for=""
                                                    oninput="onActv3Comision()"></input></td>
                                            <td><input id="obs3_1_4" name="obs3_1_4" class="table-header" type="text"></td>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td>e)
                                                <label for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label><label
                                                    for="">&nbsp</label><label for="">&nbsp</label>
                                                <label style="height:84px; width: 170px;">Plan de estudios
                                                    de una carrera o posgrado
                                                    nuevo
                                                    o actualización</label>
                                                <label style="height:84px; width: 180px;">Actualización de
                                                    programas de
                                                    asignatura</label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label for=""></label>
                                                <label id="p10" for=""><b>10</b></label>
                                            </td>
                                            <td class="elabInput"><label id="elaboracion5">0</label></td>
                                            <td><label id="elaboracionSubTotal5" for="" type="text"></label>
                                            </td>
                                            <td class="comision actv"><input id="comisionIncisoE" placeholder="0" for=""
                                                    oninput="onActv3Comision()"></input></td>
                                            <td><input id="obs3_1_5" name="obs3_1_5" class="table-header" type="text"></td>
                                        </tr>
                                    </thead>
                                </tr>
                    </tr>
                    </tr>
        
                    </thead>
                </tbody>
            </table>
        
            <!--Tabla informativa Acreditacion Actividad 3.1-->
            <table>
                <thead>
                    <tr><br>
        
                        <th class="acreditacion" scope="col">Acreditacion: </th>
        
                        <th class="descripcion"><b>H.CGU</b> puntos a,b y e; <b>CAAC</b> puntos d y e</th>
                        <th> <button id="btn3_1" type="submit" class="btn btn-primary printButtonClass">Enviar</th>
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
                            console.log(data);  // Inspect the structure returned

                            const score3_1 = document.getElementById('score3_1');
                            if (score3_1) {
                                score3_1.textContent = data.form3_1 ? data.form3_1.score3_1 || '0' : '0';
                            }

                            const elaboracion = document.getElementById('elaboracion');
                            if (elaboracion) {
                                elaboracion.textContent = data.form3_1 ? data.form3_1.elaboracion || '0' : '0';
                            }

                            const elaboracionSubTotal1 = document.getElementById('elaboracionSubTotal1');
                            if (elaboracionSubTotal1) {
                                elaboracionSubTotal1.textContent = data.form3_1 ? data.form3_1.elaboracionSubTotal1 || '0' : '0';
                            }

                            const elaboracion2 = document.getElementById('elaboracion2');
                            if (elaboracion2) {
                                elaboracion2.textContent = data.form3_1 ? data.form3_1.elaboracion2 || '0' : '0';
                            }

                            const elaboracionSubTotal2 = document.getElementById('elaboracionSubTotal2');
                            if (elaboracionSubTotal2) {
                                elaboracionSubTotal2.textContent = data.form3_1 ? data.form3_1.elaboracionSubTotal2 || '0' : '0';
                            }

                            const elaboracion3 = document.getElementById('elaboracion3');
                            if(elaboracion3){
                                elaboracion3.textContent = data.form3_1.elaboracion3 || '0';
                            }
                            const elaboracionSubTotal3 = document.getElementById('elaboracionSubTotal3');
                            if(elaboracionSubTotal3){
                                elaboracionSubTotal3.textContent = data.form3_1.elaboracionSubTotal3 || '0';
                            }
                            const elaboracion4 = document.getElementById('elaboracion4');
                            if(elaboracion4){
                                elaboracion4.textContent = data.form3_1.elaboracion4 || '0';
                            }
                            const elaboracionSubTotal4 = document.getElementById('elaboracionSubTotal4');
                            if(elaboracionSubTotal4){
                                elaboracionSubTotal4.textContent = data.form3_1.elaboracionSubTotal4 || '0';
                            }
                            const elaboracion5 = document.getElementById('elaboracion5');
                            if(elaboracion5){
                                elaboracion5.textContent = data.form3_1.elaboracion5 || '0';
                            }
                            const elaboracionSubTotal5 = document.getElementById('elaboracionSubTotal5');
                            if(elaboracionSubTotal5){
                                elaboracionSubTotal5.textContent = data.form3_1.elaboracionSubTotal5 || '0';
                            }


                            document.querySelector('input[name="user_id"]').value = data.form3_1.user_id || '';
                            document.querySelector('input[name="email"]').value = data.form3_1.email || '';
                            document.querySelector('input[name="user_type"]').value = data.form3_1.user_type || '';
                            

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
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;

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


        function minWithSum(value1, value2) {
            const sum = value1 + value2;
            return Math.min(sum, 200);


        }

    document.addEventListener('DOMContentLoaded', function () {
        // Get the canvas element
        var canvas = document.getElementById('convocatoria');
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
        var convocatoria = document.getElementById('convocatoria');

    });


    </script>

    <section>
        <div>
    
            <canvas id="convocatoria" width="1500" height="500"></canvas>
        </div>
    
    </section>
</body>

</html>