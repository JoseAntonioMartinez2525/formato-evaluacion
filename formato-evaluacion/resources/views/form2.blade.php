@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Permanencia en las actividades de la docencia</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-head-resources />
</head>
<style>
    .datosPrimarios{
        margin-left: 50px;
    }

    @media print{
    .datosPrimarios{
        margin-left: 100px;
        font-size: .8rem;
    }
}

    .datosConvocatoria{
        margin-left:80px;
    }
    @media print{
        .datosConvocatoria{
            font-size: .8rem;
            margin-left: 100px;
        }


        page-break-after: auto; /* La última página no necesita salto extra */  
    }

    body.dark-mode #convocatoria2, body.dark-mode #periodo2, body.dark-mode #nombre2, 
    body.dark-mode #area2, body.dark-mode #departamento2 {
    background-color:transparent;
    color: #ffffff;
    font-weight: bold;
}

    
</style>
<body class="bg-gray-50 text-black/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        @if (Route::has('login'))
            @if (Auth::check())

                <section role="region" aria-label="Response form">
                    <form class="printButtonClass">
                        @csrf
                    <nav class="nav flex-column" style="padding-top: 50px; height: 900px; background-color: #afc7ce;" id="navPrint">
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
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('rules') }}">Artículo 10 REGLAMENTO PEDPD</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser llenado por la
                                Comisión del PEDPD)</a>
                        </li><br>
                        <li id="jsonDataLink" class="d-none">
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de los Usuarios</a>
                        </li>
                        <li id="reportLink" class="nav-item d-none">
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('perfil') }}">Mostrar Reporte</a>
                        </li>
                        <li class="nav-item">
                        @if(Auth::user()->user_type === 'dictaminador')
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                        @else
                            <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('secretaria') }}">Selección de Formatos </a>
                        @endif
                        </li>
                    </nav>
                    </form>
                </section>

            @endif
        @endif
    </div>
    <x-general-header />
    
@php
$user = Auth::user();
$userType = $user->user_type;
$user_identity = $user->id; 
@endphp
<button id="toggle-dark-mode" class="btn btn-secondary printButtonClass"><i class="fa-solid fa-moon"></i>&nbspModo Obscuro</button>
<div class="container mt-4 printButtonClass">
    @if($userType !== 'docente')
        <!-- Select para dictaminador seleccionando docentes -->
        <label for="docenteSelect">Seleccionar Docente:</label>
        <select id="docenteSelect" class="form-select"> <!--name="docentes[]" multiple-->
            <option value="">Seleccionar un docente</option>
            <!-- Aquí se llenarán los docentes con JavaScript -->
        </select>
    @endif
</div>

