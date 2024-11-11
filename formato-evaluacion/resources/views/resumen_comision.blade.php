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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/resumen_comision.js') }}"></script>
</head>
<style>
    #nivelLabel{
    padding-right: 190px;
}

 #minimaCalidad{
    padding-left: 120px;
 }

#minimaTotal{
    padding-left: 120px;
}

.evaluadores{
    background-color: rgb(232, 240, 254); 
    width: 300px;
}

</style>
<body class="bg-gray-50 text-black/50">

    <div class="relative min-h-screen flex flex-col items-center justify-center">
        @if (Route::has('login'))
                                                                        @if (Auth::check())
                                                                            <section role="region" aria-label="Response form">
                                                                                <form class="printButtonClass">
                                                                                    @csrf
                                                                                    <nav class="nav flex-column" style="padding-top: 50px; height: 900px; background-color: #afc7ce;">
                                                                                        <div class="nav-header" style="display: flex; align-items: center; padding-top: 50px;">
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link disabled enlaceSN" style="font-size: medium;" href="#">
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
                                                                                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('rules') }}">Artículo 10
                                                                                                REGLAMENTO
                                                                                                PEDPD</a>
                                                                                        </li>
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('resumen_comision') }}">Resumen (A ser
                                                                                                llenado
                                                                                                por la
                                                                                                Comisión del PEDPD)</a>
                                                                                        </li><br>
                                                                                        <li id="reportLink" class="nav-item d-none">
                                                                                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                                                                                Reporte</a>
                                                                                        </li>
                                                                                        <li class="nav-item">
                                                                                            @if(Auth::user()->user_type === 'dictaminador')
                                                                                                <a class="nav-link active enlaceSN" style="width: 200px;"
                                                                                                    href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                                                                                            @else
                                                                                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('secretaria') }}">Selección de
                                                                                                    Formatos</a>
                                                                                            @endif
                                                                                        </li>
                                                                                        <li id="jsonDataLink" class="d-none">
                                                                                            <a class="enlaceSN" href="{{ route('json-generator') }}" class="btn btn-primary" style="display: none;">Mostrar datos de los
                                                                                                Usuarios</a>
                                                                                        </li>
                                                                                    </nav>
                                                                                </form>
                                                                            </section>
                                                                        @endif

                                                                    </div>
                                                                    <x-general-header />
                                                            @php
    $user = Auth::user();
    $userType = $user->user_type;
    $user_email = $user->email;
    $user_identity = $user->id; 
                                                            @endphp
                                                                <div class="container mt-4" id="seleccionDocente">
                                                                    @if($userType !== 'docente')
                                                                        <!-- Select para dictaminador seleccionando docentes -->
                                                                        <label for="docenteSelect">Seleccionar Docente:</label>
                                                                        <select id="docenteSelect" class="form-select"> <!--name="docentes[]" multiple-->
                                                                            <option value="">Seleccionar un docente</option>
                                                                            <!-- Aquí se llenarán los docentes con JavaScript -->
                                                                        </select>
                                                                    @endif
                                                                </div>
                                                                            <main class="container" id="formContainer" style="display: none;">
                                                                            <form id="form4" method="POST" enctype="multipart/form-data"
                                                                            onsubmit="event.preventDefault(); submitForm('/store-resume', 'form4');">
                                                                            @csrf
                                                                            <div>
                                                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                                            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
                                                                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                                                            <input type="hidden" name="user_type" value="{{ Auth::user()->user_type }}">
                                                                            <center>
                                                                            <h2 id="resumen">Resumen</h2>
                                                                            <h4>A ser llenado por la Comisión del PEDPD</h4>
                                                                            </center>
                                                                            <table class="resumenTabla">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th id="actv">Actividad</th>
                                                                                    <th id="pMaximo">Puntaje máximo</th>
                                                                                    <th id="pComision">Puntaje otorgado Comisión PEDPD</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="data">
                                                                                <!-- Aquí se llenarán los datos del dictaminador con JavaScript -->
                                                                            </tbody>
                                                                            </table>
                                                                            <table>
                                                                            <thead>
                                                                                <tr>
                                                                                    <th id="nivelLabel">Nivel obtenido de acuerdo al artículo 10 del Reglamento</th>
                                                                                    <th colspan="1" id="minimaLabel">Mínima de Calidad</th>
                                                                                    <th colspan="2" id="minimaCalidad"></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <th style="padding-right: 200px;"></th>
                                                                                    <th class="minima">Mínima Total</th>
                                                                                    <th id="minimaTotal"></th>
                                                                            <thead>
                                                                                <!--
                                                                                <tr>
                                                                                    <th style="margin-right:800px;">
                                                                                        @if(Auth::user()->user_type === 'dictaminador')
                                                                                        <button type="submit" class="btn custom-btn buttonSignature">Enviar</button>
                                                                                    @endif                                                                                   
                                                                                    </th>

                                                                                </tr>-->
                                                                            </thead>
                                                                            </tbody>
                                                                            </table>

                                                                            </div>
                                                                            </form>

                                                                                <form id="form5" method="POST" enctype="multipart/form-data"
                                                                                    onsubmit="event.preventDefault(); submitForm('/store-evaluator-signature', 'form5');">
                                                                                    @csrf
                                                                                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                                                                                    <input type="hidden" name="email" id="email" value="{{ auth()->user()->email }}">
                                                                                    <input type="hidden" name="user_type" id="user_type" value="{{ auth()->user()->user_type }}">
                                                                                    <input type="hidden" name="dictaminador_id" value="{{ $user_identity }}">


                                                                                    <table>
                                                                                        <thead>
                                                                                            <tr id="eva1">
                                                                                            <th class="evaluadores">
                                                                                                @if($userType === '')
                                                                                                    <span class="personaEvaluadora" type="text" id="personaEvaluadora"></span>
                                                                                                @elseif($userType === 'dictaminador')
                                                                                                    <!-- Implementación en caso que el usuario sea 'dictaminador' -->
                                                                                                    @if(empty($personaEvaluadora))
                                                                                                        <input class="personaEvaluadora1" type="text" id="personaEvaluadora1" style="background:transparent;border: 15px rgba(0, 0, 0, 0);" name="evaluator_name" required>
                                                                                                    @else
                                                                                                        <input class="personaEvaluadora2" type="text" id="personaEvaluadora2" style="background:transparent;border: 15px rgba(0, 0, 0, 0);" name="evaluator_name_2" required> 
                                                                                                        @if((!empty($personaEvaluadora1)) && (!empty($personaEvaluadora2)))
                                                                                                            <input class="personaEvaluadora3" type="text" id="personaEvaluadora3" style="background:transparent;border: 15px rgba(0, 0, 0, 0);" name="evaluator_name_3" required>               
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @endif
                                                                                            </th>
                                                                                            <th>
                                                                                            @if($userType === 'dictaminador')
                                                                                                @if(empty($signature_path))
                                                                                                    <input type="file" class="form-control" id="firma1" name="firma" accept="image/*">
                                                                                                @elseif(empty($signature_path_2))
                                                                                                    <input type="file" class="form-control" id="firma2" name="firma" accept="image/*">
                                                                                                @elseif(empty($signature_path_3))
                                                                                                    <input type="file" class="form-control" id="firma3" name="firma" accept="image/*">
                                                                                                @else
                                                                                                    <span>Ya se han completado las firmas requeridas.</span>
                                                                                                @endif
                                                                                            @endif
                                                                                            </th>
                                                                                            <th>
                                                                                                <!-- Aquí se mostrará la firma 1 si ya ha sido subida -->
                                                                                                @if(!empty($signature_path))
                                                                                                    <img id="signature_path" src="{{ asset('storage/' . $signature_path) }}" alt="Firma 1" class="imgFirma">
                                                                                                @endif
                                                                                                @if(!empty($signature_path_2))
                                                                                                    <img id="signature_path_2" src="{{ asset('storage/' . $signature_path_2) }}" alt="Firma 2" class="imgFirma">
                                                                                                @endif
                                                                                                @if(!empty($signature_path_3))
                                                                                                    <img id="signature_path_3" src="{{ asset('storage/' . $signature_path_3) }}" alt="Firma 3" class="imgFirma">
                                                                                                @endif
                                                                                            </th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="p-2 nombreLabel">Nombre de la persona evaluadora</td>
                                                                                                <td></td>
                                                                                                <td class="p-2"><span id="firmaTexto">Firma</span>
                                                                                                    @if($userType === 'dictaminador')
                                                                                                        <small class="text-muted">Tamaño máximo permitido: 2MB</small>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            @if($userType === '')
                                                                                            <tr id=eva2>
                                                                                                <th class="evaluadores">
                                                                                                        <span class="personaEvaluadora2" type="text" id="personaEvaluadora2"></span>
                                                                                                </th>
                                                                                            </tr>
                                                                                            @endif
                                                                                            <tr>
                                                                                                @if($userType === '')
                                                                                                    <td class="p-2 nombreLabel">Nombre de la persona evaluadora</td>
                                                                                                    <td></td>
                                                                                                    <td class="p-2"><span id="firmaTexto2">Firma</span>
                                                                                                @endif
                                                                                            </tr>
                                                                                            @if($userType === '')
                                                                                                <tr id="eva3">
                                                                                                    <th class="evaluadores">

                                                                                                            <span class="personaEvaluadora3" type="text" id="personaEvaluadora3"></span>

                                                                                                </th>
                                                                                            </tr>@endif
                                                                                            <tr>
                                                                                                @if($userType === '')
                                                                                                    <td class="p-2 mr-2 nombreLabel">Nombre de la persona evaluadora</td>
                                                                                                    <td></td>
                                                                                                    <td class="p-2"><span id="firmaTexto3">Firma</span>
                                                                                                @endif
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="padding-left: 600px;">
                                                                                                    @if(Auth::user()->user_type === 'dictaminador')
                                                                                                        <button type="submit" class="btn custom-btn buttonSignature2">Enviar</button>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
        @endif
