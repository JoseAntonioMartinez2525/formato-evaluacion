<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formato de Evaluación docente</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/e72e299160.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form3.css') }}" rel="stylesheet">
    <script src="{{ asset('js/subtotales.js') }}"></script>
    <script src="{{ asset('js/comisiones.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
@if (Route::has('login'))
        @csrf
        @if (Auth::check())

            <nav class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link disabled user" href="#"><i class="fa-solid fa-user"></i>&nbsp&nbsp{{ Auth::user()->email }}</a>
        </li>@endif
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('welcome') }}">Formato de Evaluación</a>
            </li>
    <ul class="actv3">Actividades del apartado 3.<br>Calidad en la docencia:
        <li><a href="#seccion3_1">3.1 Participación en actividades de diseño curricular</a></li>
        <li><a href="#seccion3_2">3.2 Calidad del desempeño docente evaluada por el alumnado</a></li>
        <li><a href="#seccion3_3">3.3 Publicaciones relacionadas con la docencia</a></li>
        <li><a href="#seccion3_4">3.4 Distinciones académicas recibidas por el docente</a></li>
        <li><a href="#seccion3_5">3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y
                por CAAC</a></li>
        <li><a href="#seccion3_6">3.6 Capacitación y actualización pedagógica recibida</a></li>
        <li><a href="#seccion3_7">3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento</a>
        </li>
        <li><a href="#seccion3_8">3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de
                educación, continua o de formación y capacitación docente</a></li>
        <li><a href="#seccion3_9">3.9 Trabajos dirigidos para la titulación de estudiantes</a></li>
        <li><a href="#seccion3_10">3.10 Tutorías a estudiantes</a></li>
        <li><a href="#seccion3_11">3.11 Asesoría a estudiantes</a></li>
        <li><a href="#seccion3_12">3.12 Publicaciones de investigación relacionadas con el contenido de los PE que imparte
                el docente</a></li>
        <li><a href="#seccion3_13">3.13 Proyectos académicos de investigación</a></li>
        <li><a href="#seccion3_14">3.14 Participación como ponente en congresos o eventos académicos del 
            Área de Conocimiento o afines del docente</a></li>
        <li><a href="#seccion3_15">3.15 Registro de patentes y productos de investigación tecnológica y educativa</a></li>
        <li><a href="#seccion3_16">3.16 Actividades de arbitraje, revisión, correción y edición </a></li>
        <li><a href="#seccion3_17">3.17 Proyectos académicos de extensión y difusión </a></li>
        <li><a href="#seccion3_18">3.18 Organización de congresos o eventos institucionales del área de conocimiento de la o
                el Docente </a></li>
        <li><a href="#seccion3_19">3.19 Participación en cuerpos colegiados</a></li>
    </ul>

        </nav>

        <body class="font-sans antialiased">
            <div class="bg-gray-50 text-black/50">
                <div class="relative min-h-screen flex flex-col items-center justify-center">
                    <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                            <div class="flex lg:justify-center lg:col-start-2"></div>

                            <nav class="-mx-3 flex flex-1 justify-end"></nav>
                            <form id="form3_1" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
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
                                                    <td id="seccion3_1">3.1 Participación en actividades de diseño curricular</td>
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
                                                                for="">&nbsp</label><label for="">&nbsp</label><label
                                                                for="">&nbsp</label><label for="">&nbsp</label><label
                                                                for="">&nbsp</label><label for="">&nbsp</label>
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

                                                        <td class="elabInput"><input id="elaboracion" type="text"
                                                                oninput="onActv3Subtotal()" placeholder="0"></td>
                                                        <td><label id="elaboracionSubTotal1" for="" type="text"></label></td>
                                                        <td class="comision actv"><input id="comisionIncisoA" placeholder="0"
                                                                for="" oninput="onActv3Comision()"></input></td>
                                                        <td><input id="obs3_1_1" class="table-header" type="text"></td>
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
                                                                <td class="elabInput"><input id="elaboracion2" type="text"
                                                                        oninput="onActv3Subtotal()" placeholder="0"></td>
                                                                <td><label id="elaboracionSubTotal2" for="" type="text"></label>
                                                                </td>
                                                                <td class="comision actv"><input id="comisionIncisoB"
                                                                        placeholder="0" for=""
                                                                        oninput="onActv3Comision()"></input></td>
                                                                <td><input id="obs3_1_2" class="table-header" type="text"></td>
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
                                                                <td class="elabInput"><input id="elaboracion3" type="text"
                                                                        oninput="onActv3Subtotal()" placeholder="0"></td>
                                                                <td><label id="elaboracionSubTotal3" for="" type="text"></label>
                                                                </td>
                                                                <td class="comision actv"><input id="comisionIncisoC"
                                                                        placeholder="0" for=""
                                                                        oninput="onActv3Comision()"></input></td>
                                                                <td><input id="obs3_1_3" class="table-header" type="text"></td>
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
                                                                <td class="elabInput"><input id="elaboracion4" type="text"
                                                                        oninput="onActv3Subtotal()" placeholder="0"></td>
                                                                <td><label id="elaboracionSubTotal4" for="" type="text"></label>
                                                                </td>
                                                                <td class="comision actv"><input id="comisionIncisoD"
                                                                        placeholder="0" for=""
                                                                        oninput="onActv3Comision()"></input></td>
                                                                <td><input id="obs3_1_4" class="table-header" type="text"></td>
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
                                                                <td class="elabInput"><input id="elaboracion5" type="text"
                                                                        oninput="onActv3Subtotal()" placeholder="0"></td>
                                                                <td><label id="elaboracionSubTotal5" for="" type="text"></label>
                                                                </td>
                                                                <td class="comision actv"><input id="comisionIncisoE"
                                                                        placeholder="0" for=""
                                                                        oninput="onActv3Comision()"></input></td>
                                                                <td><input id="obs3_1_5" class="table-header" type="text"></td>
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
                                            <th> <button id="btn3_1" type="submit" class="btn btn-primary">Enviar</th>
                                        </tr>


                                    </thead>
                                </table>
                            </form>

                            <form id="form3_2" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                                <div>
                                    <!-- Actividad 3.2 Calidad del desempeño docente evaluada por el alumnado -->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">50</label>
                                    </h4>
                                </div>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                                <th class="table-ajust" scope="col">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <td id="seccion3_2" style="height: 80px; width: 200px;">3.2 Calidad del desempeño docente
                                                    evaluada por el alumnado
                                                </td>
                                                <td>Puntaje</td>
                                                <td style="text-align:left;">Cantidad</td>
                                                <td id="score3_2">0</td>
                                                <td id="comision3_2">0</td>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <!--prom90-100-->
                                            <tr>
                                                <td class="ranges">
                                                    <center>Promedio 90-100</center>
                                                </td>
                                                <td id="ran1"><b>50</b></td>
                                                <td class="elabInput"><input id="r1" type="value" placeholder="0"
                                                        oninput="onActv3Puntaje()"></td>
                                                <td id="cant1">0</td>
                                                <td><input id="prom90_100" type="value" placeholder="0"
                                                        oninput="onActv3_2Comision()"></td>
                                                <td><input id="obs3_2_1" class="table-header" type="text"></td>
                                            </tr>
                                            <!--prom80-90-->
                                            <tr>
                                                <td class="ranges">
                                                    <center>Promedio 80-90</center>
                                                </td>
                                                <td id="ran2"><b>40</b></td>
                                                <td class="elabInput"><input id="r2" type="value" placeholder="0"
                                                        oninput="onActv3Puntaje()"></td>
                                                <td id="cant2">0</td>
                                                <td><input id="prom80_90" placeholder="0" type="value"
                                                        oninput="onActv3_2Comision()"></td>
                                                <td><input id="obs3_2_2" class="table-header" type="text"></td>
                                            </tr>
                                            <!--prom70-80-->
                                            <tr>
                                                <td class="ranges">
                                                    <center>Promedio 70-80</center>
                                                </td>
                                                <td id="ran3"><b>30</b></td>
                                                <td class="elabInput"><input id="r3" type="value" placeholder="0"
                                                        oninput="onActv3Puntaje()"></td>
                                                <td id="cant3">0</td>
                                                <td><input id="prom70_80" placeholder="0" type="value"
                                                        oninput="onActv3_2Comision()"></td>
                                                <td><input id="obs3_2_3" class="table-header" type="text"></td>
                                            </tr>
                                        </thead>
                                        <!--Tabla informativa Acreditacion Actividad 3.2-->
                                        <table>
                                            <thead>
                                                <tr><br>
                                                    <th class="acreditacion" scope="col">Acreditacion: </th>

                                                    <th class="descripcionDDIE"><b>DDIE</b>
                                                    <th> <button id="btn3_2" type="submit" class="btn btn-primary">Enviar</th>
                                                </tr>

                                            </thead>
                                        </table>
                            </form>

                            <form id="form3_3" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                                <div>
                                    <!-- Actividad 3.3 Publicaciones relacionadas con la docencia -->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">100</label>
                                    </h4>
                                </div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                    <th class="table-ajust" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <td id="seccion3_3">3.3 Publicaciones relacionadas con la docencia</td>
                                                        <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                                                        <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                                                        <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                                                        <td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>
                                                        <td id="score3_3">0</td>
                                                        <td id="comision3-3">0</td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td colspan=6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="incisos">Incisos</td>
                                                        <td class="obra">Obra</td>
                                                        <td>Actividad</td>
                                                        <td>Puntaje</td>
                                                        <td>Cantidad</td>
                                                        <td>SubTotal</td>

                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td>a)</td>
                                                        <td>Libro de texto con editorial de reconocido prestigio</td>
                                                        <td>Autor(a)</td>
                                                        <td id="p100">
                                                            <center><b>100</b></center>
                                                        </td>
                                                        <td class="elabInput"><input id="rc1" type="text" placeholder="0"
                                                                oninput="onActv3SubTotal3()">
                                                        </td>
                                                        <td id="stotal1"></td>
                                                        <td class="comision actv"><input id="comIncisoA" placeholder="0" for=""
                                                                oninput="onActv3Comision3()"></input></td>
                                                        <td><input id="obs3_3_1" class="table-header" type="text"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>b)</td>
                                                        <td>1. Paquete didáctico, 2. Manual de operaciones</td>
                                                        <td>Autor(a)</td>
                                                        <td id="p50">
                                                            <center><b>50</b></center>
                                                        </td>
                                                        <td class="elabInput"><input id="rc2" type="text" placeholder="0"
                                                                oninput="onActv3SubTotal3()">
                                                        </td>
                                                        <td id="stotal2"></td>
                                                        <td class="comision actv"><input id="comIncisoB" placeholder="0" for=""
                                                                oninput="onActv3Comision3()"></input></td>
                                                        <td><input id="obs3_3_2" class="table-header" type="text"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>c)</td>
                                                        <td>1. Capítulo de libro, 2. Elaboración de Manuales de laboratorio o
                                                            instructivos, 3. Diseño
                                                            y
                                                            construcción de equipo de laboratorio, 4. Elaboración de material
                                                            audiovisual, 5.
                                                            Elaboración
                                                            de
                                                            software educativo, 6. Notas de curso, 7. Antología comentada, 8.
                                                            Monografía.</td>
                                                        <td>Autor(a)</td>
                                                        <td id="p30">
                                                            <center><b>30</b></center>
                                                        </td>
                                                        <td class="elabInput"><input id="rc3" type="text" placeholder="0"
                                                                oninput="onActv3SubTotal3()">
                                                        </td>
                                                        <td id="stotal3"></td>
                                                        <td class="comision actv"><input id="comIncisoC" placeholder="0" for=""
                                                                oninput="onActv3Comision3()"></input></td>
                                                        <td><input id="obs3_3_3" class="table-header" type="text"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>d)</td>
                                                        <td>1. Traducción de libro, 2.Traducción de material de apoyo didáctico,
                                                            3. Traducciones
                                                            publicadas de artículos.</td>
                                                        <td>Autor(a)</td>
                                                        <td id="p25">
                                                            <center><b>25</b></center>
                                                        </td>
                                                        <td class="elabInput"><input id="rc4" type="text" placeholder="0"
                                                                oninput="onActv3SubTotal3()">
                                                        </td>
                                                        <td id="stotal4"></td>
                                                        <td class="comision actv"><input id="comIncisoD" placeholder="0" for=""
                                                                oninput="onActv3Comision3()"></input></td>
                                                        <td><input id="obs3_3_4" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                            </tbody>
                                        </table>
                                        <!--Tabla informativa Acreditacion Actividad 3.3-->
                                        <table>
                                            <thead>
                                                <tr><br>
                                                    <th class="acreditacion" scope="col">Acreditacion: </th>

                                                    <th class="descripcionCAAC"><b>CAAC, Instancia que la otorga</b>
                                                    <th><button id="btn3_3" type="submit" class="btn btn-primary">Enviar</th>
                                                </tr>
                                            </thead>
                                        </table>
                            <form id="form3_4" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                                    <div>
                                    <!-- 3.4 Distinciones académicas recibidas por el docente  -->
                                        <h4>Puntaje máximo
                                            <label class="bg-black text-white px-4 mt-3" for="">60</label>
                                        </h4>
                                    </div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>

                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                    <th class="table-ajust" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <th id="seccion3_4"colspan=2 class="punto3_4" scope=col style="padding:30px;">3.4
                                                            Distinciones académicas
                                                            recibidas por el docente </th>
                                                        <td class="punto3_4">Puntaje</td>
                                                        <td class="punto3_4">Cantidad</td>
                                                        <td id="score3_4">0</td>
                                                        <td id="comision3_4">0</td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <td class="punto3_4">a)</td>
                                                    <td>Internacional</td>
                                                    <td id="p60"><b>60</b></td>
                                                    <td><input type="value" id="cantInternacional" placeholder="0"
                                                            oninput="onActv3SubTotal3_4()">
                                                    </td>
                                                    <td id="cantInternacional2"></td>
                                                    <td><input type="value" id="comInternacional" placeholder="0"
                                                            oninput="onActv3Comision3_4()">
                                                    </td>
                                                    <td><input id="obs3_4_1" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td class="punto3_4">b)</td>
                                                        <td>Nacional</td>
                                                        <td id="p30Nac"><b>30</b></td>
                                                        <td><input type="value" id="cantNacional" placeholder="0"
                                                                oninput="onActv3SubTotal3_4()"></td>
                                                        <td id="cantNacional2""></td>
                                    <td><input type=" value" id="comNacional" placeholder="0" oninput="onActv3Comision3_4()">
                                                        </td>
                                                        <td><input id="obs3_4_2" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td class="punto3_4">c)</td>
                                                        <td>Regional o estatal</td>
                                                        <td id="p20"><b>20</b></td>
                                                        <td><input type="value" id="cantidadRegional" placeholder="0"
                                                                oninput="onActv3SubTotal3_4()">
                                                        </td>
                                                        <td id="cantidadRegional2"></td>
                                                        <td><input type="value" id="comRegional" placeholder="0"
                                                                oninput="onActv3Comision3_4()"></td>
                                                        <td><input id="obs3_4_3" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td class="punto3_4">d)</td>
                                                        <td>Preparación de grupos de alumnado para olimpiadas competencias
                                                            académicas o exámenes
                                                            generales.</td>
                                                        <td id="p30Prep"><b>30</b></td>
                                                        <td><input type="value" id="cantPreparacion" placeholder="0"
                                                                oninput="onActv3SubTotal3_4()">
                                                        </td>
                                                        <td id="cantPreparacion2"></td>
                                                        <td><input type="value" id="comPreparacion" placeholder="0"
                                                                oninput="onActv3Comision3_4()">
                                                        </td>
                                                        <td><input id="obs3_4_4" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                            </tbody>
                                        </table>
                                        <!--Tabla informativa Acreditacion Actividad 3.4-->
                                        <table>
                                            <thead>
                                                <tr><br>
                                                    <th class="acreditacion" scope="col">Acreditacion: </th>

                                                    <th class="descripcionCAAC"><b>CAAC, Instancia que la otorga</b>
                                                    <th><button id="btn3_4" type="submit" class="btn btn-primary">Enviar</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        </form>
                            <form id="form3_5" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                                    <div>                                      
                                        <!-- 3.5 Asistencia, puntualidad y permanencia en el desempeño docente, evaluada por el JD y por CAAC  -->
                                        <h4>Puntaje máximo
                                            <label class="bg-black text-white px-4 mt-3" for="">75</label>
                                        </h4>
                                    </div> 
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>

                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                    <th class="table-ajust" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <th id="seccion3_5"colspan=2 class="punto3_5" scope=col style="padding:30px;">3.5
                                                            Asistencia, puntualidad y
                                                            permanencia en el desempeño docente, evaluada por el JD y por CAAC
                                                        </th>
                                                        <td class="punto3_5">Puntaje</td>
                                                        <td class="punto3_5">Cantidad</td>
                                                        <td id="score3_5">0</td>
                                                        <td id="comision3_5">0</td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <td class="punto3_5">a)</td>
                                                    <td>Evaluado por la persona titular de DA</td>
                                                    <td id="p35"><b>35</b></td>
                                                    <td><input type="value" id="cantDA" placeholder="0"
                                                            oninput="onActv3SubTotal3_5()"></td>
                                                    <td id="cantDA2"></td>
                                                    <td><input type="value" id="comDA" placeholder="0"
                                                            oninput="onActv3Comision3_5()"></td>
                                                    <td><input id="obs3_5_1" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td class="punto3_5">b)</td>
                                                        <td>Evaluado por CAAC</td>
                                                        <td id="pCAAC40"><b>40</b></td>
                                                        <td><input type="value" id="cantCAAC" placeholder="0"
                                                                oninput="onActv3SubTotal3_5()"></td>
                                                        <td id="cantCAAC2""></td>
                                    <td><input type=" value" id="comNCAA" placeholder="0" oninput="onActv3Comision3_5()"></td>
                                                        <td><input id="obs3_5_2" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                            </tbody>
                                        </table>
                                        <!--Tabla informativa Acreditacion Actividad 3.5-->
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="acreditacion" scope="col">Acreditacion: </th>

                                                    <th class="descripcion"><b>JDA y CAAC</b>
                                                    <th><button id="btn3_5" type="submit" class="btn btn-primary">Enviar</th>
                                                </tr>
                                            </thead>
                                        </table>
                            </form>
                            <form id="form3_6" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                                    <div>
                                        <!-- 3.6 Capacitación y actualización pedagógica recibida  -->
                                        <h4>Puntaje máximo
                                            <label class="bg-black text-white px-4 mt-3" for="">40</label>
                                        </h4>
                                    </div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>

                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                    <th class="table-ajust" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <th id="seccion3_6"colspan=1 class="punto3_6" scope=col style="padding:30px;">3.6
                                                            Capacitación y
                                                            actualización
                                                            pedagógica recibida </th>
                                                        <td class="punto3_6">Factor</td>
                                                        <td class="punto3_6">Horas</td>
                                                        <td id="score3_6">0</td>
                                                        <td id="comision3_6">0</td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td>0.5 por cada hora</td>
                                                        <td id="pMedio">0.5</td>
                                                        <td><input type="value" placeholder="0" id="puntaje3_6"
                                                                oninput="onActv3SubTotal3_6()"></td>
                                                        <td id="puntajeHoras3_6"></td>
                                                        <td><input type="text" placeholder="0" id="comisionDict3_6"
                                                                oninput="onActv3Comision3_6()">
                                                        </td>
                                                        <td><input id="obs3_6" id="obs3_6" class="table-header" type="text">
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <!--Tabla informativa Acreditacion Actividad 3.6-->
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th class="acreditacion" scope="col">Acreditacion: </th>

                                                            <th class="descripcion"><b>DDIE</b>

                                                            <th><button id="btn3_5" type="submit" class="btn btn-primary">Enviar</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </tbody>
                                        </table>
                            </form>
                            <form id="form3_7" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                                <div>
                                    <!-- 3.7 Cursos de actualización disciplinaria recibidos dentro de su área de conocimiento  -->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">40</label>
                                    </h4>
                                </div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>

                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                    <th class="table-ajust" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <th id="seccion3_7"colspan=1 class="punto3_7" scope=col style="padding:30px;">3.7
                                                            Cursos de actualización
                                                            disciplinaria recibidos dentro de su área de conocimiento </th>
                                                        <td class="punto3_7">Factor</td>
                                                        <td class="punto3_7">Horas</td>
                                                        <td id="score3_7">0</td>
                                                        <td id="comision3_7">0</td>

                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td>0.5 por cada hora</td>
                                                        <td id="pMedio2">0.5</td>
                                                        <td><input type="value" placeholder="0" id="puntaje3_7"
                                                                oninput="onActv3SubTotal3_7()"></td>
                                                        <td id="puntajeHoras3_7"></td>
                                                        <td><input type="text" placeholder="0" id="comisionDict3_7"
                                                                oninput="onActv3Comision3_7()">
                                                        </td>
                                                        <td><input id="obs3_7" class="table-header" type="text"></td>
                                                    </tr>
                                                </thead>
                                                <!--Tabla informativa Acreditacion Actividad 3.7-->
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th class="acreditacion" scope="col">Acreditacion: </th>

                                                            <th class="descripcion"><b>JD,CAAC, instancia que organiza</b>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </tbody>
                                        </table>
                            </form>
                            <form id="form3_8" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                                <div>
                                    <!--3.8 Impartición de cursos, diplomados, seminarios, talleres extracurriculares, de educación, continua o de formación y capacitación docente-->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">40</label>
                                    </h4>
                                </div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>

                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                    <th class="table-ajust" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <th id="seccion3_8"colspan=1 class="punto3_8" scope=col style="padding:30px;">3.8
                                                            Impartición de cursos,
                                                            diplomados, seminarios, talleres extracurriculares, de educación,
                                                            continua o de formación y
                                                            capacitación docente </th>
                                                        <td class="punto3_8">Factor</td>
                                                        <td class="punto3_8">Horas</td>
                                                        <td id="score3_8">0</td>
                                                        <td id="comision3_8">0</td>

                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <td>1 por cada hora</td>
                                                        <td id="p3_8">1</td>
                                                        <td><input type="value" placeholder="0" id="puntaje3_8"
                                                                oninput="onActv3SubTotal3_8()"></td>
                                                        <td id="puntajeHoras3_8"></td>
                                                        <td><input type="text" placeholder="0" id="comisionDict3_8"
                                                                oninput="onActv3Comision3_8()">
                                                        </td>
                                                        <td><input class="table-header" id="obs3_8" type="text"></td>
                                                    </tr>
                                                </thead>
                                                <!--Tabla informativa Acreditacion Actividad 3.8-->
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th class="acreditacion" scope="col">Acreditacion: </th>

                                                            <th class="descripcion"><b>*JD,CAAC, DDCE, DDIE, SA,DIIP, según
                                                                    corresponda. Cuando sea en
                                                                    instituciones externas, presentar constancia de la
                                                                    institución y el convenio acuerdo con
                                                                    la
                                                                    UABCS.</b> </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </tbody>
                                        </table>
                            </form>
                            <form id="form3_9" method="POST" action="{{ route('store') }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @csrf
                            <div>
                            <!--3.9 Trabajos dirigidos para la titulación de estudiantes-->
                            <h4>Puntaje máximo
                                <label class="bg-black text-white px-4 mt-3" for="">200</label>
                            </h4>
                            </div>
                            <table class="table table-sm tutorias">
                                <thead>
                                    <tr>
                                        <th>
                                            <h3></h3>
                                        </th>
                                        <th>
                                            <h3></h3>
                                        </th>
                                        <th>
                                            <h3></h3>
                                        </th>
                                        <th>
                                            <h3></h3>
                                        </th>
                                        <th>
                                            <h3></h3>
                                        </th>
                                        <th>
                                            <h3>Tutorias</h3>
                                        </th>

                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th scope="col">Actividad</th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                        <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                        </th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th id="seccion3_9" scope="col" class="p3_9" colspan=9>3.9 Trabajos dirigidos para la
                                            titulación de estudiantes
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th id="score3_9">0</th>
                                        <th id="comision3_9">0</th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th class="acreditacion">Incisos</th>
                                        <th class="acreditacion">Actividad</th>
                                        <th class="acreditacion">Obra</th>
                                        <th class="acreditacion">Nivel</th>
                                        <th class="acreditacion">Puntaje</th>
                                        <th class="acreditacion">Cantidad</th>
                                        <th class="acreditacion">Subtotal</th>
                                        <th class="table-ajust" scope="col"></th>
                                        <th class="acreditacion">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>a)</td>
                                        <td>Revisión de</td>
                                        <td>Tesis</td>
                                        <td>Doctorado</td>
                                        <td id="puntajeTutorias20_1">20</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_1"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias1">0</td>
                                        <td><input type="value" id="tutoriasComision1" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_1" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>b)</td>
                                        <td>Proyecto de</td>
                                        <td>Tesis</td>
                                        <td>Maestría</td>
                                        <td id="puntajeTutorias15_1">15</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_2"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias2">0</td>
                                        <td><input type="value" id="tutoriasComision2" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_2" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>c)</td>
                                        <td>Proyecto de</td>
                                        <td>Tesis y otras</td>
                                        <td>TSU, Lic y especialidad</td>
                                        <td id="puntajeTutorias10_1">10</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_3"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias3">0</td>
                                        <td><input type="value" id="tutoriasComision3" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_3" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>d)</td>
                                        <td>Dirección trabajo en realización</td>
                                        <td>Tesis</td>
                                        <td>Doctorado</td>
                                        <td id="puntajeTutorias55">55</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_4"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias4">0</td>
                                        <td><input type="value" id="tutoriasComision4" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_4" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>e)</td>
                                        <td>Dirección trabajo en realización</td>
                                        <td>Tesis</td>
                                        <td>Maestria</td>
                                        <td id="puntajeTutorias45">45</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_5"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias5">0</td>
                                        <td><input type="value" id="tutoriasComision5" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_5" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>f)</td>
                                        <td>Dirección trabajo en realización</td>
                                        <td>Tesis y otras</td>
                                        <td>TSU, Lic y especialidad</td>
                                        <td id="puntajeTutorias35">35</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_6"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias6">0</td>
                                        <td><input type="value" id="tutoriasComision6" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_6" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>g)</td>
                                        <td>Dirección trabajo terminado</td>
                                        <td>Tesis</td>
                                        <td>Doctorado</td>
                                        <td id="puntajeTutorias70">70</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_7"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias7">0</td>
                                        <td><input type="value" id="tutoriasComision7" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_7" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>h)</td>
                                        <td>Dirección trabajo terminado</td>
                                        <td>Tesis</td>
                                        <td>Maestría</td>
                                        <td id="puntajeTutorias60">60</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_8"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias8">0</td>
                                        <td><input type="value" id="tutoriasComision8" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_8" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>i)</td>
                                        <td>Dirección trabajo terminado</td>
                                        <td>Tesis y otras</td>
                                        <td>TSU, Lic y especialidad</td>
                                        <td id="puntajeTutorias50">50</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_9"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias9">0</td>
                                        <td><input type="value" id="tutoriasComision9" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_9" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>j)</td>
                                        <td>Revisión de trabajo terminado</td>
                                        <td>Tesis</td>
                                        <td>Doctorado</td>
                                        <td id="puntajeTutorias30_1">30</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_10"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias10">0</td>
                                        <td><input type="value" id="tutoriasComision10" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_10" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>k)</td>
                                        <td>Revisión de trabajo terminado</td>
                                        <td>Tesis</td>
                                        <td>Maestría</td>
                                        <td id="puntajeTutorias20_2">50</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_11"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias11">0</td>
                                        <td><input type="value" id="tutoriasComision11" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_11" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>l)</td>
                                        <td>Revisión de trabajo terminado</td>
                                        <td>Tesis y otras</td>
                                        <td>TSU, Lic y especialidad</td>
                                        <td id="puntajeTutorias15_2">15</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_12"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias12">0</td>
                                        <td><input type="value" id="tutoriasComision12" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_12" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>m)</td>
                                        <td>Sinodalía</td>
                                        <td>Examen</td>
                                        <td>Doctorado</td>
                                        <td id="puntajeTutorias30_2">30</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_13"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias13">0</td>
                                        <td><input type="value" id="tutoriasComision13" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_13" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>n)</td>
                                        <td>Sinodalía</td>
                                        <td>Examen</td>
                                        <td>Maestría</td>
                                        <td id="puntajeTutorias20_3">15</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_14"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias14">0</td>
                                        <td><input type="value" id="tutoriasComision14" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_14" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>o)</td>
                                        <td>Sinodalía</td>
                                        <td>Examen</td>
                                        <td>TSU, Lic y especialidad</td>
                                        <td id="puntajeTutorias15_3">15</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_15"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias15">0</td>
                                        <td><input type="value" id="tutoriasComision15" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_15" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>p)</td>
                                        <td>Distinciones</td>
                                        <td></td>
                                        <td>Doctorado</td>
                                        <td id="puntajeTutorias15_4">15</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_16"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias16">0</td>
                                        <td><input type="value" id="tutoriasComision16" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_16" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>q)</td>
                                        <td>Distinciones</td>
                                        <td></td>
                                        <td>Maestría</td>
                                        <td id="puntajeTutorias10_2">10</td>
                                        <td><input type="value" placeholder="0" id="puntaje3_9_17"
                                                oninput="onActv3SubTotal3_9()"></td>
                                        <td id="tutorias17">0</td>
                                        <td><input type="value" id="tutoriasComision17" placeholder="0"
                                                oninput="onActv3Comision3_9()">
                                        </td>
                                        <td><input class="table-header" id="obs3_9_17" type="text"></td>
                                    </tr>
                                    <!--Tabla informativa Acreditacion Actividad 3.9-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col">Acreditacion: </th>

                                                <th class="descripcion"><b>DSE para pregrado, DIIP para posgrado</b>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </tbody>
                            </table>
                            </form>
                                        <!--3.10 Trabajos dirigidos para la titulación de estudiantes-->
                                        <h4>Puntaje máximo
                                            <label class="bg-black text-white px-4 mt-3" for="">115</label>
                                        </h4>
                                        <table class="table table-sm tutorias">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan=3>Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <th id="seccion3_10" class="acreditacion" colspan=2>3.10 Tutorías a estudiantes</th>
                                                    <th class="acreditacion">Puntaje</th>
                                                    <th class="acreditacion">cantidad</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th id="score3_10">0</th>
                                                    <th id="comision3_10">0</th>
                                                    <th class="acreditacion" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <!--Tutorias a estudantes 3_10 individuales, grupales -->
                                                        <td>a)</td>
                                                        <td>Por alumno(a) por semestre, grupales</td>
                                                        <td id="puntajeGrupales">3</td>
                                                        <td><input type="value" id="grupalesCant"
                                                                oninput="onActv3SubTotal3_10()" placeholder="0">
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="evaluarGrupales"></td>
                                                        <td><input type="value" id="comisionGrupal"
                                                                oninput="onActv3Comision3_10()" placeholder="0">
                                                        </td>
                                                        <td><input class="table-header" type="text" id="obsGrupal"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>b)</td>
                                                        <td>Por alumno(a) por semestre, individuales</td>
                                                        <td id="puntajeIndividual">6</td>
                                                        <td><input type="value" id="individualCant"
                                                                oninput="onActv3SubTotal3_10()" placeholder="0">
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="evaluarIndividual"></td>
                                                        <td><input type="value" id="comisionIndividual"
                                                                oninput="onActv3Comision3_10()" placeholder="0">
                                                        </td>
                                                        <td><input class="table-header" type="text" id="obsIndividual"></td>
                                                    </tr>
                                                </thead>
                                                <!--Tabla informativa Acreditacion Actividad 3.10-->
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th class="acreditacion" scope="col">Acreditacion: </th>

                                                            <th class="descripcion"><b>DDIE</b> </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </tbody>
                                        </table>
                                        <!--3.11 Trabajos dirigidos para la titulación de estudiantes-->
                                        <h4>Puntaje máximo
                                            <label class="bg-black text-white px-4 mt-3" for="">95</label>
                                        </h4>
                                        <table class="table table-sm tutorias">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan=3>Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <th id="seccion3_11" class="acreditacion" colspan=5>3.11 Asesoría a estudiantes</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th id="score3_11">0</th>
                                                    <th id="comision3_11">0</th>
                                                    <th class="acreditacion" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <th class="acreditacion">Incisos</th>
                                                    <th class="acreditacion">Documento</th>
                                                    <th class="acreditacion">Actividad</th>
                                                    <th class="acreditacion">Puntaje</th>
                                                    <th class="acreditacion">Cantidad</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="acreditacion">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--3_11 Asesoria a estudiantes incisos-->
                                                <tr>
                                                    <td>a)</td>
                                                    <td>Asesorías académicas</td>
                                                    <td>Por alumno(a), por semestre</td>
                                                    <td id="academica">5</td>
                                                    <td><input type="value" placeholder="0" id="cantAsesoria"
                                                            oninput="onActv3SubTotal3_11()"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td id="subtotalAsesoria"></td>
                                                    <td><input type="value" id="comisionAsesoria" placeholder="0"
                                                            oninput="onActv3Comision3_11()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsAsesoria"></td>
                                                </tr>
                                                <tr>
                                                    <td>b)</td>
                                                    <td>Servicio social*</td>
                                                    <td>Por alumno(a), por semestre</td>
                                                    <td id="servicio">20</td>
                                                    <td><input type="value" placeholder="0" id="cantServicio"
                                                            oninput="onActv3SubTotal3_11()"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td id="subtotalServicio"></td>
                                                    <td><input type="value" id="comisionServicio" placeholder="0"
                                                            oninput="onActv3Comision3_11()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsServicio"></td>
                                                </tr>
                                                <tr>
                                                    <td>c)</td>
                                                    <td>Prácticas profesionales</td>
                                                    <td>Por alumno(a), por semestre</td>
                                                    <td id="practicas">20</td>
                                                    <td><input type="value" placeholder="0" id="cantPracticas"
                                                            oninput="onActv3SubTotal3_11()"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td id="subtotalPracticas"></td>
                                                    <td><input type="value" id="comisionPracticas" placeholder="0"
                                                            oninput="onActv3Comision3_11()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsPracticas"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--Tabla informativa Acreditacion Actividad 3.11-->
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="acreditacion" scope="col">Acreditacion: </th>

                                                    <th class="descripcion"><b>JD, *DSEs</b> </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        </tbody>
                                    </table>
                                    <!--3.12 Trabajos dirigidos para la titulación de estudiantes-->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">150</label>
                                    </h4>
                                    <table class="table table-sm tutorias">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan=3>Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th id="seccion3_12" class="acreditacion" colspan=7>3.12 Publicaciones de investigación
                                                    relacionadas con el
                                                    contenido
                                                    de los PE que imparte el docente</th>
                                                <th></th>
                                                <th id="score3_12">0</th>
                                                <th id="comision3_12">0</th>
                                                <th class="acreditacion" scope="col">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion">Incisos</th>
                                                <th class="acreditacion">Actividad</th>
                                                <th class="acreditacion">Obra</th>
                                                <th class="acreditacion">Nivel</th>
                                                <th class="acreditacion">Puntaje</th>
                                                <th class="acreditacion">Cantidad</th>
                                                <th></th>
                                                <th></th>
                                                <th class="acreditacion">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--3_12 Publicaciones de investigación incisos-->
                                            <tr>
                                                <td>a)</td>
                                                <td>Autor(a) o coautor(a) de libros, técnicos, científicos y humanísticos</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td id="puntajeCientificos">100</td>
                                                <td><input type="value" placeholder="0" id="cantCientifico"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalCientificos"></td>
                                                <td><input type="value" id="comisionCientificos" placeholder="0"
                                                        oninput="onActv3Comision3_12()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCientificos"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Autor(a) o coautor(a) de libros de divulgación</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td id="puntajeDivulgacion">50</td>
                                                <td><input type="value" placeholder="0" id="cantDivulgacion"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalDivulgacion"></td>
                                                <td><input type="value" id="comisionDivulgacion" placeholder="0"
                                                        oninput="onActv3Comision3_12()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsDivulgacion"></td>
                                            </tr>
                                            <tr>
                                                <td>c)</td>
                                                <td>Traducción de libros</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td id="puntajeTraduccion">40</td>
                                                <td><input type="value" placeholder="0" id="cantTraduccion"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalTraduccion"></td>
                                                <td><input type="value" id="comisionTraduccion" placeholder="0"
                                                        oninput="onActv3Comision3_12()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsTraduccion"></td>
                                            </tr>
                                            <tr>
                                                <td>d)</td>
                                                <td>Autor(a) o coautor(a) de artículos</td>
                                                <td>Con Arbitraje</td>
                                                <td>Internacional</td>
                                                <td id="puntajeArbitrajeInt">60</td>
                                                <td><input type="value" placeholder="0" id="cantArbitrajeInt"
                                                        oninput="onActv3SubTotal3_12()">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalArbitrajeInt"></td>
                                                <td><input type="value" id="comisionArbitrajeInt" placeholder="0"
                                                        oninput="onActv3Comision3_12()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsArbitrajeInt"></td>
                                            </tr>
                                            <tr>
                                                <td>e)</td>
                                                <td>Autor(a) o coautor(a) de artículos</td>
                                                <td>Con Arbitraje</td>
                                                <td>Nacional</td>
                                                <td id="puntajeArbitrajeNac">30</td>
                                                <td><input type="value" placeholder="0" id="cantArbitrajeNac"
                                                        oninput="onActv3SubTotal3_12()">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalArbitrajeNac"></td>
                                                <td><input type="value" id="comisionArbitrajeNac" placeholder="0"
                                                        oninput="onActv3Comision3_12()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsArbitrajeNac"></td>
                                            </tr>
                                            <tr>
                                                <td>f)</td>
                                                <td>Autor(a) o coautor(a) de artículos</td>
                                                <td>Sin Arbitraje</td>
                                                <td>Internacional</td>
                                                <td id="puntajeSinInt">15</td>
                                                <td><input type="value" placeholder="0" id="cantSinInt"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalSinInt"></td>
                                                <td><input type="value" id="comisionSinInt" placeholder="0"
                                                        oninput="onActv3Comision3_12()"></td>
                                                <td><input class="table-header" type="text" id="obsSinInt"></td>
                                            </tr>
                                            <tr>
                                                <td>g)</td>
                                                <td>Autor(a) o coautor(a) de artículos</td>
                                                <td>Sin Arbitraje</td>
                                                <td>Nacional</td>
                                                <td id="puntajeSinNac">10</td>
                                                <td><input type="value" placeholder="0" id="cantSinNac"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalSinNac"></td>
                                                <td><input type="value" id="comisionSinNac" placeholder="0"
                                                        oninput="onActv3Comision3_12()"></td>
                                                <td><input class="table-header" type="text" id="obsSinNac"></td>
                                            </tr>
                                            <tr>
                                                <td>h)</td>
                                                <td>Capítulo de libro especializado</td>
                                                <td>Autor(a) o coautor (a) de capítulo de libro internacional o nacional</td>
                                                <td>--</td>
                                                <td id="puntajeAutor">25</td>
                                                <td><input type="value" placeholder="0" id="cantAutor"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalAutor"></td>
                                                <td><input type="value" id="comisionAutor" placeholder="0"
                                                        oninput="onActv3Comision3_12()"></td>
                                                <td><input class="table-header" type="text" id="obsAutor"></td>
                                            </tr>
                                            <tr>
                                                <td>i)</td>
                                                <td>Capítulo de libro especializado</td>
                                                <td>Editor(a) o coeditor(a) de libro</td>
                                                <td>--</td>
                                                <td id="puntajeEditor">25</td>
                                                <td><input type="value" placeholder="0" id="cantEditor"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalEditor"></td>
                                                <td><input type="value" id="comisionEditor" placeholder="0"
                                                        oninput="onActv3Comision3_12()"></td>
                                                <td><input class="table-header" type="text" id="obsEditor"></td>
                                            </tr>
                                            <tr>
                                                <td>j)</td>
                                                <td>Sitio web</td>
                                                <td>Diseño de sitio web</td>
                                                <td>--</td>
                                                <td id="puntajeWeb">20</td>
                                                <td><input type="value" placeholder="0" id="cantWeb"
                                                        oninput="onActv3SubTotal3_12()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalWeb"></td>
                                                <td><input type="value" id="comisionWeb" placeholder="0"
                                                        oninput="onActv3Comision3_12()"></td>
                                                <td><input class="table-header" type="text" id="obsWeb"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Tabla informativa Acreditacion Actividad 3.12-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col">Acreditacion: </th>

                                                <th class="descripcion"><b>Instancia que la otorga</b> </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!--3.13 Proyectos académicos de investigación-->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">130</label>
                                    </h4>
                                    <table class="table table-sm tutorias">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan=3>Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th id="seccion3_13" class="acreditacion" colspan=7>3.13 Proyectos académicos de investigación</th>
                                            <th id="score3_13">0</th>
                                            <th id="comision3_13">0</th>
                                            <th class="acreditacion" scope="col">Observaciones</th>
                                        </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion">Incisos</th>
                                                <th class="acreditacion">Documento</th>
                                                <th class="acreditacion">Puntaje</th>
                                                <th class="acreditacion">Cantidad</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="acreditacion">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--Incisos 3.13-->
                                            <tr>
                                                <td>a)</td>
                                                <td>Inicio de proyecto de investigación con financiamiento externo</td>
                                                <td id="puntajeInicioFinanExt">50</td>
                                                <td><input type="value" placeholder="0" id="cantInicioFinanExt"
                                                        oninput="onActv3SubTotal3_13()">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalInicioFinanExt"></td>
                                                <td><input type="value" id="comisionInicioFinancimientoExt" placeholder="0"
                                                        oninput="onActv3Comision3_13()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsInicioFinancimientoExt"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Inicio de proyecto de investigación interno, aprobado por CAAC</td>
                                                <td id="puntajeInicioInvInterno">25</td>
                                                <td><input type="value" placeholder="0" id="cantInicioInvInterno"
                                                        oninput="onActv3SubTotal3_13()">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalInicioInvInterno"></td>
                                                <td><input type="value" id="comisionInicioInvInterno" placeholder="0"
                                                        oninput="onActv3Comision3_13()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsInicioInvInterno"></td>
                                            </tr>
                                            <tr>
                                                <td>c)</td>
                                                <td>Reporte cumplido del periodo anual del proyecto de investigación con
                                                    financiamiento externo
                                                </td>
                                                <td id="puntajeReporteFinanciamExt">100</td>
                                                <td><input type="value" placeholder="0" id="cantReporteFinanciamExt"
                                                        oninput="onActv3SubTotal3_13()">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalReporteFinanciamExt"></td>
                                                <td><input type="value" id="comisionReporteFinanciamExt" placeholder="0"
                                                        oninput="onActv3Comision3_13()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsReporteFinanciamExt"></td>
                                            </tr>
                                            <tr>
                                                <td>d)</td>
                                                <td>Reporte cumplido del periodo anual del proyecto de investigación interno,
                                                    aprobado por CAAC
                                                </td>
                                                <td id="puntajeReporteInvInt">100</td>
                                                <td><input type="value" placeholder="0" id="cantReporteInvInt"
                                                        oninput="onActv3SubTotal3_13()">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalReporteInvInt"></td>
                                                <td><input type="value" id="comisionReporteInvInt" placeholder="0"
                                                        oninput="onActv3Comision3_13()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsReporteInvInt"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Tabla informativa Acreditacion Actividad 3.13-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col">Acreditacion: </th>

                                                <th class="descripcion"><b>CAAC, DIIP</b> </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!--3.14 Participación como ponente en congresos o eventos académicos del Área de Conocimiento o afines del docente-->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">40</label>
                                    </h4>
                                    <table class="table table-sm tutorias">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan=3>Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th id="seccion3_14" class="acreditacion" colspan=7>3.14 Participación como ponente en congresos
                                                    o eventos
                                                    académicos
                                                    del Área de Conocimiento o afines del docente</th>
                                                <th id="score3_14">0</th>
                                                <th id="comision3_14">0</th>
                                                <th class="acreditacion" scope="col">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" colspan=2>Congresos y eventos académicos</th>
                                                <th class="acreditacion">Puntaje</th>
                                                <th class="acreditacion">Cantidad</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="acreditacion">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--Incisos 3.14-->
                                            <tr>
                                                <td>a)</td>
                                                <td>Internacional</td>
                                                <td id="puntajeCongresoInt"><b>25</b></td>
                                                <td><input type="value" placeholder="0" id="cantCongresoInt"
                                                        oninput="onActv3SubTotal3_14()"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalCongresoInt">0</td>
                                                <td><input type="value" id="comisionCongresoInt" placeholder="0"
                                                        oninput="onActv3Comision3_14()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCongresoInt"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Nacional</td>
                                                <td id="puntajeCongresoNac"><b>20</b></td>
                                                <td><input type="value" placeholder="0" id="cantCongresoNac"
                                                        oninput="onActv3SubTotal3_14()"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalCongresoNac">0</td>
                                                <td><input type="value" id="comisionCongresoNac" placeholder="0"
                                                        oninput="onActv3Comision3_14()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCongresoNac"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Local</td>
                                                <td id="puntajeCongresoLoc"><b>10</b></td>
                                                <td><input type="value" placeholder="0" id="cantCongresoLoc"
                                                        oninput="onActv3SubTotal3_14()"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalCongresoLoc">0</td>
                                                <td><input type="value" id="comisionCongresoLoc" placeholder="0"
                                                        oninput="onActv3Comision3_14()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCongresoLoc"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Tabla informativa Acreditacion Actividad 3.14-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col">Acreditacion: </th>

                                                <th class="descripcion"><b>Instancia que otorga</b> </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!--3.15 Registro de patentes y productos de investigación tecnológica y educativa -->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">60</label>
                                    </h4>
                                    <table class="table table-sm tutorias">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan=3>Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th id="seccion3_15" class="acreditacion" colspan=2>3.15 Registro de patentes y productos de
                                                    investigación
                                                    tecnológica
                                                    y educativa</th>
                                                <th class="acreditacion">Puntaje</th>
                                                <th class="acreditacion">Cantidad</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th id="score3_15">0</th>
                                                <th id="comision3_15">0</th>
                                                <th class="acreditacion" scope="col">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>a)</td>
                                                <td>Registro de patentes</td>
                                                <td id="puntajePatentes"><b>60</b></td>
                                                <td><input type="value" id="cantPatentes" placeholder="0"
                                                        oninput="onActv3SubTotal3_15()"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalPatentes">0</td>
                                                <td><input type="value" id="comisionPatententes" placeholder="0"
                                                        oninput="onActv3Comision3_15()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsPatentes"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Desarrollo de prototipos</td>
                                                <td id="puntajePrototipos"><b>30</b></td>
                                                <td><input type="value" id="cantPrototipos" placeholder="0"
                                                        oninput="onActv3SubTotal3_15()"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalPrototipos">0</td>
                                                <td><input type="value" id="comisionPrototipos" placeholder="0"
                                                        oninput="onActv3Comision3_15()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsPrototipos"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Tabla informativa Acreditacion Actividad 3.15-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col">Acreditacion: </th>

                                                <th class="descripcion"><b>IMPI</b></th>
                                            </tr>
                                        </thead>
                                    </table> <br>
                                    <!--3.16 Actividades de arbitraje, revisión, correción y edición -->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">30</label>
                                    </h4>
                                    <table class="table table-sm tutorias">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h3></h3>
                                                </th>
                                                <th>
                                                    <h3></h3>
                                                </th>
                                                <th>
                                                    <h3>Investigación</h3>
                                                </th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan=3>Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th id="seccion3_16" class="acreditacion" colspan=7> 3.16 Actividades de arbitraje, revisión,
                                                    correción y edición
                                                </th>
                                                <th id="score3_16">0</th>
                                                <th id="comision3_16">0</th>
                                                <th class="acreditacion" scope="col">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion">Incisos</th>
                                                <th class="acreditacion">Actividad</th>
                                                <th class="acreditacion">Nivel</th>
                                                <th class="acreditacion">Puntaje</th>
                                                <th class="acreditacion">Cantidad</th>
                                                <th></th>
                                                <th></th>
                                                <th class="acreditacion">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>a)</td>
                                                <td>Arbitraje a proyectos de investigación</td>
                                                <td>Internacional</td>
                                                <td id="puntajeArbInt"><b>30</b></td>
                                                <td><input type="value" id="cantArbInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_16()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalArbInt"></td>
                                                <td><input type="value" id="comisionArbInt" placeholder="0"
                                                        oninput="onActv3Comision3_16()"></td>
                                                <td><input class="table-header" type="text" id="obsArbInt"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Arbitraje a proyectos de investigación</td>
                                                <td>Nacional</td>
                                                <td id="puntajeArbINac"><b>25</b></td>
                                                <td><input type="value" id="cantArbNac" placehoolder="0"
                                                        oninput="onActv3SubTotal3_16()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalArbNac"></td>
                                                <td><input type="value" id="comisionArbNac" placeholder="0"
                                                        oninput="onActv3Comision3_16()"></td>
                                                <td><input class="table-header" type="text" id="obsArbNac"></td>
                                            </tr>
                                            <tr>
                                                <td>c)</td>
                                                <td>Arbitraje de publicaciones</td>
                                                <td>Internacional</td>
                                                <td id="puntajePubInt"><b>20</b></td>
                                                <td><input type="value" id="cantPubInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_16()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalPubInt"></td>
                                                <td><input type="value" id="comisionPubInt" placeholder="0"
                                                        oninput="onActv3Comision3_16()"></td>
                                                <td><input class="table-header" type="text" id="obsPubInt"></td>
                                            </tr>
                                            <tr>
                                                <td>d)</td>
                                                <td>Arbitraje de publicaciones</td>
                                                <td>Nacional</td>
                                                <td id="puntajePubINac"><b>10</b></td>
                                                <td><input type="value" id="cantPubNac" placehoolder="0"
                                                        oninput="onActv3SubTotal3_16()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalPubNac"></td>
                                                <td><input type="value" id="comisionPubNac" placeholder="0"
                                                        oninput="onActv3Comision3_16()"></td>
                                                <td><input class="table-header" type="text" id="obsPubNac"></td>
                                            </tr>
                                            <tr>
                                                <td>e)</td>
                                                <td>Revisor(a) de libros, corrector(a)</td>
                                                <td>Internacional</td>
                                                <td id="puntajeRevInt"><b>30</b></td>
                                                <td><input type="value" id="cantRevInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_16()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalRevInt"></td>
                                                <td><input type="value" id="comisionRevInt" placeholder="0"
                                                        oninput="onActv3Comision3_16()"></td>
                                                <td><input class="table-header" type="text" id="obsRevInt"></td>
                                            </tr>
                                            <tr>
                                                <td>f)</td>
                                                <td>Revisor(a) de libros, corrector(a)</td>
                                                <td>Nacional</td>
                                                <td id="puntajeRevINac"><b>25</b></td>
                                                <td><input type="value" id="cantRevNac" placehoolder="0"
                                                        oninput="onActv3SubTotal3_16()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalRevNac"></td>
                                                <td><input type="value" id="comisionRevNac" placeholder="0"
                                                        oninput="onActv3Comision3_16()"></td>
                                                <td><input class="table-header" type="text" id="obsRevNac"></td>
                                            </tr>
                                            <tr>
                                                <td>g)</td>
                                                <td>Consejo editorial de revista, edición de revista</td>
                                                <td>----</td>
                                                <td id="puntajeRevista"><b>10</b></td>
                                                <td><input type="value" id="cantRevista" placehoolder="0"
                                                        oninput="onActv3SubTotal3_16()"></td>
                                                <td></td>
                                                <td></td>
                                                <td id="subtotalRevista"></td>
                                                <td><input type="value" id="comisionRevista" placeholder="0"
                                                        oninput="onActv3Comision3_16()"></td>
                                                <td><input class="table-header" type="text" id="obsRevista"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Tabla informativa Acreditacion Actividad 3.16-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col">Acreditacion: </th>

                                                <th class="descripcion"><b>Institución que lo solicita. En el caso de la UABCS,
                                                        DIIP, SG, CA,
                                                        JD.</b>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table> <br>
                                    <!--3.17 Proyectos académicos de extensión y difusión-->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">50</label>
                                    </h4>
                                    <table class="table table-sm tutorias">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h3></h3>
                                                </th>
                                                <th>
                                                    <h3></h3>
                                                </th>
                                                <th>
                                                    <h3 style="width: 50px;">Cuerpos Colegiados</h3>
                                                </th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan=2>Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th id="seccion3_17" class="acreditacion" colspan=3> 3.17 Proyectos académicos de extensión y
                                                    difusión</th>
                                                <th class="acreditacion">Puntaje</th>
                                                <th class="acreditacion">Cantidad</th>
                                                <th></th>
                                                <th id="score3_17">0</th>
                                                <th id="comision3_17">0</th>
                                                <th class="acreditacion" scope="col">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>a)</td>
                                                <td>Inicio de proyectos de extensión y difusión con financiamiento externo</td>
                                                <td></td>
                                                <td id="puntajeDifusionExt"><b>15</b></td>
                                                <td><input type="value" id="cantDifusionExt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_17()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalDifusionExt"></td>
                                                <td><input type="value" id="comisionDifusionExt" placeholder="0"
                                                        oninput="onActv3Comision3_17()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsDifusionExt"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Inicio de proyectos de extensión y difusión internos, aprobados por CAAC
                                                </td>
                                                <td></td>
                                                <td id="puntajeDifusionInt"><b>10</b></td>
                                                <td><input type="value" id="cantDifusionInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_17()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalDifusionInt"></td>
                                                <td><input type="value" id="comisionDifusionInt" placeholder="0"
                                                        oninput="onActv3Comision3_17()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsDifusionInt"></td>
                                            </tr>
                                            <tr>
                                                <td>c)</td>
                                                <td>Reporte cumplido del periodo anual de proyecto de extensión y difusión con
                                                    financiamiento
                                                    externo
                                                </td>
                                                <td></td>
                                                <td id="puntajeRepDifusionExt"><b>35</b></td>
                                                <td><input type="value" id="cantRepDifusionExt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_17()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalRepDifusionExt"></td>
                                                <td><input type="value" id="comisionRepDifusionExt" placeholder="0"
                                                        oninput="onActv3Comision3_17()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsRepDifusionExt"></td>
                                            </tr>
                                            <tr>
                                                <td>d)</td>
                                                <td>Reporte cumplido del periodo anual de proyecto de extensión y difusión
                                                    internos, aprobados por
                                                    CAAC</td>
                                                <td></td>
                                                <td id="puntajeRepDifusionInt"><b>20</b></td>
                                                <td><input type="value" id="cantRepDifusionInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_17()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalRepDifusionInt"></td>
                                                <td><input type="value" id="comisionRepDifusionInt" placeholder="0"
                                                        oninput="onActv3Comision3_17()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsRepDifusionInt"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Tabla informativa Acreditacion Actividad 3.17-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col">Acreditacion: </th>
                                                <th class="descripcion"><b>CAAC, DDCEU</b></th>
                                            </tr>
                                        </thead>
                                    </table><br>
                                    <!--3.18 Organización de congresos o eventos institucionales del área de conocimiento de la o el Docente-->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">40</label>
                                    </h4>
                                    <table class="table table-sm tutorias">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan=2>Actividad</th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust" scope="col"></th>
                                                <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th id="seccion3_18" class="acreditacion" colspan=5> 3.18 Organización de congresos o eventos
                                                    institucionales del
                                                    área
                                                    de conocimiento de la o el Docente</th>
                                                <th></th>
                                                <th></th>
                                                <th id="score3_18">0</th>
                                                <th id="comision3_18">0</th>
                                                <th class="acreditacion" scope="col">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion">Incisos</th>
                                                <th class="acreditacion" colspan=1 style="padding-left: 170px;">Actividad</th>
                                                <th></th>
                                                <th class="acreditacion">Nivel</th>
                                                <th class="acreditacion">Puntaje</th>
                                                <th class="acreditacion">Cantidad</th>
                                                <th></th>
                                                <th class="acreditacion">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>a)</td>
                                                <td>Comité organizador</td>
                                                <td></td>
                                                <td>Internacional**</td>
                                                <td id="puntajeComOrgInt"><b>40</b></td>
                                                <td><input type="value" id="cantComOrgInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()"></td>
                                                <td></td>
                                                <td id="subtotalComOrgInt"></td>
                                                <td><input type="value" id="comisionComOrgInt" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsComOrgInt"></td>
                                            </tr>
                                            <tr>
                                                <td>b)</td>
                                                <td>Comité organizador</td>
                                                <td></td>
                                                <td>Nacional</td>
                                                <td id="puntajeComOrgNac"><b>20</b></td>
                                                <td><input type="value" id="cantComOrgNac" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()"></td>
                                                <td></td>
                                                <td id="subtotalComOrgNac"></td>
                                                <td><input type="value" id="comisionComOrgNac" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsComOrgNac"></td>
                                            </tr>
                                            <tr>
                                                <td>c)</td>
                                                <td>Comité organizador</td>
                                                <td></td>
                                                <td>Regional</td>
                                                <td id="puntajeComOrgRegc"><b>10</b></td>
                                                <td><input type="value" id="cantComOrgReg" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()"></td>
                                                <td></td>
                                                <td id="subtotalComOrgReg"></td>
                                                <td><input type="value" id="comisionComOrgReg" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsComOrgReg"></td>
                                            </tr>
                                            <tr>
                                                <td>d)</td>
                                                <td>Comisiones de Apoyo</td>
                                                <td></td>
                                                <td>Internacional</td>
                                                <td id="puntajeComApoyoInt"><b>40</b></td>
                                                <td><input type="value" id="cantComApoyoInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalComApoyoInt"></td>
                                                <td><input type="value" id="comisionComApoyoInt" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsComApoyoInt"></td>
                                            </tr>
                                            <tr>
                                                <td>e)</td>
                                                <td>Comisiones de Apoyo</td>
                                                <td></td>
                                                <td>Nacional</td>
                                                <td id="puntajeComApoyoNac"><b>20</b></td>
                                                <td><input type="value" id="cantComApoyoNac" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalComApoyoNac"></td>
                                                <td><input type="value" id="comisionComApoyoNac" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsComApoyoNac"></td>
                                            </tr>
                                            <tr>
                                                <td>f)</td>
                                                <td>Comisiones de Apoyo</td>
                                                <td></td>
                                                <td>Regional</td>
                                                <td id="puntajeComApoyoRegc"><b>10</b></td>
                                                <td><input type="value" id="cantComApoyoReg" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalComApoyoReg"></td>
                                                <td><input type="value" id="comisionComApoyoReg" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsComApoyoReg"></td>
                                            </tr>
                                            <tr>
                                                <td>g)</td>
                                                <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                                                <td>Comité organizador</td>
                                                <td>Internacional</td>
                                                <td id="puntajeCicloComOrgInt"><b>20</b></td>
                                                <td><input type="value" id="cantCicloComOrgInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalCicloComOrgInt"></td>
                                                <td><input type="value" id="comisionCicloComOrgInt" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCicloComOrgInt"></td>
                                            </tr>
                                            <tr>
                                                <td>h)</td>
                                                <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                                                <td>Comité organizador</td>
                                                <td>Nacional</td>
                                                <td id="puntajeCicloComOrgNac"><b>15</b></td>
                                                <td><input type="value" id="cantCicloComOrgNac" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalCicloComOrgNac"></td>
                                                <td><input type="value" id="comisionCicloComOrgNac" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCicloComOrgNac"></td>
                                            </tr>
                                            <tr>
                                                <td>i)</td>
                                                <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                                                <td>Comité organizador</td>
                                                <td>Regional/Institucional</td>
                                                <td id="puntajeCicloComOrgReg"><b>10</b></td>
                                                <td><input type="value" id="cantCicloComOrgReg" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalCicloComOrgReg"></td>
                                                <td><input type="value" id="comisionCicloComOrgReg" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCicloComOrgReg"></td>
                                            </tr>
                                            <tr>
                                                <td>j)</td>
                                                <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                                                <td>Comisiones de apoyo</td>
                                                <td>Internacional</td>
                                                <td id="puntajeCicloComApoyoInt"><b>20</b></td>
                                                <td><input type="value" id="cantCicloComApoyoInt" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalCicloComApoyoInt"></td>
                                                <td><input type="value" id="comisionCicloComApoyoInt" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCicloComApoyoInt"></td>
                                            </tr>
                                            <tr>
                                                <td>k)</td>
                                                <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                                                <td>Comisiones de apoyo</td>
                                                <td>Nacional</td>
                                                <td id="puntajeCicloComApoyoNac"><b>15</b></td>
                                                <td><input type="value" id="cantCicloComApoyoNac" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalCicloComApoyoNac"></td>
                                                <td><input type="value" id="comisionCicloComApoyoNac" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCicloComApoyoNac"></td>
                                            </tr>
                                            <tr>
                                                <td>l)</td>
                                                <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                                                <td>Comisiones de apoyo</td>
                                                <td>Regional/Institucional</td>
                                                <td id="puntajeCicloComApoyoReg"><b>10</b></td>
                                                <td><input type="value" id="cantCicloComApoyoReg" placehoolder="0"
                                                        oninput="onActv3SubTotal3_18()">
                                                </td>
                                                <td></td>
                                                <td id="subtotalCicloComApoyoReg"></td>
                                                <td><input type="value" id="comisionCicloComApoyoReg" placeholder="0"
                                                        oninput="onActv3Comision3_18()">
                                                </td>
                                                <td><input class="table-header" type="text" id="obsCicloComApoyoReg"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Tabla informativa Acreditacion Actividad 3.18-->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="acreditacion" scope="col" colspan=2> **Coparticipación técnica y/o
                                                    académica y/o
                                                    financiera
                                                    de institución extranjera</th>
                                                <th class="acreditacion" style="padding-left: 100px;">Acreditacion:</th>
                                                <th class="descripcion"><b>Instancia que lo otorga</b></th>
                                            </tr>
                                        </thead>
                                    </table><br>
                                    <!--3.19 Participación en cuerpos colegiados-->
                                    <h4>Puntaje máximo
                                        <label class="bg-black text-white px-4 mt-3" for="">40</label>
                                    </h4>
                                    <table>
                                        <table class="table table-sm tutorias">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan=2>Actividad</th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust" scope="col"></th>
                                                    <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
                                                    <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                                                    </th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <th id="seccion3_19" class="acreditacion" colspan=5> 3.19 Participación en cuerpos colegiados
                                                    </th>
                                                    <th></th>
                                                    <th></th>
                                                    <th id="score3_19">0</th>
                                                    <th id="comision3_19">0</th>
                                                    <th class="acreditacion" scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <th class="acreditacion">Incisos</th>
                                                    <th class="acreditacion" colspan=1 style="padding-left: 170px;">Actividad
                                                    </th>
                                                    <th></th>
                                                    <th class="acreditacion">Nivel</th>
                                                    <th class="acreditacion">Puntaje</th>
                                                    <th class="acreditacion">Cantidad</th>
                                                    <th></th>
                                                    <th class="acreditacion">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>a)</td>
                                                    <td>Representante del profesorado ante H. CGU</td>
                                                    <td></td>
                                                    <td>Titular o suplente</td>
                                                    <td id="puntajeCGUtitular"><b>20</b></td>
                                                    <td><input type="value" id="cantCGUtitular" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalCGUtitular"></td>
                                                    <td><input type="value" id="comCGUtitular" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsCGUtitular"></td>
                                                </tr>
                                                <tr>
                                                    <td>b)</td>
                                                    <td>Representante del profesorado ante H. CGU</td>
                                                    <td></td>
                                                    <td>Participación como miembro de comisión especial</td>
                                                    <td id="puntajeCGUespecial"><b>15</b></td>
                                                    <td><input type="value" id="cantCGUespecial" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalCGUespecial"></td>
                                                    <td><input type="value" id="comCGUespecial" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsCGUespecial"></td>
                                                </tr>
                                                <tr>
                                                    <td>c)</td>
                                                    <td>Representante del profesorado ante H. CGU</td>
                                                    <td></td>
                                                    <td>Participación como miembro en comisión permanente</td>
                                                    <td id="puntajeCGUpermanente"><b>10</b></td>
                                                    <td><input type="value" id="cantCGUpermanente" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalCGUpermanente"></td>
                                                    <td><input type="value" id="comCGUpermanente" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsCGUpermanente"></td>
                                                </tr>
                                                <tr>
                                                    <td>d)</td>
                                                    <td>Representante del profesorado ante CAAC</td>
                                                    <td></td>
                                                    <td>Titular o suplente</td>
                                                    <td id="puntajeCAACtitular"><b>10</b></td>
                                                    <td><input type="value" id="cantCAACtitular" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalCAACtitular"></td>
                                                    <td><input type="value" id="comCAACtitular" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsCAACtitular"></td>
                                                </tr>
                                                <tr>
                                                    <td>e)</td>
                                                    <td>Representante del profesorado ante CAAC</td>
                                                    <td></td>
                                                    <td>Participación como integrante de comisión</td>
                                                    <td id="puntajeCAACintegCom"><b>5</b></td>
                                                    <td><input type="value" id="cantCAACintegCom" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalCAACintegCom"></td>
                                                    <td><input type="value" id="comCAACintegCom" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsCAACintegCom"></td>
                                                </tr>
                                                <tr>
                                                    <td>f)</td>
                                                    <td>Comisiones</td>
                                                    <td></td>
                                                    <td>Departamentales</td>
                                                    <td id="puntajeComDepart"><b>15</b></td>
                                                    <td><input type="value" id="cantComDepart" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()"></td>
                                                    <td></td>
                                                    <td id="subtotalComDepart"></td>
                                                    <td><input type="value" id="comComDepart" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsComDepart"></td>
                                                </tr>
                                                <tr>
                                                    <td>g)</td>
                                                    <td>Comisiones</td>
                                                    <td></td>
                                                    <td>Dictaminadora del PEDPD</td>
                                                    <td id="puntajeComPEDPD"><b>15</b></td>
                                                    <td><input type="value" id="cantComPEDPD" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()"></td>
                                                    <td></td>
                                                    <td id="subtotalComPEDPD"></td>
                                                    <td><input type="value" id="comComPEDPD" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsComPEDPD"></td>
                                                </tr>
                                                <tr>
                                                    <td>h)</td>
                                                    <td>Comisiones</td>
                                                    <td></td>
                                                    <td>Participación como integrante del Comité Académico de Posgrado</td>
                                                    <td id="puntajeComPartPos"><b>5</b></td>
                                                    <td><input type="value" id="cantComPartPos" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalComPartPos"></td>
                                                    <td><input type="value" id="comComPartPos" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsComPartPos"></td>
                                                </tr>
                                                <tr>
                                                    <td>i)</td>
                                                    <td>Resonsable</td>
                                                    <td></td>
                                                    <td>De posgrado</td>
                                                    <td id="puntajeRespPos"><b>25</b></td>
                                                    <td><input type="value" id="cantRespPos" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()"></td>
                                                    <td></td>
                                                    <td id="subtotalRespPos"></td>
                                                    <td><input type="value" id="comRespPos" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsRespPos"></td>
                                                </tr>
                                                <tr>
                                                    <td>j)</td>
                                                    <td>Resonsable</td>
                                                    <td></td>
                                                    <td>De carrera</td>
                                                    <td id="puntajeRespCarrera"><b>15</b></td>
                                                    <td><input type="value" id="cantRespCarrera" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalRespCarrera"></td>
                                                    <td><input type="value" id="comRespCarrera" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsRespCarrera"></td>
                                                </tr>
                                                <tr>
                                                    <td>k)</td>
                                                    <td>Resonsable</td>
                                                    <td></td>
                                                    <td>De unidad de producción</td>
                                                    <td id="puntajeRespProd"><b>20</b></td>
                                                    <td><input type="value" id="cantRespProd" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()"></td>
                                                    <td></td>
                                                    <td id="subtotalRespProd"></td>
                                                    <td><input type="value" id="comRespProd" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsRespProd"></td>
                                                </tr>
                                                <tr>
                                                    <td>l)</td>
                                                    <td>Resonsable</td>
                                                    <td></td>
                                                    <td>De laboratorio de docencia e investigación</td>
                                                    <td id="puntajeRespLab"><b>15</b></td>
                                                    <td><input type="value" id="cantRespLab" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()"></td>
                                                    <td></td>
                                                    <td id="subtotalRespLab"></td>
                                                    <td><input type="value" id="comRespLab" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsRespLab"></td>
                                                </tr>
                                                <tr>
                                                    <td>m)</td>
                                                    <td>Sinodalías de examen de oposición</td>
                                                    <td></td>
                                                    <td>Profesorado</td>
                                                    <td id="puntajeExamProf"><b>15</b></td>
                                                    <td><input type="value" id="cantExamProf" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()"></td>
                                                    <td></td>
                                                    <td id="subtotalExamProf"></td>
                                                    <td><input type="value" id="comExamProf" placeholder="0"
                                                            oninput="onActv3Comision3_19()"></td>
                                                    <td><input class="table-header" type="text" id="obsExamProf"></td>
                                                </tr>
                                                <tr>
                                                    <td>n)</td>
                                                    <td>Sinodalías de examen de oposición</td>
                                                    <td></td>
                                                    <td>Ayudantes académicos</td>
                                                    <td id="puntajeExamAcademicos"><b>5</b></td>
                                                    <td><input type="value" id="cantExamAcademicos" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalExamAcademicos"></td>
                                                    <td><input type="value" id="comExamAcademicos" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsExamAcademicos"></td>
                                                </tr>
                                                <tr>
                                                    <td>o1)</td>
                                                    <td>Cuerpo académico registrado ante PRODEP</td>
                                                    <td>En formación</td>
                                                    <td>Responsable</td>
                                                    <td id="puntajePRODEPformResp"><b>15</b></td>
                                                    <td><input type="value" id="cantPRODEPformResp" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalPRODEPformResp"></td>
                                                    <td><input type="value" id="comPRODEPformResp" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsPRODEPformResp"></td>
                                                </tr>
                                                <tr>
                                                    <td>o2)</td>
                                                    <td>Cuerpo académico registrado ante PRODEP</td>
                                                    <td>En formación</td>
                                                    <td>Integrante</td>
                                                    <td id="puntajePRODEPformInteg"><b>10</b></td>
                                                    <td><input type="value" id="cantPRODEPformInteg" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalPRODEPformInteg"></td>
                                                    <td><input type="value" id="comPRODEPformInteg" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsPRODEPformInteg"></td>
                                                </tr>
                                                <tr>
                                                    <td>p1)</td>
                                                    <td>Cuerpo académico registrado ante PRODEP</td>
                                                    <td>En consolidación</td>
                                                    <td>Responsable</td>
                                                    <td id="puntajePRODEPenconsResp"><b>25</b></td>
                                                    <td><input type="value" id="cantPRODEPenconsResp" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalPRODEPenconsResp"></td>
                                                    <td><input type="value" id="comPRODEPenconsResp" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsPRODEPenconsResp"></td>
                                                </tr>
                                                <tr>
                                                    <td>p2)</td>
                                                    <td>Cuerpo académico registrado ante PRODEP</td>
                                                    <td>En consolidación</td>
                                                    <td>Integrante</td>
                                                    <td id="puntajePRODEPenconsInteg"><b>15</b></td>
                                                    <td><input type="value" id="cantPRODEPenconsInteg" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalPRODEPenconsInteg"></td>
                                                    <td><input type="value" id="comPRODEPenconsInteg" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsPRODEPenconsInteg"></td>
                                                </tr>
                                                <tr>
                                                    <td>q1)</td>
                                                    <td>Cuerpo académico registrado ante PRODEP</td>
                                                    <td>Consolidado</td>
                                                    <td>Responsable</td>
                                                    <td id="puntajePRODEPconsResp"><b>35</b></td>
                                                    <td><input type="value" id="cantPRODEPconsResp" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalPRODEPconsResp"></td>
                                                    <td><input type="value" id="comPRODEPconsResp" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsPRODEPconsResp"></td>
                                                </tr>
                                                <tr>
                                                    <td>q2)</td>
                                                    <td>Cuerpo académico registrado ante PRODEP</td>
                                                    <td>Consolidado</td>
                                                    <td>Integrante</td>
                                                    <td id="puntajePRODEPconsInteg"><b>25</b></td>
                                                    <td><input type="value" id="cantPRODEPconsInteg" placeholder="0"
                                                            oninput="onActv3SubTotal3_19()">
                                                    </td>
                                                    <td></td>
                                                    <td id="subtotalPRODEPconsInteg"></td>
                                                    <td><input type="value" id="comPRODEPconsInteg" placeholder="0"
                                                            oninput="onActv3Comision3_19()">
                                                    </td>
                                                    <td><input class="table-header" type="text" id="obsPRODEPconsInteg"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--Tabla informativa Acreditacion Actividad 3.19-->
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="acreditacion" scope="col" colspan=2> **Coparticipación técnica
                                                        y/o académica y/o
                                                        financiera de institución extranjera</th>
                                                    <th class="acreditacion" style="padding-left: 100px;">Acreditacion:</th>
                                                    <th class="descripcion"><b>Institución que lo solicite, SG, CA, JD, DGAA</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table><br>
                                        <button type="submit" class="btn btn-primary">Enviar</button>


                            </main>

                            <footer></footer>
                    </div>
                </div>
            </div>

            <script>

                const A40 = 6.25;
                const B56 = 17;
                const B57 = 50;
                const variables = {};
                const variablesMultiplicadas = {};

                for (let i = 40; i <= 55; i++) {
                    variables[`B${i}`] = i - 39;
                    variablesMultiplicadas[`C${i}`] = A40 * variables[`B${i}`]; // Calculate and store in variablesMultiplicated object
                }

                const C56 = B56 * A40;
                const C57 = B57 * A40;
                console.log(variablesMultiplicadas);
                const elaboracion = document.getElementById('elaboracion').value;

                const rc1 = document.getElementById('rc1').value;
                const rc2 = document.getElementById('rc2').value;
                const rc3 = document.getElementById('rc3').value;
                const rc4 = document.getElementById('rc4').value;
                const comisionIncisoA = document.getElementById('comisionIncisoA').value;
                const comisionIncisoB = document.getElementById('comisionIncisoB').value;
                const comisionIncisoC = document.getElementById('comisionIncisoC').value;
                const comisionIncisoD = document.getElementById('comisionIncisoD').value;
                const obs3_10 =['obsGrupal', 'obsIndividual'];
                const obs3_11 = ['obsAsesoria', 'obsServicio', 'obsPracticas'];
                const obs3_12 = ['obsCientificos','obsDivulgacion', 'obsTraduccion', 'obsArbitrajeInt', 'obsArbitrajeNac', 'obsSinInt', 'obsSinNac','obsAutor', 'obsEditor', 'obsWeb'];
                const obs3_13 = ['obsInicioFinancimientoExt', 'obsInicioInvInterno', 'obsReporteFinanciamExt', 'obsReporteInvInt'];
                const obs3_14 = ['obsCongresoInt', 'obsCongresoNac', 'obsCongresoLoc'];
                const obs3_15 = ['obsPatentes', 'obsPrototipos'];
                const obs3_16 = ['obsArbInt', 'obsArbNac', 'obsPubInt', 'obsPubNac', 'obsRevInt','obsRevNac', 'obsRevista'];
                const obs3_17 = ['obsDifusionExt', 'obsDifusionInt','obsRepDifusionExt','obsRepDifusionInt'];
                const obs3_18 = ['obsComOrgInt', 'obsComOrgNac', 'obsComOrgReg',
                    'obsComApoyoInt', 'obsComApoyoNac', 'obsComApoyoReg','obsCicloComOrgInt','obsCicloComOrgNac','obsCicloComOrgReg','obsCicloComApoyoInt','obsCicloComApoyoNac','obsCicloComApoyoReg'];
                const obs3_19 = ['obsCGUtitular', 'obsCGUespecial',
                    'obsCGUpermanente', 'obsCAACtitular', 'obsCAACintegCom', 'obsComDepart', 'obsComPEDPD',
                    'obsComPartPos', 'obsRespPos', 'obsRespCarrera', 'obsRespProd', 'obsRespLab', 'obsExamProf',
                    'obsExamAcademicos', 'obsPRODEPformResp', 'obsPRODEPformInteg', 'obsPRODEPenconsResp',
                    'obsPRODEPenconsInteg', 'obsPRODEPconsResp', 'obsPRODEPconsInteg'
                ];


                let data = {

                    elaboracion: elaboracion,
                    cant1: cant1,
                    cant2: cant2,
                    cant3: cant3,
                    rc1: rc1,
                    rc2: rc2,
                    rc3: rc3,
                    rc4: rc4,
                    comisionIncisoA: comisionIncisoA,
                    comisionIncisoB: comisionIncisoB,
                    comisionIncisoC: comisionIncisoC,
                    comisionIncisoD: comisionIncisoD,
                    score3_1: score3_1,
                    score3_2: score3_2,
                    comision3_2: comision3_2,
                    score3_4: score3_4,
                    comision3_4: comision3_4,
                    score3_5: score3_5,
                    comision3_5: comision3_5,
                    score3_6: score3_6,
                    comision3_6: comision3_6,
                    score3_8: score3_8,
                    comision3_8: comision3_8,
                    score3_9: score3_9,
                    comision3_9: comision3_9,
                    score3_10: score3_10,
                    comision3_10: comision3_10,
                    score3_11: score3_11,
                    comision3_11: comision3_11,
                    score3_12: score3_12,
                    comision3_12: comision3_12,
                    score3_13: score3_13,
                    comision3_13: comision3_13,
                    score3_14: score3_14,
                    comision3_14: comision3_14,
                    score3_15: score3_15,
                    comision3_15: comision3_15,
                    score3_16: score3_16,
                    comision3_16: comision3_16,
                    score3_17: score3_17,
                    comision3_17: comision3_17,
                    score3_18: score3_18,
                    comision3_18: comision3_18,
                    score3_19: score3_19,
                    comision3_19: comision3_19,
                    docencia: docencia,
                    obs3_1_1: obs3_1_1,
                    obs3_1_2: obs3_1_2,
                    obs3_1_3: obs3_1_3,
                    obs3_1_4: obs3_1_4,
                    obs3_1_5: obs3_1_5,
                    };

                const dse = document.querySelector("#DSE");
                const puntajeAEvaluarPosgrado = document.querySelector("#horasPosgrado");

                const dse2 = document.querySelector("#DSE2");
                const puntajeAEvaluarSemestre = document.querySelector("#horasSemestre");
                const puntajePosgrado = 0, puntajeSemestre = 0, dsePosgrado = "", dseSemestre = "";
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
                    let lastScrollLeft = 0;
                    let lastScrollTop = 0;

                    window.addEventListener('scroll', () => {
                        let currentScrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
                        let currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;

                        // Solo ocultar la navegación si el desplazamiento es horizontal hacia la derecha
                        if (currentScrollLeft > lastScrollLeft) {
                            nav.style.display = 'none';
                        } else if (currentScrollLeft < lastScrollLeft) {
                            nav.style.display = 'block';
                        }

                        // Actualizar las posiciones de desplazamiento
                        lastScrollLeft = currentScrollLeft <= 0 ? 0 : currentScrollLeft;
                        lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
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
                    function submitForm(url, formId) {
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

                //score3_1 a score3_19
                for (let i = 1; i <= 19; i++) {
                    window[`score3_${i}`] = form.querySelector(`input[id="score3_${i}"]`).value;
                }

                //comision3_1 a comision3_19
                for (let i = 3; i <= 19; i++) {
                    window[`comision3_${i}`] = form.querySelector(`input[id="comision3_${i}"]`).value;
                }

                //observaciones3_1_1 a observaciones3_1_5
                for (let i = 1; i <= 5; i++) {
                    window[`obs3_1_${i}`] = form.querySelector(`input[id="obs3_1_${i}"]`).value;
                }

                //observaciones3_2_1 a observaciones3_2_3
                for (let i = 1; i <= 3; i++) {
                    window[`obs3_2_${i}`] = form.querySelector(`input[id="obs3_2_${i}"]`).value;
                }

                //observaciones3_3_1 a observaciones3_3_4
                for (let i = 1; i <= 4; i++) {
                    window[`obs3_3_${i}`] = form.querySelector(`input[id="obs3_3_${i}"]`).value;
                }

                //observaciones3_4_1 a observaciones3_4_4
                for (let i = 1; i <= 4; i++) {
                    window[`obs3_4_${i}`] = form.querySelector(`input[id="obs3_4_${i}"]`).value;
                }


                        switch (formId) {

                            case 'form3_1':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_1'] = form.querySelector('input[id="score3_1"]').value;
                                formData['actv3Comision'] = form.querySelector('input[id="actv3Comision"]').value;

                                for (let i = 1; i <= 5; i++) {
                                    formData[`obs3_1_${i}`] = form.querySelector(`input[id="obs3_1_${i}"]`).value;
                                }
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_2':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_2'] = form.querySelector('input[id="score3_2"]').value;
                                formData['comision3_2'] = form.querySelector('input[id="comision3_2"]').value;

                                for (let i = 1; i <= 3; i++) {
                                    formData[`obs3_2_${i}`] = form.querySelector(`input[id="obs3_2_${i}"]`).value;
                                }
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_3':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_3'] = form.querySelector('input[id="score3_3"]').value;
                                formData['comision3_3'] = form.querySelector('input[id="comision3_3"]').value;

                                for (let i = 1; i <= 4; i++) {
                                    formData[`obs3_3_${i}`] = form.querySelector(`input[id="obs3_3_${i}"]`).value;
                                }
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_4':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_4'] = form.querySelector('input[id="score3_4"]').value;                                
                                formData['comision3_4'] = form.querySelector('input[id="comision3_4"]').value;
                                for (let i = 1; i <= 4; i++) {
                                    formData[`obs3_4_${i}`] = form.querySelector(`input[id="obs3_4_${i}"]`).value;
                                }
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_5':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_5'] = form.querySelector('input[id="score3_5"]').value;                                
                                formData['comision3_5'] = form.querySelector('input[id="comision3_5"]').value; 
                                formData['obs3_5_1'] = form.querySelector('input[id="obs3_5_1"]').value;   
                                formData['obs3_5_2'] = form.querySelector('input[id="obs3_5_2"]').value;
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;                             
                                break;

                            case 'form3_6':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_6'] = form.querySelector('input[id="score3_6"]').value;                                
                                formData['comision3_6'] = form.querySelector('input[id="comision3_6"]').value;
                                formData['obs3_6'] = form.querySelector('input[id="obs3_6"]').value;
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_7':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_7'] = form.querySelector('input[id="score3_7"]').value;                                
                                formData['comision3_7'] = form.querySelector('input[id="comision3_7"]').value;
                                formData['obs3_7'] = form.querySelector('input[id="obs3_7"]').value; 
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_8':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_8'] = form.querySelector('input[id="score3_8"]').value;                                
                                formData['comision3_8'] = form.querySelector('input[id="comision3_8"]').value;
                                formData['obs3_8'] = form.querySelector('input[id="obs3_8"]').value;
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_9':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_9'] = form.querySelector('input[id="score3_9"]').value;                                
                                formData['comision3_9'] = form.querySelector('input[id="comision3_9"]').value;

                                for (let i = 1; i <= 17; i++) {
                                    formData[`obs3_9_${i}`] = form.querySelector(`input[id="obs3_9_${i}"]`).value;
                                } 
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;                               
                                break;

                            case 'form3_10':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_10'] = form.querySelector('input[id="score3_10"]').value;                                
                                formData['comision3_10'] = form.querySelector('input[id="comision3_10"]').value;
                                obs3_10.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_11':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_11'] = form.querySelector('input[id="score3_11"]').value;
                                formData['comision3_11'] = form.querySelector('input[id="comision3_11"]').value; 
                                obs3_11.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value; 
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_12':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_12'] = form.querySelector('input[id="score3_12"]').value;
                                formData['comision3_12'] = form.querySelector('input[id="comision3_12"]').value; 
                                obs3_12.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_13':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_13'] = form.querySelector('input[id="score3_13"]').value;
                                formData['comision3_13'] = form.querySelector('input[id="comision3_13"]').value;
                                obs3_13.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_14':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_14'] = form.querySelector('input[id="score3_14"]').value;
                                formData['comision3_14'] = form.querySelector('input[id="comision3_14"]').value;
                                obs3_14.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_15':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_15'] = form.querySelector('input[id="score3_15"]').value;
                                formData['comision3_15'] = form.querySelector('input[id="comision3_15"]').value;
                                obs3_15.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_16':                                
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_16'] = form.querySelector('input[id="score3_16"]').value;
                                formData['comision3_16'] = form.querySelector('input[id="comision3_16"]').value;
                                obs3_16.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_17':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_17'] = form.querySelector('input[id="score3_17"]').value;
                                formData['comision3_17'] = form.querySelector('input[id="comision3_17"]').value;
                                obs3_17.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_18':
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_18'] = form.querySelector('input[id="score3_18"]').value;
                                formData['comision3_18'] = form.querySelector('input[id="comision3_18"]').value;
                                obs3_18.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;

                            case 'form3_19':                                
                                formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                                formData['email'] = form.querySelector('input[name="email"]').value;
                                formData['score3_19'] = form.querySelector('input[id="score3_19"]').value;
                                formData['comision3_19'] = form.querySelector('input[id="comision3_19"]').value;
                                obs3_19.forEach(field => {
                                    formData[field] = form.querySelector(`input[id="${field}"]`).value;
                                });
                                formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                                break;                               

                        }
                        formData['docencia'] = form.querySelector('input[id="docencia"]').value;
                        console.log(docencia);
                        console.log('Form data:', formData); // Log form data to check values
                        //if (!formData.hasOwnProperty('score3_1')) {
                        // Si score3_1 no está en formData, proporciona un valor predeterminado
                        //formData['score3_1'] = ''; // Aquí puedes proporcionar cualquier valor predeterminado que desees
                        //}


                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(formData),
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Response received from server:', data);
                            })
                            .catch(error => {
                                console.error('There was a problem with the fetch operation:', error);
                            });
                    }

                    window.submitForm = submitForm;
                });


            </script>
        </body>
@endif

</html>