<form class="mostrar">
    <main class="container">
        <!-- Form for Part 2 -->
        <form id="form2" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form2', 'form2');">
            @csrf
            <div><br>
             <div class="datosConvocatoria">
                <label for="convocatoria">Convocatoria:</label>
                <span class="input-header" id="convocatoria2"></span><br>

                <label for="periodo">Periodo de evaluación:</label>
                <span id="periodo2" type="text" class="input-header"></span><br>

                <label for="nombre">Nombre del personal académico:</label>
                <span id="nombre2" class="input-header"></span><br>

                <label for="area">Área de Conocimiento:</label>
                <span id="area2" class="input-header"></span><br>

                <label for="departamento">Departamento Académico:</label>
                <span id="departamento2" class="input-header"></span>
             </div><br>   
            
            
            <center class="printCenter"><h5>Instrucciones</h5></center>
            
            <div class="container flex">
                <p class="instrucciones">1 La persona a ser evaluada deberá completar la información en
                    cantidades u horas en los campos
                    marcados en <u>color gris</u>. <br>
                    2 La Comisión Dictaminadora deberá llenar los campos marcados en color azul cielo (puntajes totales o
                    subtotales, según sea el caso). <br>
                    3 No se deberán modificar fórmulas, ni agregar o quitar renglones. <br>
                    4 Este formato deberá presentarse en forma independiente de la documentación que acrediten las
                    actividades realizadas. <b>Para la evaluación no es necesario entregar las obras completas-libros,
                    manuales, publicaciones,etc.,</b> sino entregar el documento probatorio que se indique en la Guía de
                    definiciones. <br>
                    5 La Comisión Dictaminadora no tomará en cuenta documentación que no esté contemplada dentro del
                    formato de evaluación, asimismo no se aceptará documentación presentada de forma extemporánea.
            </div>
            </div>
            <div class="datosPrimarios">
                <h4>Puntaje máximo
                    <label class="bg-black text-white px-4" for="">100</label>
                </h4>
            </div>
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
            <input type="hidden" id="puntajeEvaluarInput" name="puntajeEvaluar" value="0">
            <table class="table table-sm datosPrimarios">
                <thead>
                    <tr>
                        <th scope="col">Actividad</th>
                        <th class="table-ajust" scope="col">Años</th>
                        <th class="table-ajust" scope="col">Puntaje a evaluar</th>
                        <th class="table-ajust" scope="col">Puntaje de la Comisión Dictaminadora</th>
                        <th class="table-ajust" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="margin-right: auto;"><b>1. Permanencia en las actividades de la docencia</b></td>
                        <td class="horasActv2">
                            <span id="horasActv2"></span>
                        </td>
                        <td class="puntajeEvaluar">
                            <span id="puntajeEvaluarText">0</span>
                        </td>
                        <td class="table-header comision">
                            <div class="filled">
                        @if($userType == 'dictaminador')
                            <!-- Mostrar input si es 'dictaminador' -->
                            <input type="number" step="0.01" id="comision1" name="comision1" class="table-header comision" step="any"
                            value="{{ oldValueOrDefault('comision1') }}">
                        @else
                            <!-- Mostrar span si es otro tipo de usuario -->
                            <span id="comision1" class="table-header comision"></span>
                        @endif
                             </div>
                        </td>
                        <td>
                            <div class="filled">
                        @if($userType == 'dictaminador')
                            <!-- Mostrar input si es 'dictaminador' -->
                            <input id="obs1" name="obs1" class="table-header" type="text">
                        @else
                            <!-- Mostrar span si es otro tipo de usuario -->
                            <span id="obs1" class="table-header"></span>
                        @endif
                            </div>
                        </td>
                        <td>@if($userType != '')
                            <button type="submit" class="btn custom-btn printButtonClass">Enviar</button>
                        @else
                            <span></span>
                        @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="datosPrimarios">
                <thead>
                    <tr>
                        <th style="font-weight: normal; text-size: 20px;" scope="col">Acreditación: </th>
                        <th style="width:60px;padding-left: 100px;">SG</th>
                        <th style="font-weight: normal; padding-left: 100px;">6.25 puntos por cada año de experiencia
                            docente cumplido. A partir de los 16 años de experiencia docente se otorgarán los 100 puntos
                        </th>
                    </tr>
                </thead>
            </table>
        </form>
    </main>

    </form>
    <center>
    <footer>
        <center>
            <div id="convocatoria">
                <!-- Mostrar convocatoria -->
                @if(isset($convocatoria))
                    <div style="margin-right: -700px;">
                        <h1>Convocatoria: {{ $convocatoria->convocatoria ?? 'No disponible' }}</h1>
                    </div>
                @endif
            </div>
        </center>

        <div id="piedepagina" style="margin-left: 500px; margin-top: 10px;">

<x-form-renderer :forms="[['view' => 'form2', 'startPage' => 1, 'endPage' => 1]]" />
        </div>
    </footer>