</thead>
</table><br>
<footer id="convocatoria"></footer>
</form>

                        </main>


    </div>

    <div>

    </div>
    </div>
    </div>
    </div>

    <script>
    const labels = [
        '1. Permanencia en las actividades de la docencia  ',
        '1.1 Años de experiencia docente en la institución  ',
        '2. Dedicación en el desempeño docente  ',
        '2.1 Carga de trabajo docente frente a grupo  ',
        '3. Calidad en la docencia  ',
        '3.1 Participación en actividades de diseño curricular  ',
        '3.2 Calidad del desempeño docente evaluada por los estudiantes ',
        '3.3 Publicaciones relacionadas con la docencia',
        '3.4 Distinciones académicas recibidas por el docente',
        '3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC',
        '3.6 Capacitación y actualización pedagógica recibida',
        '3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento',
        '3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente',
        'Subtotal ',
        'Tutorias',
        '3.9 Trabajos dirigidos para la titulación de estudiantes',
        '3.10 Tutorías a estudiantes',
        '3.11 Asesoría a estudiantes',
        'Subtotal',
        'Investigación',
        '3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte el docente',
        '3.13 Proyectos académicos de investigación',
        '3.14 Participación como ponente en congresos o eventos académicos del área de conocimiento o afines del docente',
        '3.15 Registro de patentes y productos de investigación tecnológica y educativa',
        '3.16 Actividades de arbitraje, revisión, corrección y edición',
        'Subtotal',
        'Cuerpos colegiados',
        '3.17 Proyectos académicos de extensión y difusión',
        '3.18 Organización de congresos o eventos institucionales del área de conocimiento del Docente',
        '3.19 Participación en cuerpos colegiados',
        'Subtotal',
        'Total logrado en la evaluación',
        '1. Permanencia en las actividades de la docencia ',
        '2. Dedicación en el desempeño docente',
        '3. Calidad en la docencia',
        'Total de puntaje obtenido en la evaluación',
    ];

    const values = [100, 100, 200, 200, 700, 60, 50, 100, 60, 75, 40, 40, 40, null, null,
        200, 115, 95, null, null, 150, 130, 40, 60, 30, null, null, 50, 40, 40, null, null, 100, 200, 700, null];

        function handleClick(event) {
            var currentTarget = event.currentTarget;
            // Use the event data here. 
            console.log('Button clicked: ' + currentTarget.getAttribute('data-id'));
        } document.addEventListener('DOMContentLoaded', onload);

        function actualizarResultados(sumaComision3, totalLogrado) {
                const minimaCalidad = evaluarCalidad(sumaComision3);
                const minimaTotal = evaluarTotal(totalLogrado);

                // Actualizar el DOM con los valores calculados
                document.getElementById('minimaCalidad').textContent = minimaCalidad;
                document.getElementById('minimaTotal').textContent = minimaTotal;
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

        /*
 


                            //form5
                         if(userType === ''){
                             
                             const email = event.target.options[event.target.selectedIndex].dataset.email;
                            

                             axios.get('/get-evaluator-signature', {
                                 params: {
                                     email: email,

                                 }
                             })
                                 .then(function (response) {
                                     const evaluatorResponse = response.data;
                                     if (evaluatorResponse && evaluatorResponse.message !== 'Evaluator signature not found') {
                                         document.getElementById('personaEvaluadora1').innerText = evaluatorResponse.evaluator_name_1 || 'No evaluator name found';
                            

                                         document.getElementById('personaEvaluadora2').innerText = evaluatorResponse.evaluator_name_2 || 'No evaluator name found';
                        
                                         document.getElementById('personaEvaluadora3').innerText = evaluatorResponse.evaluator_name_3 || 'No evaluator name found';
                        


                                         // Mostrar las imágenes de las firmas
                                         const imgFirma1 = document.querySelector('img[data-firma="firma1"]');
                                         if (imgFirma1 && evaluatorResponse.signature_path_1) {
                                             imgFirma1.src = evaluatorResponse.signature_path_1;
                                             imgFirma1.style.display = 'block';
                                             imgFirma1.style.height = '100px';
                                         } else if (imgFirma1) {
                                             imgFirma1.style.display = 'none';
                                         }

                                         const imgFirma2 = document.querySelector('img[data-firma="firma2"]');
                                         if (imgFirma2 && evaluatorResponse.signature_path_2) {
                                             imgFirma2.src = evaluatorResponse.signature_path_2;
                                             imgFirma2.style.display = 'block';
                                             imgFirma2.style.height = '100px';
                                         } else if (imgFirma2) {
                                             imgFirma2.style.display = 'none';
                                         }

                                         const imgFirma3 = document.querySelector('img[data-firma="firma3"]');
                                         if (imgFirma3 && evaluatorResponse.signature_path_3) {
                                             imgFirma3.src = evaluatorResponse.signature_path_3;
                                             imgFirma3.style.display = 'block';
                                             imgFirma3.style.height = '100px';
                                         } else if (imgFirma3) {
                                             imgFirma3.style.display = 'none';

                                             document.getElementById('signature_path_1').src = '/storage/' + (evaluatorResponse.signature_path_1 || 'default.png');
                                             document.getElementById('signature_path_2').src = '/storage/' + (evaluatorResponse.signature_path_2 || 'default.png');
                                             document.getElementById('signature_path_3').src = '/storage/' + (evaluatorResponse.signature_path_3 || 'default.png');
                                         }
                                     } else {
                                         console.error('Evaluator signature not found');
                                     }
                                 })
                                 .catch(function (error) {
                                     console.error('Error:', error);
                                 });

                                 
                             async function fetchConvocatoria(dictaminadorId) {
                                 try {
                                     const response = await axios.get(`/fetch-convocatoria/${dictaminadorId}`, {
                                         headers: {
                                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                             'Content-Type': 'application/json',
                                         }
                                     });

                                     console.log('Response:', response); // Verificar la respuesta
                                     console.log('Data:', response.data); // Verificar los datos
                                     document.getElementById('convocatoria').textContent = response.data.convocatoria;

                                     return response.data.convocatoria;

                                 } catch (error) {
                                     console.error('There was a problem fetching the convocatoria:', error.message);
                                 }
                             }


                             fetchConvocatoria(dictaminadorId);
                                }


                        else if(userType === 'dictaminador'){
                             async function submitForm(url, formId) {
                                 const form = document.getElementById(formId);
                                 if (!form) {
                                     console.error(`Form with id "${formId}" not found.`);
                                     return;
                                 }

                                 if (formId === 'form4') {
                                     letdataValues = getCommodataValues(form);
                                    dataValues['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
                                     // Obtener valores de los labels y spans
                                    dataValues['comision_actividad_1_total'] = document.getElementById('totalComision1').textContent;
                                    dataValues['comision_actividad_2_total'] = document.getElementById('totalComision2').textContent;
                                    dataValues['comision_actividad_3_total'] = document.getElementById('totalComision3').textContent;
                                    dataValues['total_puntaje'] = document.getElementById('totalComisionRepetido').textContent;
                                    dataValues['minima_total'] = document.getElementById('minimaTotal').textContent;
                                    dataValues['minima_calidad'] = document.getElementById('minimaCalidad').textContent;

                                     // Log form data to check values
                                     console.log('Form data for form4: ',dataValues);

                                     try {
                                         const response = await fetch(url, {
                                             method: 'POST',
                                             headers: {
                                                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                 'Content-Type': 'application/json',
                                             },
                                             body: JSON.stringifydataValues),
                                         });

                                         if (!response.ok) {
                                             throw new Error('Network response was not ok');
                                         }

                                         const responseData = await response.json();
                                         console.log('Response received from server:', responseData);
                                     } catch (error) {
                                         console.error('There was a problem with the fetch operation:', error);
                                     }
                                 } else if (formId === 'form5') {
                                     letdataValues = newdata(form);
                                     document.getElementById('reportLink').classList.remove('d-none');

                                     // Agregar los campos comunes
                                     let commonData = getCommodataValues(form);
                                     for (let key in commonData) {
                                        dataValues.append(key, commonData[key]);
                                     }


                                     // evaluator names
                                    dataValues.set('evaluator_name_1', form.querySelector('#personaEvaluadora1').value);
                                    dataValues.set('evaluator_name_2', form.querySelector('#personaEvaluadora2').value);
                                    dataValues.set('evaluator_name_3', form.querySelector('#personaEvaluadora3').value);

                                     // Add files todataValues
                                     ['firma1', 'firma2', 'firma3'].forEach((firma) => {
                                         let fileInput = form.querySelector(`#${firma}`);
                                         if (fileInput.files.length > 0) {
                                            dataValues.append(firma, fileInput.files[0]);
                                         }
                                     });

                                     try {
                                         let response = await fetch(url, {
                                             method: 'POST',
                                             headers: {
                                                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                             },
                                             body:dataValues,
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


                                         // Mostrar todas las firmas
                                         if (data.signature_urls) { // Verifica que existan las URLs de las firmas
                                             const firmas = ['firma1', 'firma2', 'firma3']; // Define tus firmas

                                             firmas.forEach(firma => {
                                                 const img = document.querySelector(`img[data-firma="${firma}"]`); // Selecciona la imagen correspondiente
                                                 if (data.signature_urls[firma]) {
                                                     img.src = data.signature_urls[firma]; // Establece la URL de la firma
                                                     img.style.display = 'block'; // Muestra la imagen
                                                     img.style.maxWidth = '200px'; // Ajusta a 100px
                                                     img.style.height = '100px'; // Mantiene proporción
                                                 } else {
                                                     img.style.display = 'none'; // Oculta la imagen si no hay firma
                                                 }
                                             });
                                         }
                                     } catch (error) {
                                         console.error('There was a problem with the fetch operation:', error);
                                     }
                                 }

                             }
                             window.submitForm = submitForm; 
                        }
                        } catch (error) {
                            console.error('Error fetching data:', error);
                        }
                        
                    } else {
                        formContainer.style.display = 'none'; // Ocultar el formulario si no hay selección
                    }
                    //await fetchConvocatoria(dictaminadorId);
                });
            } 
        }
    }); */

    
document.addEventListener('DOMContentLoaded', async () => {
    const userType = @json($userType); 
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const user_identity = @json($user_identity);
    const docenteSelect = document.getElementById('docenteSelect');
    const dictaminadorSelect = document.getElementById('dictaminadorSelect');
    const formContainer = document.getElementById('formContainer');
    const dataContainer = document.getElementById('data');

    if (docenteSelect) {
        
        try {
            const response = await fetch('/get-docentes');
            const docentes = await response.json();
            
            docentes.forEach(docente => {
                const option = document.createElement('option');
                option.value = docente.email;
                option.textContent = docente.email;
                docenteSelect.appendChild(option);
            });

            docenteSelect.addEventListener('change', async (event) => {
                const email = event.target.value;

                if (email) {
                    // Mantenemos la solicitud a /get-docente-data para obtener los datos del docente

                    const response = await axios.get('/get-docente-data', { params: { email } });
                    const data = response.data;
                    if(data){
                    
                            let actividades = {};

                            //cambiar la logica para acceder a las comisiones desde el id del docente
                           //const comisiones = await fetch('/get-comisiones', {
                                //implementar switch para casos de uso para evitar formularios nulos

                            switch (data) {
                            case 'form2':
                                actividades['comision1'] = response.data.form2 && response.data.form2.comision1 ? response.data.form2.comision1 : 0;
                                console.log(actividades['comision1']);
                                break;
                            case 'form2_2':
                                actividades['actv2Comision'] = response.data.form2_2 && response.data.form2_2.actv2Comision ? response.data.form2_2.actv2Comision : 0;
                                console.log(actividades['actv2Comision']);
                                break;
                            case 'form3_1':
                                actividades['actv3Comision'] = response.data.form3_1 && response.data.form3_1.actv3Comision ? response.data.form3_1.actv3Comision : 0;
                                console.log(actividades['actv3Comision']);
                                default:
                                console.warn('Unexpected form name:', data);
                                break;
                        }
                            
                            
                        for (let i = 2; i <= 19; i++) {
                            actividades[`comision3_${i}`] = data[`form3_${i}`] ? (data[`form3_${i}`].comision3_i || 0) : 0;
                            console.log(actividades[`comision3_${i}`]);
                        }

                            formContainer.style.display = 'block'; // Mostrar formulario

                            // **Evaluator signature retrieval logic:**

                        if (userType === '') { // Only proceed if user type is empty (presumably for evaluators)
                            axios.get('/get-evaluator-signature', {
                                params: {
                                    email: email,
                                }
                            })
                                .then(function (response) {
                                    const evaluatorResponse = response.data;
                                    if (evaluatorResponse && evaluatorResponse.message !== 'Evaluator signature not found') {
                                        document.getElementById('personaEvaluadora1').innerText = evaluatorResponse.evaluator_name_1 || 'No evaluator name found';
                                        document.getElementById('personaEvaluadora2').innerText = evaluatorResponse.evaluator_name_2 || 'No evaluator name found';
                                        document.getElementById('personaEvaluadora3').innerText = evaluatorResponse.evaluator_name_3 || 'No evaluator name found';

                                        // Mostrar las imágenes de las firmas (assuming image elements exist)
                                        const imgFirma1 = document.querySelector('img[data-firma="firma1"]');
                                        if (imgFirma1 && evaluatorResponse.signature_path) {
                                            imgFirma1.src = evaluatorResponse.signature_path;
                                            imgFirma1.style.display = 'block';
                                            imgFirma1.style.height = '100px';
                                        } else if (imgFirma1) {
                                            imgFirma1.style.display = 'none';
                                        }


                                        const imgFirma2 = document.querySelector('img[data-firma="firma2"]');
                                        if (imgFirma2 && evaluatorResponse.signature_path_2) {
                                            imgFirma2.src = evaluatorResponse.signature_path_2;
                                            imgFirma2.style.display = 'block';
                                            imgFirma2.style.height = '100px';
                                        } else if (imgFirma2) {
                                            imgFirma2.style.display = 'none';
                                        }

                                        const imgFirma3 = document.querySelector('img[data-firma="firma3"]');
                                        if (imgFirma3 && evaluatorResponse.signature_path_3) {
                                            imgFirma3.src = evaluatorResponse.signature_path_3;
                                            imgFirma3.style.display = 'block';
                                            imgFirma3.style.height = '100px';
                                        } else if (imgFirma3) {
                                            imgFirma3.style.display = 'none';

                                            document.getElementById('signature_path').src = '/storage/' + (evaluatorResponse.signature_path || 'default.png');
                                            document.getElementById('signature_path_2').src = '/storage/' + (evaluatorResponse.signature_path_2 || 'default.png');
                                            document.getElementById('signature_path_3').src = '/storage/' + (evaluatorResponse.signature_path_3 || 'default.png');
                                        }

                                    } else {
                                        console.error('Evaluator signature not found');
                                    }
                                })
                                .catch(function (error) {
                                    console.error('Error:', error);
                                });
                        } // End of evaluator signature retrieval logic
                            

                            // Aquí realizamos la solicitud para obtener las comisiones de los dictaminadores

                   
                    try {
                        const userIdResponse = await fetch(`/get-user-id?email=${email}`);
                        const userIdData = await userIdResponse.json();

                        if (userIdData.user_id) {
                            const userId = userIdData.user_id;
                            const dictaminatorResponse = await fetch(`/get-dictaminators-responses?user_id=${userId}`);
                            const dictaminatorData = await dictaminatorResponse.json();

                            if (dictaminatorResponse.ok) {
                                // Inicializar comisiones con valores predeterminados
                                let comisiones = Array(35).fill('0');

                                // Asignación de valores con cortocircuito
                                comisiones[0] = data.form2?.comision1 || '0';
                                comisiones[1] = data.form2?.comision1 || '0';
                                comisiones[2] = data.form2_2?.actv2Comision || '0';
                                comisiones[3] = data.form2_2?.actv2Comision || '0';
                                comisiones[5] = data.form3_1?.actv3Comision || '0';
                                comisiones[6] = data.form3_2?.comision3_2 || '0';
                                comisiones[7] = data.form3_3?.comision3_3 || '0';
                                comisiones[8] = data.form3_4?.comision3_4 || '0';
                                comisiones[9] = data.form3_5?.comision3_5 || '0';
                                comisiones[10] = data.form3_6?.comision3_6 || '0';
                                comisiones[11] = data.form3_7?.comision3_7 || '0';
                                comisiones[12] = data.form3_8?.comision3_8 || '0';
                                comisiones[14] = '';
                                comisiones[15] = data.form3_9?.comision3_9 || '0';
                                comisiones[16] = data.form3_10?.comision3_10 || '0';
                                comisiones[17] = data.form3_11?.comision3_11 || '0';
                                comisiones[19] = '';
                                comisiones[20] = data.form3_12?.comision3_12 || '0';
                                comisiones[21] = data.form3_13?.comision3_13 || '0';
                                comisiones[22] = data.form3_14?.comision3_14 || '0';
                                comisiones[23] = data.form3_15?.comision3_15 || '0';
                                comisiones[24] = data.form3_16?.comision3_16 || '0';
                                comisiones[26] = '';
                                comisiones[27] = data.form3_17?.comision3_17 || '0';
                                comisiones[28] = data.form3_18?.comision3_18 || '0';
                                comisiones[29] = data.form3_19?.comision3_19 || '0';
                                comisiones[32] = data.form2?.comision1 || '0';
                                comisiones[33] = data.form2_2?.actv2Comision || '0';

                                // Cálculo de subtotales
                                
                                const subtotales = [
                                    { range: [5, 12], position: 13 }, // Subtotal 1
                                    { range: [15, 17], position: 18 }, // Subtotal 2
                                    { range: [20, 24], position: 25 }, // Subtotal 3
                                    { range: [27, 29], position: 30 }  // Subtotal 4
                                ];

                                subtotales.forEach(({ range, position }) => {
                                    let subtotal = 0;
                                    for (let i = range[0]; i <= range[1]; i++) {
                                        subtotal += parseInt(comisiones[i]) || 0;
                                    }
                                    comisiones[position] = subtotal;
                                    
                                });

                                const sumaComision3 = Math.min(comisiones[13] + comisiones[18] + comisiones[25] + comisiones[30], 700);

                                comisiones[4] = sumaComision3;
                                comisiones[34] = comisiones[4];

                                let tLogrado = parseFloat(comisiones[1]) + parseFloat(comisiones[3]) + parseFloat(comisiones[4]);
                                tLogrado = tLogrado.toFixed(2); 

                                const totalLogrado = tLogrado >= 700 ? Math.min(tLogrado, 700) : tLogrado;
                                
                                comisiones[31] = totalLogrado;
                                comisiones[35] = totalLogrado;
                                let comisionCell;
                                // Generar las filas en la tabla
                                labels.forEach((label, i) => {
                                    const row = document.createElement('tr');
                                    const labelCell = document.createElement('td');
                                    const valueCell = document.createElement('td');
                                     comisionCell = document.createElement('td');

                                    labelCell.textContent = label;
                                    valueCell.textContent = values[i];
                                    comisionCell.textContent = comisiones[i] || '';

                                    // Aplicar estilos
                                    if (['Subtotal ', 'Subtotal', 'Tutorias', 'Investigación', 'Cuerpos colegiados', 'Total logrado en la evaluación', 'Total de puntaje obtenido en la evaluación'].includes(label)) {
                                        labelCell.style.fontWeight = 'bold';
                                        labelCell.style.textAlign = 'center';
                                    }

                                    if (![0, 2, 4, 13, 14, 18, 19, 25, 26, 30, 31].includes(i)) {
                                        comisionCell.style.backgroundColor = '#f6c667';
                                        comisionCell[i] = comisiones[i].toString();
                                    }

                                    if ([0, 2, 4, 13, 18, 25, 30, 31, 35].includes(i)) {
                                        comisionCell.style.fontWeight = 'bold';
                                    }

                                    if (i === 35) {
                                        comisionCell.style.backgroundColor = 'transparent';
                                    }

                                    // Insertar valores específicos
                                    if (i === 4) comisionCell.textContent = sumaComision3.toString();
                                    if ([13, 18, 25, 30].includes(i)) comisionCell.textContent = comisiones[i];
                                    if (i === 31) comisionCell.textContent = totalLogrado.toString();

                                    comisionCell.style.textAlign = 'center';
                                    row.appendChild(labelCell);
                                    row.appendChild(valueCell);
                                    row.appendChild(comisionCell);
                                    dataContainer.appendChild(row);
                                });

                                                                // Actualizar convocatoria
                                const convocatoriaElement = document.getElementById('convocatoria');
                                if (convocatoriaElement) {
                                    if (data.form1) {
                                        convocatoriaElement.textContent = data.form1.convocatoria || '';
                                    } else {
                                        console.error('form1 no está definido en la respuesta.');
                                    }
                                } else {
                                    console.error('Elemento con ID "convocatoria" no encontrado.');

                                }

                                for (let i = 0; i <= comisiones.length; i++) {
                                    switch (i) {
                                        case 0: comisionCell.innerHTML = comisiones[i] || data.form2?.comision1;
                                        break;
                                        case 1:
                                            comisionCell.innerHTML = comisiones[i] || data.form2?.comision1; // Asignación estándar
                                            break;
                                        case 2: comisionCell.innerHTML = comisiones[i] || data.form2_2?.actv2Comision; break;
                                        case 3:
                                            comisionCell.innerHTML = comisiones[i] || data.form2_2?.actv2Comision; // Asignación estándar
                                            break;
                                        case 4:
                                            comisionCell.innerHTML = sumaComision3.toString(); // Valor calculado
                                            break;
                                        case 5:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_1?.actv3Comision || '0'; // comision3_1
                                            break;
                                        case 6:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_2?.comision3_2 || '0'; // comision3_2
                                            break;
                                        case 7:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_3?.comision3_3 || '0'; // comision3_3
                                            break;
                                        case 8:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_4?.comision3_4 || '0'; // comision3_4
                                            break;
                                        case 9:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_5?.comision3_5 || '0'; // comision3_5
                                            break;
                                        case 10:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_6?.comision3_6 || '0'; // comision3_6
                                            break;
                                        case 11:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_7?.comision3_7 || '0'; // comision3_7
                                            break;
                                        case 12:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_8?.comision3_8 || '0'; // comision3_8
                                            break;
                                        case 13:
                                            comisionCell.innerHTML = comisiones[i].toString(); // Valor calculado
                                            break;
                                        case 15:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_9?.comision3_9 || '0'; // comision3_9
                                            break;
                                        case 16:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_10?.comision3_10 || '0'; // comision3_10
                                            break;
                                        case 17:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_11?.comision3_11 || '0'; // comision3_11
                                            break;
                                        case 18:
                                            comisionCell.innerHTML =  comisiones[i].toString(); // Valor calculado
                                            break;
                                        case 20:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_12?.comision3_12 || '0'; // comision3_12
                                            break;
                                        case 21:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_13?.comision3_13 || '0'; // comision3_13
                                            break;
                                        case 22:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_14?.comision3_14 || '0'; // comision3_14
                                            break;
                                        case 23:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_15?.comision3_15 || '0'; // comision3_15
                                            break;
                                        case 24:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_16?.comision3_16 || '0'; // comision3_16
                                            break;
                                        case 25:
                                            comisionCell.innerHTML =  comisiones[i].toString(); // Valor calculado
                                            break;
                                        case 27:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_17?.comision3_17 || '0'; // comision3_17
                                            break;
                                        case 28:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_18?.comision3_18; // comision3_18
                                            break;
                                        case 29:
                                            comisionCell.innerHTML = comisiones[i] || data.form3_19?.comision3_19; // comision3_19
                                            break;
                                        case 30:
                                            comisionCell.innerHTML =  comisiones[i].toString(); // Valor calculado
                                            break;
                                        case 31:
                                            comisionCell.innerHTML = totalLogrado.toString(); // Valor calculado
                                            break;
                                        case 32:
                                            comisionCell.innerHTML = comisiones[i] || data.form2?.comision1; // Asignación estándar
                                            break;
                                        case 33: comisionCell.innerHTML = comisiones[i] || data.form2_2?.actv2Comision;
                                            break;
                                        case 34:
                                            comisionCell.innerHTML = sumaComision3.toString(); // Valor calculado
                                            break;
                                        case 35:
                                            comisionCell.innerHTML = totalLogrado.toString(); // Valor calculado
                                            break;
                                        case 36:
                                            comisionCell.innerHTML = totalLogrado.toString(); // Valor calculado
                                            break;                                            
                                        default:
                                            comisionCell.innerHTML = '0'; // Valor por defecto si no coincide con ningún caso
                                    }
                                }


                                console.log(comisionCell.innerHTML);
                                console.log(comisiones.toString());

                                actualizarResultados(comisiones[4], totalLogrado);

                            // Enviar el formulario después de generar la tabla
                                await submitForm('store-evaluator-signature', 'form5', user_identity, email);


                            }
                            //wait submitForm('store-evaluator-signature', 'form5');

                        }

                    } catch (error) {
                        console.error("Error al procesar los datos:", error);
                    }


                     }
                    else {
                        console.error('Error fetching docente data:', error);
                    }
                    
                }

                
            });
        } catch (error) {
            console.error('Error fetching docentes:', error);
            alert('No se pudo cargar la lista de docentes.');
        }


        
    }else{
        console.warn("El elemento docenteSelect no se encontró en el DOM.");
    }
});

//metodos para user secretaria y user_dictaminador -> caso POST
/*if(userType === ''){
    const email = event.target.options[event.target.selectedIndex].dataset.email;


    axios.get('/get-evaluator-signature', {
        params: {
            email: email,

        }
    })
        .then(function (response) {
            const evaluatorResponse = response.data;
            if (evaluatorResponse && evaluatorResponse.message !== 'Evaluator signature not found') {
                document.getElementById('personaEvaluadora1').innerText = evaluatorResponse.evaluator_name_1 || 'No evaluator name found';


                document.getElementById('personaEvaluadora2').innerText = evaluatorResponse.evaluator_name_2 || 'No evaluator name found';

                document.getElementById('personaEvaluadora3').innerText = evaluatorResponse.evaluator_name_3 || 'No evaluator name found';



                // Mostrar las imágenes de las firmas
                const imgFirma1 = document.querySelector('img[data-firma="firma1"]');
                if (imgFirma1 && evaluatorResponse.signature_path_1) {
                    imgFirma1.src = evaluatorResponse.signature_path_1;
                    imgFirma1.style.display = 'block';
                    imgFirma1.style.height = '100px';
                } else if (imgFirma1) {
                    imgFirma1.style.display = 'none';
                }

                const imgFirma2 = document.querySelector('img[data-firma="firma2"]');
                if (imgFirma2 && evaluatorResponse.signature_path_2) {
                    imgFirma2.src = evaluatorResponse.signature_path_2;
                    imgFirma2.style.display = 'block';
                    imgFirma2.style.height = '100px';
                } else if (imgFirma2) {
                    imgFirma2.style.display = 'none';
                }

                const imgFirma3 = document.querySelector('img[data-firma="firma3"]');
                if (imgFirma3 && evaluatorResponse.signature_path_3) {
                    imgFirma3.src = evaluatorResponse.signature_path_3;
                    imgFirma3.style.display = 'block';
                    imgFirma3.style.height = '100px';
                } else if (imgFirma3) {
                    imgFirma3.style.display = 'none';

                    document.getElementById('signature_path_1').src = '/storage/' + (evaluatorResponse.signature_path_1 || 'default.png');
                    document.getElementById('signature_path_2').src = '/storage/' + (evaluatorResponse.signature_path_2 || 'default.png');
                    document.getElementById('signature_path_3').src = '/storage/' + (evaluatorResponse.signature_path_3 || 'default.png');
                }
            } else {
                console.error('Evaluator signature not found');
            }
        })
        .catch(function (error) {
            console.error('Error:', error);
        });
} */
    async function submitForm(url, formId, id, email) {
        const form = document.getElementById(formId);
        let dataValues = new FormData(form);
        //let dictaminadorId = document.querySelector('input[name="dictaminador_id"]').value;

        if (!form) {
            console.error(`Form with id "${formId}" not found.`);
            return;
        }


        document.getElementById('reportLink').classList.remove('d-none');

        const evaluatorNames = getEvaluatorNames();
        evaluatorNames.forEach((name, index) => {
            dataValues.append(`evaluator_name_${index + 1}`, name);
        });

        // Agregar los campos comunes
        let commonData = getCommodataValues(form);
        for (let key in commonData) {
            dataValues.append(key, commonData[key]);
        }

    dataValues.append('user_id', id); // Assuming 'id' contains the user ID
    dataValues.append('email', email);

        //dataValues.append('dictaminador_id', dictaminadorId);
        try {
            let response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: dataValues,
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

            // Si el envío es exitoso, recarga las firmas
            await loadSignatures();

        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
        }
    }

window.submitForm = submitForm;


    async function fetchData(url, params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const fullUrl = `${url}?${queryString}`;

        try {
            const response = await axios.get(fullUrl, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            });

            console.log('Response:', response); // Verificar la respuesta
            console.log('Data:', response.data); // Verificar los datos
            return response.data;
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error.message);
        }
    }

    async function loadSignatures() {
            let data = await fetchData('/get-evaluator-signature', {
                user_id: userId,
                email: email,
                user_type: userType
            });

            if (data) {
                // Si las URLs de las firmas están disponibles, las mostramos
                console.log('Datos de firma recibidos:', data);

                // Verificar si los elementos imgFirma existen antes de asignarles src
                let imgFirma1 = document.getElementById('Firma1');
                let imgFirma2 = document.getElementById('Firma2');
                let imgFirma3 = document.getElementById('Firma3');
                const img = document.querySelector(`img[data-firma="${firma}"]`);

                if (data.signature_path && imgFirma1) {
                    imgFirma1.src = data.signature_path;
                    imgFirma1.style.display = 'block';
                    imgFirma1.style.maxWidth = '200px';
                    imgFirma1.style.height = '100px';
                }
                if (data.signature_path_2 && imgFirma2) {
                    imgFirma2.src = data.signature_path_2;
                    imgFirma2.style.display = 'block';
                    imgFirma2.style.maxWidth = '200px';
                    imgFirma2.style.height = '100px';
                }
                if (data.signature_path_3 && imgFirma3) {
                    imgFirma3.src = data.signature_path_3;
                    imgFirma3.style.display = 'block';
                    imgFirma3.style.maxWidth = '200px';
                    imgFirma3.style.height = '100px';
                }
            } else {
                console.error('Error: Signature data not found.');
                img.style.display = 'none';
            }

        }

    function getCommodataValues(form) {
        const data = {};

        //data['user_id'] = form.querySelector('input[name="user_id"]').value;
        //data['email'] = form.querySelector('input[name="email"]').value;
        data['user_type'] = form.querySelector('input[name="user_type"]').value;
        console.log('user_type value: ',data['user_type']);
        return data;
        }
       
    function getEvaluatorNames() {
            const evaluators = document.querySelectorAll('.personaEvaluadora');
            return Array.from(evaluators).map(evaluator => evaluator.textContent.trim());
        }
    
    </script>

<div id="app" data-user-id="{{ auth()->user()->id }}" data-user-email="{{ auth()->user()->email }}"
    data-user-type="{{ auth()->user()->user_type }}"
     style="display: none;"></div>>
</div>


</body>

</html>