@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Participación en actividades de diseño curricular</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-head-resources />    
</head>

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
                                <a class="enlaceSN" href="{{ route('login') }}">
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
                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser
                                    llenado
                                    por la
                                    Comisión del PEDPD)</a>
                            </li><br>
                            <li id="jsonDataLink" class="d-none">
                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de
                                    los
                                    Usuarios</a>
                            </li>
                            <li id="reportLink" class="nav-item d-none">
                                <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                    Reporte</a>
                            </li>
                            <li class="nav-item">
                                @if(Auth::user()->user_type === 'dictaminador')
                                <a class="nav-link active enlaceSN" style="width: 200px;"
                                    href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                                @else
                                    <a class="nav-link active enlaceSN" style="width: 200px;"
                                        href="{{ route('secretaria') }}">Selección de Formatos</a>
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
$userType = Auth::user()->user_type;
        @endphp
    <div class="container mt-4 printButtonClass">
        @if($userType == 'dictaminador')
            <!-- Select para dictaminador seleccionando docentes -->
            <label for="docenteSelect">Seleccionar Docente:</label>
            <select id="docenteSelect" class="form-select">
                <option value="">Seleccionar un docente</option>
                <!-- Aquí se llenarán los docentes con JavaScript -->
            </select>
        @elseif($userType == '')
            <!-- Select para usuario con user_type vacío seleccionando dictaminadores -->
            <label for="dictaminadorSelect">Seleccionar Dictaminador:</label>
            <select id="dictaminadorSelect" class="form-select">
                <option value="">Seleccionar un dictaminador</option>
                <!-- Aquí se llenarán los dictaminadores con JavaScript -->
            </select>
        @else
            <!-- Select por defecto para otros usuarios seleccionando docentes -->
            <label for="docenteSelect">Seleccionar Docente:</label>
            <select id="docenteSelect" class="form-select">
                <option value="">Seleccionar un docente</option>
                <!-- Aquí se llenarán los docentes con JavaScript -->
            </select>
        @endif
    </div>

    <main class="container">
        <!-- Form for Part 3_1 -->
        <form id="form3_1" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form31', 'form3_1');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
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
                                    <td id="actvCant"><label class="actividades">Cantidad</label></td>
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
        
                                    <td class="elabInput"><span id="elaboracion">0</span></td>
                                    <td><span id="elaboracionSubTotal1" for="" type="text"></span></td>
                                    <td class="comision actv">
                                    @if($userType == 'dictaminador')
                                        <input id="comisionIncisoA" for="" type="number"
                                                oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoA') }}"></input>
                                    @else
                                        <label id="comisionIncisoA" name="comisionIncisoA"></label>
                                    @endif                                    
                                    </td>
                                    <td>
                                    @if($userType == 'dictaminador')
                                    <input id="obs3_1_1" name="obs3_1_1" class="table-header" type="text">
                                    @else
                                    <label id="obs3_1_1"name="obs3_1_1" class="table-header"></label>
                                    @endif
                                    </td>
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
                                            <td class="elabInput"><span id="elaboracion2">0</span></td>
                                            <td><span id="elaboracionSubTotal2" for="" type="text"></span>
                                            </td>
                                            <td class="comision actv">
                                            @if($userType == 'dictaminador')
                                                <input id="comisionIncisoB" for="" type="number"
                                                        oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoB') }}"></input>
                                            @else
                                                <label id="comisionIncisoB" name="comisionIncisoB"></label>                                            
                                            @endif
                                            </td>
                                            <td>
                                            @if($userType == 'dictaminador')
                                            <input id="obs3_1_2" name="obs3_1_2" class="table-header" type="text">
                                            @else
                                            <label id="obs3_1_2"name="obs3_1_2" class="table-header"></label>
                                            @endif
                                            </td>
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
                                            <td class="elabInput"><span id="elaboracion3">0</span></td>
                                            <td><span id="elaboracionSubTotal3" for="" type="text"></span>
                                            </td>
                                            <td class="comision actv">
                                            @if($userType == 'dictaminador')
                                                <input id="comisionIncisoC" for="" type="number"
                                                        oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoC') }}"></input>
                                            @else
                                                <label id="comisionIncisoC" name="comisionIncisoC"></label>
                                            @endif
                                            </td>
                                            <td>
                                            @if($userType == 'dictaminador')
                                            <input id="obs3_1_3" name="obs3_1_3" class="table-header" type="text">  
                                            @else
                                            <label id="obs3_1_3"name="obs3_1_3" class="table-header"></label>
                                            @endif
                                            </td>
                                            
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
                                            <td class="elabInput"><span id="elaboracion4">0</span></td>
                                            <td><span id="elaboracionSubTotal4"></span>
                                            </td>
                                            <td class="comision actv">
                                            @if($userType == 'dictaminador')

                                                <input id="comisionIncisoD" for="" type="number"
                                                        oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoD') }}"></input>
                                            @else
                                                <label id="comisionIncisoD" name="comisionIncisoD"></label>
                                            @endif                                               
                                            </td>
                                            <td>
                                            @if($userType == 'dictaminador')
                                                <input id="obs3_1_4" name="obs3_1_4" class="table-header" type="text">
                                            @else
                                            <label id="obs3_1_4"name="obs3_1_4"class="table-header"></label>
                                            @endif
                                            </td>
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
                                            <td class="elabInput"><span id="elaboracion5">0</span></td>
                                            <td><span id="elaboracionSubTotal5"></span></td>
                                            <td class="comision actv">
                                            @if($userType == 'dictaminador')
                                                <input id="comisionIncisoE" for="" type="number"
                                                        oninput="onActv3Comision()" value="{{ oldValueOrDefault('comisionIncisoE') }}"></input>
                                            @else
                                             <label id="comisionIncisoE" name="comisionIncisoE"></label>
                                             @endif
                                            </td>
                                            <td>
                                            @if($userType == 'dictaminador')
                                            <input id="obs3_1_5" name="obs3_1_5" class="table-header" type="text">
                                            @else
                                            <label id="obs3_1_5"name="obs3_1_5"class="table-header"></label>
                                            @endif
                                            </td>
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
                        <th>
                        @if ($userType != '')
                            <button id="btn3_1" type="submit" class="btn custom-btn printButtonClass">Enviar</button>
                        @endif
                        </th>
                    </tr>
        
        
                </thead>
            </table>
        </form>
    </main><br>
    <center>
        <footer id="convocatoria">
            <!-- Mostrar convocatoria -->
            @if(isset($convocatoria))

                <div style="margin-right: -700px;">
                    <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
                </div>
            @endif
        </footer>
    </center>
    <script>
    document.addEventListener('DOMContentLoaded', async () => {
        const docenteSelect = document.getElementById('docenteSelect');
            const dictaminadorSelect = document.getElementById('dictaminadorSelect');

            // Current user type from the backend
            const userType = @json($userType);  // Get user type from backend

            // Fetch docente options if user is a dictaminador
            if (docenteSelect && userType === 'dictaminador') {
            try {
                const response = await fetch('/get-docentes');
                const docentes = await response.json();

                docentes.forEach(docente => {
                const option = document.createElement('option');
                option.value = docente.email;
                option.textContent = docente.email;
                docenteSelect.appendChild(option);
                });

                // Handle docente selection change
                docenteSelect.addEventListener('change', async (event) => {
                    const email = event.target.value;
            if (email) {
                        try {
                            const response = await axios.get('/get-docente-data', {params: {email} });
            const data = response.data;

            // Populate fields with fetched data
            document.getElementById('score3_1').textContent = data.form3_1.score3_1 || '0';
            document.getElementById('elaboracion').textContent = data.form3_1.elaboracion || '0';
            document.getElementById('elaboracionSubTotal1').textContent = data.form3_1.elaboracionSubTotal1 || '0';
            document.getElementById('elaboracion2').textContent = data.form3_1.elaboracion2 || '0';
            document.getElementById('elaboracionSubTotal2').textContent = data.form3_1.elaboracionSubTotal2 || '0';
            document.getElementById('elaboracion3').textContent = data.form3_1.elaboracion3 || '0';
            document.getElementById('elaboracionSubTotal3').textContent = data.form3_1.elaboracionSubTotal3 || '0';
            document.getElementById('elaboracion4').textContent = data.form3_1.elaboracion4 || '0';
            document.getElementById('elaboracionSubTotal4').textContent = data.form3_1.elaboracionSubTotal4 || '0';
            document.getElementById('elaboracion5').textContent = data.form3_1.elaboracion5 || '0';
            document.getElementById('elaboracionSubTotal5').textContent = data.form3_1.elaboracionSubTotal5 || '0';
            //document.getElementById('actv3Comision').textContent = data.form3_1.actv3Comision || '0';

            // Populate hidden inputs
            document.querySelector('input[name="user_id"]').value = data.form3_1.user_id || '';
            document.querySelector('input[name="email"]').value = data.form3_1.email || '';
            document.querySelector('input[name="user_type"]').value = data.form3_1.user_type || '';

            // Verificar si el elemento existe antes de establecer su contenido
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
                                    

                        } catch (error) {
                console.error('Error fetching docente data:', error);
                        }
                    }
                });
            } catch (error) {
                console.error('Error fetching docentes:', error);
            alert('No se pudo cargar la lista de docentes.');
            }
        }

            // Fetch dictaminador options if user type is null or empty
            if (dictaminadorSelect && userType === '') {
                try {
                    const response = await fetch('/get-dictaminadores');
                    const dictaminadores = await response.json();

                    dictaminadores.forEach(dictaminador => {
                    const option = document.createElement('option');
                    option.value = dictaminador.id;  // Use dictaminador ID as value
                    option.dataset.email = dictaminador.email; // Store email in data attribute
                    option.textContent = dictaminador.email;
                    dictaminadorSelect.appendChild(option);
                });

                // Handle dictaminador selection change
            dictaminadorSelect.addEventListener('change', async (event) => {
                const dictaminadorId = event.target.value;
                const email = event.target.options[event.target.selectedIndex].dataset.email;  // Get email from selected option
            
                if (dictaminadorId) {
                    try {
                        const response = await axios.get('/get-dictaminador-data', {
                        params: {email: email, dictaminador_id: dictaminadorId }  // Send both ID and email
                    });
                const data = response.data;

            // Populate fields based on fetched data
            if (data.form3_1) {
            document.querySelector('input[name="dictaminador_id"]').value = data.dictaminador.dictaminador_id || '0';
            document.querySelector('input[name="user_id"]').value = data.dictaminador.user_id || '';
            document.querySelector('input[name="email"]').value = data.dictaminador.email || '';
            document.querySelector('input[name="user_type"]').value = data.dictaminador.user_type || '';

            document.getElementById('score3_1').textContent = data.form3_1.score3_1 || '0';
            document.getElementById('elaboracion').textContent = data.form3_1.elaboracion || '0';
            document.getElementById('elaboracionSubTotal1').textContent = data.form3_1.elaboracionSubTotal1 || '0';
            document.getElementById('elaboracion2').textContent = data.form3_1.elaboracion2 || '0';
            document.getElementById('elaboracionSubTotal2').textContent = data.form3_1.elaboracionSubTotal2 || '0';
            document.getElementById('elaboracion3').textContent = data.form3_1.elaboracion3 || '0';
            document.getElementById('elaboracionSubTotal3').textContent = data.form3_1.elaboracionSubTotal3 || '0';
            document.getElementById('elaboracion4').textContent = data.form3_1.elaboracion4 || '0';
            document.getElementById('elaboracionSubTotal4').textContent = data.form3_1.elaboracionSubTotal4 || '0';
            document.getElementById('elaboracion5').textContent = data.form3_1.elaboracion5 || '0';
            document.getElementById('elaboracionSubTotal5').textContent = data.form3_1.elaboracionSubTotal5 || '0';
            document.getElementById('actv3Comision').textContent = data.form3_1.actv3Comision || '0';
            document.querySelector('label[name="comisionIncisoA"]').textContent = data.form3_1.comisionIncisoA || '0';
            document.querySelector('label[name="comisionIncisoB"]').textContent = data.form3_1.comisionIncisoB || '0';
            document.querySelector('label[name="comisionIncisoC"]').textContent = data.form3_1.comisionIncisoC || '0';
            document.querySelector('label[name="comisionIncisoD"]').textContent = data.form3_1.comisionIncisoD || '0';
            document.querySelector('label[name="comisionIncisoE"]').textContent = data.form3_1.comisionIncisoE || '0';
            document.querySelector('label[name="obs3_1_1"]').textContent = data.form3_1.obs3_1_1 || '';
            document.querySelector('label[name="obs3_1_2"]').textContent = data.form3_1.obs3_1_2 || '';
            document.querySelector('label[name="obs3_1_3"]').textContent = data.form3_1.obs3_1_3 || '';
            document.querySelector('label[name="obs3_1_4"]').textContent = data.form3_1.obs3_1_4 || '';
            document.querySelector('label[name="obs3_1_5"]').textContent = data.form3_1.obs3_1_5 || '';

            // Verificar si el elemento existe antes de establecer su contenido
                const convocatoriaElement = document.getElementById('convocatoria');
                if (convocatoriaElement) {
                    if (data.responseForm1) {
                        convocatoriaElement.textContent = data.responseForm1.convocatoria || '';
                    } else {
                        console.error('form1 no está definido en la respuesta.');
                    }
                } else {
                    console.error('Elemento con ID "convocatoria" no encontrado.');
                }
                
            } else {
                
                console.error('No form3_1 data found for the selected dictaminador.');
            // Reset input values if no data found
            document.querySelector('input[name="dictaminador_id"]').value = '0';
            document.querySelector('input[name="user_id"]').value = '0';
            document.querySelector('input[name="email"]').value = '';
            document.querySelector('input[name="user_type"]').value = '';
            document.getElementById('score3_1').textContent = '0';
            document.getElementById('elaboracion').textContent = '0';
            document.getElementById('elaboracionSubTotal1').textContent = '0';
            document.getElementById('elaboracion2').textContent = '0';
            document.getElementById('elaboracionSubTotal2').textContent ='0';
            document.getElementById('elaboracion3').textContent ='0';
            document.getElementById('elaboracionSubTotal3').textContent ='0';
            document.getElementById('elaboracion4').textContent = '0';
            document.getElementById('elaboracionSubTotal4').textContent = '0';
            document.getElementById('elaboracion5').textContent = '0';
            document.getElementById('elaboracionSubTotal5').textContent = '0';
            document.getElementById('actv3Comision').textContent = '0';
            document.querySelector('label[name="comisionIncisoA"]').textContent = '0';
            document.querySelector('label[name="comisionIncisoB"]').textContent = '0';
            document.querySelector('label[name="comisionIncisoC"]').textContent = '0';
            document.querySelector('label[name="comisionIncisoD"]').textContent = '0';
            document.querySelector('label[name="comisionIncisoE"]').textContent = '0';
            document.querySelector('label[name="obs3_1_1"]').textContent ='';
            document.querySelector('label[name="obs3_1_2"]').textContent ='';
            document.querySelector('label[name="obs3_1_3"]').textContent ='';
            document.querySelector('label[name="obs3_1_4"]').textContent ='';
            document.querySelector('label[name="obs3_1_5"]').textContent ='';
                            }
                        } catch (error) {
                console.error('Error fetching dictaminador data:', error);
                        }
                    }
                });
            } catch (error) {
                console.error('Error fetching dictaminadores:', error);
            alert('No se pudo cargar la lista de dictaminadores.');
            }
        }
    });

            // Function to handle form submission
            async function submitForm(url, formId) {
            const formData = { };
            const form = document.getElementById(formId);

            if (!form) {
                console.error(`Form with id "${formId}" not found.`);
            return;
        }

            // Gather all related information from the form
            formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
            formData['user_id'] = form.querySelector('input[name="user_id"]').value;
            formData['email'] = form.querySelector('input[name="email"]').value;
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;

            formData['elaboracion'] = document.getElementById('elaboracion').textContent;
            formData['elaboracionSubTotal1'] = document.getElementById('elaboracionSubTotal1').textContent;
            formData['comisionIncisoA'] = document.getElementById('comisionIncisoA').value; // Ensure input value is fetched
            formData['elaboracion2'] = document.getElementById('elaboracion2').textContent;
            formData['elaboracionSubTotal2'] = document.getElementById('elaboracionSubTotal2').textContent;
            formData['comisionIncisoB'] = document.getElementById('comisionIncisoB').value; // Ensure input value is fetched
            formData['elaboracion3'] = document.getElementById('elaboracion3').textContent;
            formData['elaboracionSubTotal3'] = document.getElementById('elaboracionSubTotal3').textContent;
            formData['comisionIncisoC'] = document.getElementById('comisionIncisoC').value; // Ensure input value is fetched
            formData['elaboracion4'] = document.getElementById('elaboracion4').textContent;
            formData['elaboracionSubTotal4'] = document.getElementById('elaboracionSubTotal4').textContent;
            formData['comisionIncisoD'] = document.getElementById('comisionIncisoD').value; // Ensure input value is fetched
            formData['elaboracion5'] = document.getElementById('elaboracion5').textContent;
            formData['elaboracionSubTotal5'] = document.getElementById('elaboracionSubTotal5').textContent;
            formData['comisionIncisoA'] = form.querySelector('input[id="comisionIncisoA"]').value; 
            formData['comisionIncisoB'] = form.querySelector('input[id="comisionIncisoB"]').value;
            formData['comisionIncisoC'] = form.querySelector('input[id="comisionIncisoC"]').value;
            formData['comisionIncisoD'] = form.querySelector('input[id="comisionIncisoD"]').value;   
            formData['comisionIncisoE'] = form.querySelector('input[id="comisionIncisoE"]').value;                      
            formData['score3_1'] = document.getElementById('score3_1').textContent;
            formData['actv3Comision'] = document.getElementById('actv3Comision').textContent;

            // Observations
            formData['obs3_1_1'] = form.querySelector('input[name="obs3_1_1"]').value;
            formData['obs3_1_2'] = form.querySelector('input[name="obs3_1_2"]').value;
            formData['obs3_1_3'] = form.querySelector('input[name="obs3_1_3"]').value;
            formData['obs3_1_4'] = form.querySelector('input[name="obs3_1_4"]').value;
            formData['obs3_1_5'] = form.querySelector('input[name="obs3_1_5"]').value;

            console.log('Form data:', formData);

            try {
            const response = await fetch(url, {
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

            const responseData = await response.json();
            console.log('Response received from server:', responseData);
        } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
        }
    }
        function minWithSum(value1, value2) {
            const sum = value1 + value2;
            return Math.min(sum, 200);


        }
    </script>

</body>

</html>