</center>

    <script>
    document.addEventListener('DOMContentLoaded', async () => {
    const userType = @json($userType);  // Inject user type from backend to JS
    const user_identity = @json($user_identity); 
    const docenteSelect = document.getElementById('docenteSelect');

        if (docenteSelect) {
            // Cuando el usuario es dictaminador
            if (userType === 'dictaminador') {
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
                            axios.get('/get-docente-data', { params: { email } })
                                .then(response => {
                                    const data = response.data;
                                    document.getElementById('horasActv2').textContent = data.form2.horasActv2 || '0';
                                    document.getElementById('puntajeEvaluarText').textContent = data.form2.puntajeEvaluar || '0';
                                    document.querySelector('input[name="user_id"]').value = data.form2.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.form2.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.form2.user_type || '';

                                    // Actualizar convocatoria
                                    const convocatoriaElement = document.getElementById('convocatoria');
                                    const convocatoriaHeader = document.getElementById('convocatoria2');
                                    const periodo = document.getElementById('periodo2');
                                    const nombre = document.getElementById('nombre2');
                                    const area = document.getElementById('area2');
                                    const departamento = document.getElementById('departamento2');

                                    if (convocatoriaElement) {
                                        if (data.form1) {
                                            convocatoriaElement.textContent = data.form1.convocatoria || '';
                                            convocatoriaHeader.textContent = data.form1.convocatoria || '';
                                            periodo.textContent = data.form1.periodo || '';
                                            nombre.textContent = data.form1.nombre || '';
                                            area.textContent = data.form1.area || '';
                                            departamento.textContent = data.form1.departamento || '';
                                        } else {
                                            console.error('form1 no está definido en la respuesta.');
                                        }
                                    } else {
                                        console.error('Elemento con ID "convocatoria" no encontrado.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching docente data:', error);
                                });
                            //await asignarDocentes(user_identity, email);
                        }
                    });
                } catch (error) {
                    console.error('Error fetching docentes:', error);
                    alert('No se pudo cargar la lista de docentes.');
                }
            }
            // Cuando el userType está vacío
            else if (userType === '') {
                const formName = 'form2';
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
                            axios.get('/get-docente-data', { params: { email } })
                                .then(response => {
                                    const data = response.data;

                                    // Actualizar convocatoria

                                                    // Verifica si la respuesta contiene los datos esperados
                                    if (data.docente) {
                                        const convocatoriaElement = document.getElementById('convocatoria');
                                        const convocatoriaHeader = document.getElementById('convocatoria2');
                                        const periodo = document.getElementById('periodo2');
                                        const nombre = document.getElementById('nombre2');
                                        const area = document.getElementById('area2');
                                        const departamento = document.getElementById('departamento2');
                                        // Mostrar la convocatoria si existe
                                        if (convocatoriaElement) {
                                            if (data.docente.convocatoria) {
                                                convocatoriaElement.textContent = data.docente.convocatoria;
                                                convocatoriaHeader.textContent = data.docente.convocatoria || '';
                                                periodo.textContent = data.docente.periodo || '';
                                                nombre.textContent = data.docente.nombre || '';
                                                area.textContent = data.docente.area || '';
                                                departamento.textContent = data.docente.departamento || '';
                                            } else {
                                                convocatoriaElement.textContent = 'Convocatoria no disponible';
                                            }
                                        }
                                    }
                                });
                            // Lógica para obtener datos de DictaminatorsResponseForm2
                            try {
                                const response = await fetch('/get-dictaminators-responses');
                                const dictaminatorResponses = await response.json();
                                // Filtrar la entrada correspondiente al email seleccionado
                                const selectedResponseForm2 = dictaminatorResponses.form2.find(res => res.email === email);
                                if (selectedResponseForm2) {
                                    // Si se encuentra la respuesta correspondiente, asigna sus valores a los campos
                                    document.getElementById('horasActv2').textContent = selectedResponseForm2.horasActv2 || '0';
                                    document.getElementById('puntajeEvaluarText').textContent = selectedResponseForm2.puntajeEvaluar || '0';
                                    document.querySelector('input[name="user_id"]').value = selectedResponseForm2.user_id || '';
                                    document.querySelector('input[name="email"]').value = selectedResponseForm2.email || '';
                                    document.querySelector('input[name="user_type"]').value = selectedResponseForm2.user_type || '';
                                    document.querySelector('span[id="comision1"]').textContent = selectedResponseForm2.comision1 || '';
                                    document.querySelector('span[id="obs1"]').textContent = selectedResponseForm2.obs1 || '';
                                } else {
                                    // Si no se encuentra ningún dato, puedes limpiar los campos o mostrar un mensaje
                                    console.log('No se encontraron respuestas para este email.');
                                    document.getElementById('horasActv2').textContent = '0';
                                    document.getElementById('puntajeEvaluarText').textContent = '0';
                                    document.querySelector('span[id="comision1"]').textContent = '';
                                    document.querySelector('span[id="obs1"]').textContent = '';
                                }
                            } catch (error) {
                                console.error('Error fetching dictaminators responses:', error);
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error fetching docentes:', error);
                    alert('No se pudo cargar la lista de docentes.');
                }

                    
                }


            
            }
  

        });

        async function submitForm(url, formId) {
            const user_identity = @json($user_identity); 
            let formData = {};
            let form = document.getElementById(formId);

            if (!form) {
                console.error(`Form with id "${formId}" not found.`);
                return;
            }

            formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
            formData['user_id'] = form.querySelector('input[name="user_id"]').value;
            formData['email'] = form.querySelector('input[name="email"]').value;
            formData['horasActv2'] = document.getElementById('horasActv2').textContent;
            formData['puntajeEvaluar'] = document.getElementById('puntajeEvaluarText').textContent;
            formData['comision1'] = form.querySelector('input[name="comision1"]').value;
            formData['obs1'] = form.querySelector('input[name="obs1"]').value;
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;

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

                const text = await response.text();
                console.log('Status Code:', response.status);
                console.log('Raw response:', text);

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                let responseData = JSON.parse(text);
                console.log('Response received from server:', responseData);
                 await agregarDocentes(user_identity, formData['email']);
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form2 = document.getElementById('form2');
            if (form2) {
                form2.onsubmit = function (event) {
                    event.preventDefault();
                    submitForm('/store-form2', 'form2');
                    
                };
            }
        });

    document.addEventListener("DOMContentLoaded", function () {
        // Aseguramos que las páginas físicas se calculen en el momento de impresión
        window.addEventListener('beforeprint', () => {
            const totalPagesElement = document.querySelectorAll('.total-pages');
            totalPagesElement.forEach(el => {
                el.textContent = Math.ceil(document.body.offsetHeight / window.innerHeight);
            });
        });

        // Mostrar el número actual de página en cada footer
        const footers = document.querySelectorAll('#piedepagina');
        footers.forEach((footer, index) => {
            const pageNumberElement = footer.querySelector('.page-number');
            pageNumberElement.textContent = index + 1;
        });
    });

    document.addEventListener('DOMContentLoaded', function () {

        const toggleDarkModeButton = document.getElementById('toggle-dark-mode');
        if (toggleDarkModeButton) {
            const widthDarkButton = window.outerWidth - 230;
            toggleDarkModeButton.style.marginLeft = `${widthDarkButton}px`;
        }

        toggleDarkMode();
    });

    </script>
</body>


</html>