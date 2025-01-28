@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Participación en cuerpos colegiados</title>
    <meta charset="utf-9">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-head-resources />
</head>
<style>
    body.chrome @media print {
    #convocatoria {
        font-size: 1.2rem;
        color: blue; /* Ejemplo de estilo específico para Chrome */
    }
}

#convocatoria, #piedepagina {
    display:none;
}
    @media print {
    body {
        margin-left: 200px ;
        margin-top: -10px;
        padding: 0;
        font-size: .9rem;
       
    }

    footer {
        position: fixed;
        font-size: .9rem;
        bottom: 0;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 12px;
        background-color: white; /* Para asegurar que el footer no interfiera visualmente */
        z-index: 10;
        padding: 5px 0;
        border-top: 1px solid #ccc;
    }

    footer::after {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            background: white;
            padding: 5px;
            z-index: 10;
        }


    .prevent-overlap {
        page-break-before: always;
    }

    #convocatoria {
        margin: 0;
        display:block;
    }

    #piedepagina {
        margin: 0;
        display:block;
    }

    @page {
        size: landscape;
        margin: 20mm; /* Ajusta según sea necesario */
        
    }

    @page:right {
        content: "Página " counter(page);
    }

            /* Footer de la primera página */
        .page:first-of-type #piedepagina {
            content: "Página 26 de 28";
        }

        /* Footer de páginas pares */
        .page:nth-of-type(even) #piedepagina {
            content: "Página 27 de 28";
        }

        /* Footer de páginas impares */
        .page:nth-of-type(odd) #piedepagina {
            content: "Página 28 de 28";
        }

        page-break-after: auto; /* La última página no necesita salto extra */
        
   
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
                                    <a class="nav-link active enlaceSN" style="width: 200px;" href="{{ route('secretaria') }}">Selección de
                                        Formatos</a>
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
$page_counter = 32;
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

    <main class="container">
        <!-- Form for Part 3_19 -->
        <form id="form3_19" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form319', 'form3_19');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
        <!--3.19 Participación en cuerpos colegiados-->
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
                            <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora
                            </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th id="seccion3_19" class="acreditacion" colspan=5> 3.19 Participación en
                                cuerpos colegiados
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
                            <td id="cantCGUtitular"></td>
                            <td></td>
                            <td id="subtotalCGUtitular"></td>
                            <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comCGUtitular" name="comCGUtitular" value="{{ oldValueOrDefault('comCGUtitular') }}" oninput="onActv3Comision3_19()">
                            @else
                                   <span id="comCGUtitular" name="comCGUtitular"></span> 
                            @endif
                            </td>
                            <td>
                             @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsCGUtitular" name="obsCGUtitular">
                            @else
                                <span id="obsCGUtitular" name="obsCGUtitular"></span>
                            @endif                            
                            </td>
                        </tr>
                        <tr>
                            <td>b)</td>
                            <td>Representante del profesorado ante H. CGU</td>
                            <td></td>
                            <td>Participación como miembro de comisión especial</td>
                            <td id="puntajeCGUespecial"><b>15</b></td>
                            <td id="cantCGUespecial"></td>
                            <td></td>
                            <td id="subtotalCGUespecial"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comCGUespecial" name="comCGUespecial" value="{{ oldValueOrDefault('comCGUespecial') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comCGUespecial" name="comCGUespecial"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsCGUespecial" name="obsCGUespecial">
                                @else
                                    <span id="obsCGUespecial" name="obsCGUespecial"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>c)</td>
                            <td>Representante del profesorado ante H. CGU</td>
                            <td></td>
                            <td>Participación como miembro en comisión permanente</td>
                            <td id="puntajeCGUpermanente"><b>10</b></td>
                            <td id="cantCGUpermanente"></td>
                            <td></td>
                            <td id="subtotalCGUpermanente"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comCGUpermanente" name="comCGUpermanente" value="{{ oldValueOrDefault('comCGUpermanente') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comCGUpermanente" name="comCGUpermanente"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsCGUpermanente" name="obsCGUpermanente">
                                @else
                                    <span id="obsCGUpermanente" name="obsCGUpermanente"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>d)</td>
                            <td>Representante del profesorado ante CAAC</td>
                            <td></td>
                            <td>Titular o suplente</td>
                            <td id="puntajeCAACtitular"><b>10</b></td>
                            <td id="cantCAACtitular"></td>
                            <td></td>
                            <td id="subtotalCAACtitular"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comCAACtitular" name="comCAACtitular" value="{{ oldValueOrDefault('comCAACtitular') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comCAACtitular" name="comCAACtitular"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsCAACtitular" name="obsCAACtitular">
                                @else
                                    <span id="obsCAACtitular" name="obsCAACtitular"></span>
                                @endif
                            </td>
                            <td>
                                    <center>
        <footer>
            <div id="convocatoria">
                <!-- Mostrar convocatoria -->
                @if(isset($convocatoria))
                    <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
                @endif
            </div>
            <div id="piedepagina"style="margin-left: 600px; margin-top: 10px;" >&nbsp Página 26<span id="page-number"> de 28</span></div>
        </footer>
        
    </center>
                            </td>
                        </tr>
                        @php
$page_counter++;
                        @endphp
                        @if($page_counter === 33)
                        <tr class="prevent-overlap">
                            <td>e)</td>
                            <td>Representante del profesorado ante CAAC</td>
                            <td></td>
                            <td>Participación como integrante de comisión</td>
                            <td id="puntajeCAACintegCom"><b>5</b></td>
                            <td id="cantCAACintegCom"></td>
                            <td></td>
                            <td id="subtotalCAACintegCom"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comCAACintegCom" name="comCAACintegCom" value="{{ oldValueOrDefault('comCAACintegCom') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comCAACintegCom" name="comCAACintegCom"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsCAACintegCom" name="obsCAACintegCom">
                                @else
                                    <span id="obsCAACintegCom" name="obsCAACintegCom"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>f)</td>
                            <td>Comisiones</td>
                            <td></td>
                            <td>Departamentales</td>
                            <td id="puntajeComDepart"><b>15</b></td>
                            <td id="cantComDepart"></td>
                            <td></td>
                            <td id="subtotalComDepart"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comComDepart" name="comComDepart" value="{{ oldValueOrDefault('comComDepart') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comComDepart" name="comComDepart"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsComDepart" name="obsComDepart">
                                @else
                                    <span id="obsComDepart" name="obsComDepart"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>g)</td>
                            <td>Comisiones</td>
                            <td></td>
                            <td>Dictaminadora del PEDPD</td>
                            <td id="puntajeComPEDPD"><b>15</b></td>
                            <td id="cantComPEDPD"></td>
                            <td></td>
                            <td id="subtotalComPEDPD"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comComPEDPD" name="comComPEDPD" value="{{ oldValueOrDefault('comComPEDPD') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comComPEDPD" name="comComPEDPD"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsComPEDPD" name="obsComPEDPD">
                                @else
                                    <span id="obsComPEDPD" name="obsComPEDPD"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>h)</td>
                            <td>Comisiones</td>
                            <td></td>
                            <td>Participación como integrante del Comité Académico de Posgrado</td>
                            <td id="puntajeComPartPos"><b>5</b></td>
                            <td id="cantComPartPos"></td>
                            <td></td>
                            <td id="subtotalComPartPos"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comComPartPos" name="comComPartPos" value="{{ oldValueOrDefault('comComPartPos') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comComPartPos" name="comComPartPos"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsComPartPos" name="obsComPartPos">
                                @else
                                    <span id="obsComPartPos" name="obsComPartPos"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>i)</td>
                            <td>Responsable</td>
                            <td></td>
                            <td>De posgrado</td>
                            <td id="puntajeRespPos"><b>25</b></td>
                            <td id="cantRespPos"></td>
                            <td></td>
                            <td id="subtotalRespPos"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comRespPos" name="comRespPos" value="{{ oldValueOrDefault('comRespPos') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comRespPos" name="comRespPos"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsRespPos" name="obsRespPos">
                                @else
                                    <span id="obsRespPos" name="obsRespPos"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>j)</td>
                            <td>Responsable</td>
                            <td></td>
                            <td>De carrera</td>
                            <td id="puntajeRespCarrera"><b>15</b></td>
                            <td id="cantRespCarrera"></td>
                            <td></td>
                            <td id="subtotalRespCarrera"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comRespCarrera" name="comRespCarrera" value="{{ oldValueOrDefault('comRespCarrera') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comRespCarrera" name="comRespCarrera"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsRespCarrera" name="obsRespCarrera">
                                @else
                                    <span id="obsRespCarrera" name="obsRespCarrera"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>k)</td>
                            <td>Responsable</td>
                            <td></td>
                            <td>De unidad de producción</td>
                            <td id="puntajeRespProd"><b>20</b></td>
                            <td id="cantRespProd"></td>
                            <td></td>
                            <td id="subtotalRespProd"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comRespProd" name="comRespProd" value="{{ oldValueOrDefault('comRespProd') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comRespProd" name="comRespProd"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsRespProd" name="obsRespProd">
                                @else
                                    <span id="obsRespProd" name="obsRespProd"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>l)</td>
                            <td>Responsable</td>
                            <td></td>
                            <td>De laboratorio de docencia e investigación</td>
                            <td id="puntajeRespLab"><b>15</b></td>
                            <td id="cantRespLab"></td>
                            <td></td>
                            <td id="subtotalRespLab"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comRespLab" name="comRespLab" value="{{ oldValueOrDefault('comRespLab') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comRespLab" name="comRespLab"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsRespLab" name="obsRespLab">
                                @else
                                    <span id="obsRespLab" name="obsRespLab"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>m)</td>
                            <td>Sinodalías de examen de oposición</td>
                            <td></td>
                            <td>Profesorado</td>
                            <td id="puntajeExamProf"><b>15</b></td>
                            <td id="cantExamProf"></td>
                            <td></td>
                            <td id="subtotalExamProf"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comExamProf" name="comExamProf" value="{{ oldValueOrDefault('comExamProf') }}" oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comExamProf" name="comExamProf"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsExamProf" name="obsExamProf">
                                @else
                                    <span id="obsExamProf" name="obsExamProf"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>n)</td>
                            <td>Sinodalías de examen de oposición</td>
                            <td></td>
                            <td>Ayudantes académicos</td>
                            <td id="puntajeExamAcademicos"><b>5</b></td>
                            <td id="cantExamAcademicos"></td>
                            <td></td>
                            <td id="subtotalExamAcademicos"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comExamAcademicos" name="comExamAcademicos" value="{{ oldValueOrDefault('comExamAcademicos') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comExamAcademicos" name="comExamAcademicos"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsExamAcademicos" name="obsExamAcademicos">
                                @else
                                    <span id="obsExamAcademicos" name="obsExamAcademicos"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>o1)</td>
                            <td>Cuerpo académico registrado ante PRODEP</td>
                            <td>En formación</td>
                            <td>Responsable</td>
                            <td id="puntajePRODEPformResp"><b>15</b></td>
                            <td id="cantPRODEPformResp"></td>
                            <td></td>
                            <td id="subtotalPRODEPformResp"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comPRODEPformResp" name="comPRODEPformResp" value="{{ oldValueOrDefault('comPRODEPformResp') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comPRODEPformResp" name="comPRODEPformResp"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsPRODEPformResp" name="obsPRODEPformResp">
                                @else
                                    <span id="obsPRODEPformResp" name="obsPRODEPformResp"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>o2)</td>
                            <td>Cuerpo académico registrado ante PRODEP</td>
                            <td>En formación</td>
                            <td>Integrante</td>
                            <td id="puntajePRODEPformInteg"><b>10</b></td>
                            <td id="cantPRODEPformInteg"></td>
                            <td></td>
                            <td id="subtotalPRODEPformInteg"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comPRODEPformInteg" name="comPRODEPformInteg" value="{{ oldValueOrDefault('comPRODEPformInteg') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comPRODEPformInteg" name="comPRODEPformInteg"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsPRODEPformInteg" name="obsPRODEPformInteg">
                                @else
                                    <span id="obsPRODEPformInteg" name="obsPRODEPformInteg"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>p1)</td>
                            <td>Cuerpo académico registrado ante PRODEP</td>
                            <td>En consolidación</td>
                            <td>Responsable</td>
                            <td id="puntajePRODEPenconsResp"><b>25</b></td>
                            <td id="cantPRODEPenconsResp"></td>
                            <td></td>
                            <td id="subtotalPRODEPenconsResp"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comPRODEPenconsResp" name="comPRODEPenconsResp" value="{{ oldValueOrDefault('comPRODEPenconsResp') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comPRODEPenconsResp" name="comPRODEPenconsResp"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsPRODEPenconsResp" name="obsPRODEPenconsResp">
                                @else
                                    <span id="obsPRODEPenconsResp" name="obsPRODEPenconsResp"></span>
                                @endif
                            </td>
                        </tr>
                        @endif
                        <tr class="prevent-overlap">
                            <td>p2)</td>
                            <td>Cuerpo académico registrado ante PRODEP</td>
                            <td>En consolidación</td>
                            <td>Integrante</td>
                            <td id="puntajePRODEPenconsInteg"><b>15</b></td>
                            <td id="cantPRODEPenconsInteg"></td>
                            <td></td>
                            <td id="subtotalPRODEPenconsInteg"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comPRODEPenconsInteg" name="comPRODEPenconsInteg" value="{{ oldValueOrDefault('comPRODEPenconsInteg') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comPRODEPenconsInteg" name="comPRODEPenconsInteg"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsPRODEPenconsInteg" name="obsPRODEPenconsInteg">
                                @else
                                    <span id="obsPRODEPenconsInteg" name="obsPRODEPenconsInteg"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>q1)</td>
                            <td>Cuerpo académico registrado ante PRODEP</td>
                            <td>Consolidado</td>
                            <td>Responsable</td>
                            <td id="puntajePRODEPconsResp"><b>35</b></td>
                            <td id="cantPRODEPconsResp"></td>
                            <td></td>
                            <td id="subtotalPRODEPconsResp"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comPRODEPconsResp" name="comPRODEPconsResp" value="{{ oldValueOrDefault('comPRODEPconsResp') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comPRODEPconsResp" name="comPRODEPconsResp"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsPRODEPconsResp" name="obsPRODEPconsResp">
                                @else
                                    <span id="obsPRODEPconsResp" name="obsPRODEPconsResp"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>q2)</td>
                            <td>Cuerpo académico registrado ante PRODEP</td>
                            <td>Consolidado</td>
                            <td>Integrante</td>
                            <td id="puntajePRODEPconsInteg"><b>25</b></td>
                            <td id="cantPRODEPconsInteg"></td>
                            <td></td>
                            <td id="subtotalPRODEPconsInteg"></td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input type="number" step="0.01" id="comPRODEPconsInteg" name="comPRODEPconsInteg" value="{{ oldValueOrDefault('comPRODEPconsInteg') }}"
                                        oninput="onActv3Comision3_19()">
                                @else
                                    <span id="comPRODEPconsInteg" name="comPRODEPconsInteg"></span>
                                @endif
                            </td>
                            <td>
                                @if ($userType == 'dictaminador')
                                    <input class="table-header" type="text" id="obsPRODEPconsInteg" name="obsPRODEPconsInteg">
                                @else
                                    <span id="obsPRODEPconsInteg" name="obsPRODEPconsInteg"></span>
                                @endif
                            </td>
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
                            <th class="descripcion"><b>Institución que lo solicite, SG, CA, JD, DGAA</b></th>
                            <th>
                            @if ($userType != '')
                                <button id="btn3_19" type="submit" class="btn custom-btn printButtonClass">Enviar</button>
                            @endif
                            </th>
                        </tr>
                    </thead>
                </table>
                </form>
    </main>
    <center>
        <footer>
            <div id="convocatoria">
                <!-- Mostrar convocatoria -->
                @if(isset($convocatoria))
                    <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
                @endif
            </div>
            <div id="piedepagina"style="margin-left: 600px; margin-top: 10px;" >&nbsp Página 26<span id="page-number"> de 31</span></div>
        </footer>
        
    </center>


    <script>


    window.onload = function () {
        const footerHeight = document.querySelector('footer').offsetHeight;
        const elements = document.querySelectorAll('.prevent-overlap');

        elements.forEach(element => {
            const rect = element.getBoundingClientRect();
            const viewportHeight = window.innerHeight;

            // Verifica si el elemento está demasiado cerca del footer
            if (rect.bottom > viewportHeight - footerHeight) {
                element.style.pageBreakBefore = "always";
            }
        });
        
    };

    let cant3_19 = [
        'cantCGUtitular', 'cantCGUespecial', 'cantCGUpermanente',
        'cantCAACtitular', 'cantCAACintegCom', 'cantComDepart',
        'cantComPEDPD', 'cantComPartPos', 'cantRespPos',
        'cantRespCarrera', 'cantRespProd', 'cantRespLab',
        'cantExamProf', 'cantExamAcademicos', 'cantPRODEPformResp',
        'cantPRODEPformInteg', 'cantPRODEPenconsResp', 'cantPRODEPenconsInteg',
        'cantPRODEPconsResp', 'cantPRODEPconsInteg'
    ];

    let subtotal3_19 = [
        'subtotalCGUtitular', 'subtotalCGUespecial', 'subtotalCGUpermanente',
        'subtotalCAACtitular', 'subtotalCAACintegCom', 'subtotalComDepart',
        'subtotalComPEDPD', 'subtotalComPartPos', 'subtotalRespPos',
        'subtotalRespCarrera', 'subtotalRespProd', 'subtotalRespLab',
        'subtotalExamProf', 'subtotalExamAcademicos', 'subtotalPRODEPformResp',
        'subtotalPRODEPformInteg', 'subtotalPRODEPenconsResp', 'subtotalPRODEPenconsInteg',
        'subtotalPRODEPconsResp', 'subtotalPRODEPconsInteg'
    ];

    let comision3_19 = [
        'comCGUtitular', 'comCGUespecial', 'comCGUpermanente',
        'comCAACtitular', 'comCAACintegCom', 'comComDepart',
        'comComPEDPD', 'comComPartPos', 'comRespPos',
        'comRespCarrera', 'comRespProd', 'comRespLab',
        'comExamProf', 'comExamAcademicos', 'comPRODEPformResp',
        'comPRODEPformInteg', 'comPRODEPenconsResp', 'comPRODEPenconsInteg',
        'comPRODEPconsResp', 'comPRODEPconsInteg'
    ];

    let obs3_19 = [
        'obsCGUtitular', 'obsCGUespecial', 'obsCGUpermanente',
        'obsCAACtitular', 'obsCAACintegCom', 'obsComDepart',
        'obsComPEDPD', 'obsComPartPos', 'obsRespPos',
        'obsRespCarrera', 'obsRespProd', 'obsRespLab',
        'obsExamProf', 'obsExamAcademicos', 'obsPRODEPformResp',
        'obsPRODEPformInteg', 'obsPRODEPenconsResp', 'obsPRODEPenconsInteg',
        'obsPRODEPconsResp', 'obsPRODEPconsInteg'
    ];


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

                                    // Populate fields with fetched data
                                    document.getElementById('score3_19').textContent = data.form3_19.score3_19 || '0';

                                    // Cantidades
                                    document.getElementById('cantCGUtitular').textContent = data.form3_19.cantCGUtitular || '0';
                                    document.getElementById('cantCGUespecial').textContent = data.form3_19.cantCGUespecial || '0';
                                    document.getElementById('cantCGUpermanente').textContent = data.form3_19.cantCGUpermanente || '0';
                                    document.getElementById('cantCAACtitular').textContent = data.form3_19.cantCAACtitular || '0';
                                    document.getElementById('cantCAACintegCom').textContent = data.form3_19.cantCAACintegCom || '0';
                                    document.getElementById('cantComDepart').textContent = data.form3_19.cantComDepart || '0';
                                    document.getElementById('cantComPEDPD').textContent = data.form3_19.cantComPEDPD || '0';
                                    document.getElementById('cantComPartPos').textContent = data.form3_19.cantComPartPos || '0';
                                    document.getElementById('cantRespPos').textContent = data.form3_19.cantRespPos || '0';
                                    document.getElementById('cantRespCarrera').textContent = data.form3_19.cantRespCarrera || '0';
                                    document.getElementById('cantRespProd').textContent = data.form3_19.cantRespProd || '0';
                                    document.getElementById('cantRespLab').textContent = data.form3_19.cantRespLab || '0';
                                    document.getElementById('cantExamProf').textContent = data.form3_19.cantExamProf || '0';
                                    document.getElementById('cantExamAcademicos').textContent = data.form3_19.cantExamAcademicos || '0';
                                    document.getElementById('cantPRODEPformResp').textContent = data.form3_19.cantPRODEPformResp || '0';
                                    document.getElementById('cantPRODEPformInteg').textContent = data.form3_19.cantPRODEPformInteg || '0';
                                    document.getElementById('cantPRODEPenconsResp').textContent = data.form3_19.cantPRODEPenconsResp || '0';
                                    document.getElementById('cantPRODEPenconsInteg').textContent = data.form3_19.cantPRODEPenconsInteg || '0';
                                    document.getElementById('cantPRODEPconsResp').textContent = data.form3_19.cantPRODEPconsResp || '0';
                                    document.getElementById('cantPRODEPconsInteg').textContent = data.form3_19.cantPRODEPconsInteg || '0';



                                    // Subtotales
                                    document.getElementById('subtotalCGUtitular').textContent = data.form3_19.subtotalCGUtitular || '0';
                                    document.getElementById('subtotalCGUespecial').textContent = data.form3_19.subtotalCGUespecial || '0';
                                    document.getElementById('subtotalCGUpermanente').textContent = data.form3_19.subtotalCGUpermanente || '0';
                                    document.getElementById('subtotalCAACtitular').textContent = data.form3_19.subtotalCAACtitular || '0';
                                    document.getElementById('subtotalCAACintegCom').textContent = data.form3_19.subtotalCAACintegCom || '0';
                                    document.getElementById('subtotalComDepart').textContent = data.form3_19.subtotalComDepart || '0';
                                    document.getElementById('subtotalComPEDPD').textContent = data.form3_19.subtotalComPEDPD || '0';
                                    document.getElementById('subtotalComPartPos').textContent = data.form3_19.subtotalComPartPos || '0';
                                    document.getElementById('subtotalRespPos').textContent = data.form3_19.subtotalRespPos || '0';
                                    document.getElementById('subtotalRespCarrera').textContent = data.form3_19.subtotalRespCarrera || '0';
                                    document.getElementById('subtotalRespProd').textContent = data.form3_19.subtotalRespProd || '0';
                                    document.getElementById('subtotalRespLab').textContent = data.form3_19.subtotalRespLab || '0';
                                    document.getElementById('subtotalExamProf').textContent = data.form3_19.subtotalExamProf || '0';
                                    document.getElementById('subtotalExamAcademicos').textContent = data.form3_19.subtotalExamAcademicos || '0';
                                    document.getElementById('subtotalPRODEPformResp').textContent = data.form3_19.subtotalPRODEPformResp || '0';
                                    document.getElementById('subtotalPRODEPformInteg').textContent = data.form3_19.subtotalPRODEPformInteg || '0';
                                    document.getElementById('subtotalPRODEPenconsResp').textContent = data.form3_19.subtotalPRODEPenconsResp || '0';
                                    document.getElementById('subtotalPRODEPenconsInteg').textContent = data.form3_19.subtotalPRODEPenconsInteg || '0';
                                    document.getElementById('subtotalPRODEPconsResp').textContent = data.form3_19.subtotalPRODEPconsResp || '0';
                                    document.getElementById('subtotalPRODEPconsInteg').textContent = data.form3_19.subtotalPRODEPconsInteg || '0';


                                    // Populate hidden inputs
                                    document.querySelector('input[name="user_id"]').value = data.form3_19.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.form3_19.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.form3_19.user_type || '';

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

                                        // Mostrar la convocatoria si existe
                                        if (convocatoriaElement) {
                                            if (data.docente.convocatoria) {
                                                convocatoriaElement.textContent = data.docente.convocatoria;
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
                                const selectedResponseForm3_19 = dictaminatorResponses.form3_19.find(res => res.email === email);
                                if (selectedResponseForm3_19) {
                                    document.querySelector('input[name="dictaminador_id"]').value = selectedResponseForm3_19.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = selectedResponseForm3_19.user_id || '';
                                    document.querySelector('input[name="email"]').value = selectedResponseForm3_19.email || '';
                                    document.querySelector('input[name="user_type"]').value = selectedResponseForm3_19.user_type || '';
                                    document.getElementById('score3_19').textContent = selectedResponseForm3_19.score3_19 || '0';
                                    document.getElementById('comision3_19').textContent = selectedResponseForm3_19.comision3_19 || '0';

                                    // Cantidades
                                    document.getElementById('cantCGUtitular').textContent = selectedResponseForm3_19.cantCGUtitular || '0';
                                    document.getElementById('cantCGUespecial').textContent = selectedResponseForm3_19.cantCGUespecial || '0';
                                    document.getElementById('cantRespLab').textContent = selectedResponseForm3_19.cantRespLab || '0';
                                    document.getElementById('cantCGUpermanente').textContent = selectedResponseForm3_19.cantCGUpermanente || '0';
                                    document.getElementById('cantCAACtitular').textContent = selectedResponseForm3_19.cantCAACtitular || '0';
                                    document.getElementById('cantCAACintegCom').textContent = selectedResponseForm3_19.cantCAACintegCom || '0';
                                    document.getElementById('cantComDepart').textContent = selectedResponseForm3_19.cantComDepart || '0';
                                    document.getElementById('cantComPEDPD').textContent = selectedResponseForm3_19.cantComPEDPD || '0';
                                    document.getElementById('cantComPartPos').textContent = selectedResponseForm3_19.cantComPartPos || '0';
                                    document.getElementById('cantRespPos').textContent = selectedResponseForm3_19.cantRespPos || '0';
                                    document.getElementById('cantRespCarrera').textContent = selectedResponseForm3_19.cantRespCarrera || '0';
                                    document.getElementById('cantRespProd').textContent = selectedResponseForm3_19.cantRespProd || '0';
                                    document.getElementById('cantExamProf').textContent = selectedResponseForm3_19.cantExamProf || '0';
                                    document.getElementById('cantExamAcademicos').textContent = selectedResponseForm3_19.cantExamAcademicos || '0';
                                    document.getElementById('cantPRODEPformResp').textContent = selectedResponseForm3_19.cantPRODEPformResp || '0';
                                    document.getElementById('cantPRODEPformInteg').textContent = selectedResponseForm3_19.cantPRODEPformInteg || '0';
                                    document.getElementById('cantPRODEPenconsResp').textContent = selectedResponseForm3_19.cantPRODEPenconsResp || '0';
                                    document.getElementById('cantPRODEPenconsInteg').textContent = selectedResponseForm3_19.cantPRODEPenconsInteg || '0';
                                    document.getElementById('cantPRODEPconsResp').textContent = selectedResponseForm3_19.cantPRODEPconsResp || '0';
                                    document.getElementById('cantPRODEPconsInteg').textContent = selectedResponseForm3_19.cantPRODEPconsInteg || '0';


                                    // Subtotales
                                    document.getElementById('subtotalCGUtitular').textContent = selectedResponseForm3_19.subtotalCGUtitular || '0';
                                    document.getElementById('subtotalCGUespecial').textContent = selectedResponseForm3_19.subtotalCGUespecial || '0';
                                    document.getElementById('subtotalCGUpermanente').textContent = selectedResponseForm3_19.subtotalCGUpermanente || '0';
                                    document.getElementById('subtotalCAACtitular').textContent = selectedResponseForm3_19.subtotalCAACtitular || '0';
                                    document.getElementById('subtotalCAACintegCom').textContent = selectedResponseForm3_19.subtotalCAACintegCom || '0';
                                    document.getElementById('subtotalComDepart').textContent = selectedResponseForm3_19.subtotalComDepart || '0';
                                    document.getElementById('subtotalComPEDPD').textContent = selectedResponseForm3_19.subtotalComPEDPD || '0';
                                    document.getElementById('subtotalComPartPos').textContent = selectedResponseForm3_19.subtotalComPartPos || '0';
                                    document.getElementById('subtotalRespPos').textContent = selectedResponseForm3_19.subtotalRespPos || '0';
                                    document.getElementById('subtotalRespCarrera').textContent = selectedResponseForm3_19.subtotalRespCarrera || '0';
                                    document.getElementById('subtotalRespProd').textContent = selectedResponseForm3_19.subtotalRespProd || '0';
                                    document.getElementById('subtotalRespLab').textContent = selectedResponseForm3_19.subtotalRespLab || '0';
                                    document.getElementById('subtotalExamProf').textContent = selectedResponseForm3_19.subtotalExamProf || '0';
                                    document.getElementById('subtotalExamAcademicos').textContent = selectedResponseForm3_19.subtotalExamAcademicos || '0';
                                    document.getElementById('subtotalPRODEPformResp').textContent = selectedResponseForm3_19.subtotalPRODEPformResp || '0';
                                    document.getElementById('subtotalPRODEPformInteg').textContent = selectedResponseForm3_19.subtotalPRODEPformInteg || '0';
                                    document.getElementById('subtotalPRODEPenconsResp').textContent = selectedResponseForm3_19.subtotalPRODEPenconsResp || '0';
                                    document.getElementById('subtotalPRODEPenconsInteg').textContent = selectedResponseForm3_19.subtotalPRODEPenconsInteg || '0';
                                    document.getElementById('subtotalPRODEPconsResp').textContent = selectedResponseForm3_19.subtotalPRODEPconsResp || '0';
                                    document.getElementById('subtotalPRODEPconsInteg').textContent = selectedResponseForm3_19.subtotalPRODEPconsInteg || '0';

                                    // Comisiones
                                    document.querySelector('#comCGUtitular').textContent = selectedResponseForm3_19.comCGUtitular || '0';
                                    document.querySelector('#comCGUespecial').textContent = selectedResponseForm3_19.comCGUespecial || '0';
                                    document.querySelector('#comCGUpermanente').textContent = selectedResponseForm3_19.comCGUpermanente || '0';
                                    document.querySelector('#comCAACtitular').textContent = selectedResponseForm3_19.comCAACtitular || '0';
                                    document.querySelector('#comCAACintegCom').textContent = selectedResponseForm3_19.comCAACintegCom || '0';
                                    document.querySelector('#comComDepart').textContent = selectedResponseForm3_19.comComDepart || '0';
                                    document.querySelector('#comComPEDPD').textContent = selectedResponseForm3_19.comComPEDPD || '0';
                                    document.querySelector('#comComPartPos').textContent = selectedResponseForm3_19.comComPartPos || '0';
                                    document.querySelector('#comRespPos').textContent = selectedResponseForm3_19.comRespPos || '0';
                                    document.querySelector('#comRespCarrera').textContent = selectedResponseForm3_19.comRespCarrera || '0';
                                    document.querySelector('#comRespProd').textContent = selectedResponseForm3_19.comRespProd || '0';
                                    document.querySelector('#comRespLab').textContent = selectedResponseForm3_19.comRespLab || '0';
                                    document.querySelector('#comExamProf').textContent = selectedResponseForm3_19.comExamProf || '0';
                                    document.querySelector('#comExamAcademicos').textContent = selectedResponseForm3_19.comExamAcademicos || '0';
                                    document.querySelector('#comPRODEPformResp').textContent = selectedResponseForm3_19.comPRODEPformResp || '0';
                                    document.querySelector('#comPRODEPformInteg').textContent = selectedResponseForm3_19.comPRODEPformInteg || '0';
                                    document.querySelector('#comPRODEPenconsResp').textContent = selectedResponseForm3_19.comPRODEPenconsResp || '0';
                                    document.querySelector('#comPRODEPenconsInteg').textContent = selectedResponseForm3_19.comPRODEPenconsInteg || '0';
                                    document.querySelector('#comPRODEPconsResp').textContent = selectedResponseForm3_19.comPRODEPconsResp || '0';
                                    document.querySelector('#comPRODEPconsInteg').textContent = selectedResponseForm3_19.comPRODEPconsInteg || '0';

                                    // Observaciones
                                    document.querySelector('#obsCGUtitular').textContent = selectedResponseForm3_19.obsCGUtitular || '';
                                    document.querySelector('#obsCGUespecial').textContent = selectedResponseForm3_19.obsCGUespecial || '';
                                    document.querySelector('#obsCGUpermanente').textContent = selectedResponseForm3_19.obsCGUpermanente || '';
                                    document.querySelector('#obsCAACtitular').textContent = selectedResponseForm3_19.obsCAACtitular || '';
                                    document.querySelector('#obsCAACintegCom').textContent = selectedResponseForm3_19.obsCAACintegCom || '';
                                    document.querySelector('#obsComDepart').textContent = selectedResponseForm3_19.obsComDepart || '';
                                    document.querySelector('#obsComPEDPD').textContent = selectedResponseForm3_19.obsComPEDPD || '';
                                    document.querySelector('#obsComPartPos').textContent = selectedResponseForm3_19.obsComPartPos || '';
                                    document.querySelector('#obsRespPos').textContent = selectedResponseForm3_19.obsRespPos || '';
                                    document.querySelector('#obsRespCarrera').textContent = selectedResponseForm3_19.obsRespCarrera || '';
                                    document.querySelector('#obsRespProd').textContent = selectedResponseForm3_19.obsRespProd || '';
                                    document.querySelector('#obsRespLab').textContent = selectedResponseForm3_19.obsRespLab || '';
                                    document.querySelector('#obsExamProf').textContent = selectedResponseForm3_19.obsExamProf || '';
                                    document.querySelector('#obsExamAcademicos').textContent = selectedResponseForm3_19.obsExamAcademicos || '';
                                    document.querySelector('#obsPRODEPformResp').textContent = selectedResponseForm3_19.obsPRODEPformResp || '';
                                    document.querySelector('#obsPRODEPformInteg').textContent = selectedResponseForm3_19.obsPRODEPformInteg || '';
                                    document.querySelector('#obsPRODEPenconsResp').textContent = selectedResponseForm3_19.obsPRODEPenconsResp || '';
                                    document.querySelector('#obsPRODEPenconsInteg').textContent = selectedResponseForm3_19.obsPRODEPenconsInteg || '';
                                    document.querySelector('#obsPRODEPconsResp').textContent = selectedResponseForm3_19.obsPRODEPconsResp || '';
                                    document.querySelector('#obsPRODEPconsInteg').textContent = selectedResponseForm3_19.obsPRODEPconsInteg || '';


                                } else {
                                    console.error('No form3_19 data found for the selected dictaminador.');

                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('score3_19').textContent = '0';

                                    // Reset cantidad values
                                    for (let i = 0; i < cant3_19.length; i++) {
                                        const cantidad = cant3_19[i];
                                        document.querySelector(`input[name="${cantidad}"]`).value = '0';
                                    }

                                    // Reset subtotal values
                                    for (let j = 0; j < subtotal3_19.length; j++) {
                                        const subtotal = subtotal3_19[j];
                                        document.querySelector(`input[name="${subtotal}"]`).value = '0';
                                    }

                                    // Reset comision values
                                    for (let k = 0; k < comision3_19.length; k++) {
                                        const comision = comision3_19[k];
                                        const element = document.querySelector(`input[name="${comision}"]`);
                                        if (element) {
                                            element.textContent = '0';
                                        }
                                    }

                                    // Reset observation values
                                    for (let l = 0; l < obs3_19.length; l++) {
                                        const obs = obs3_19[l];
                                        const element = document.querySelector(`input[name="${obs}"]`);
                                        if (element) {
                                            element.textContent = ''; // Asignar un valor vacío
                                        }
                                    }

                                    document.getElementById('comision3_19').textContent = '0';
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

        // Function to handle form submission
        async function submitForm(url, formId) {
            const formData = {};
            const form = document.getElementById(formId);

            if (!form) {
                console.error(`Form with id "${formId}" not found.`);
                return;
            }

            formData['dictaminador_id'] = form.querySelector('input[name="dictaminador_id"]').value;
            formData['user_id'] = form.querySelector('input[name="user_id"]').value;
            formData['email'] = form.querySelector('input[name="email"]').value;
            formData['user_type'] = form.querySelector('input[name="user_type"]').value;

            // Puntajes
            for (let i = 0; i < cant3_19.length; i++) {
                formData[cant3_19[i]] = document.getElementById(cant3_19[i])?.textContent || '';
            }

            // Subtotales
            for (let j = 0; j < subtotal3_19.length; j++) {
                formData[subtotal3_19[j]] = document.getElementById(subtotal3_19[j])?.textContent || '';
            }

            // Comisiones
            for (let k = 0; k < comision3_19.length; k++) {
                formData[comision3_19[k]] = form.querySelector(`input[id="${comision3_19[k]}"]`)?.value || '';
            }

            // Observaciones
            for (let l = 0; l < obs3_19.length; l++) {
                formData[obs3_19[l]] = form.querySelector(`input[id="${obs3_19[l]}"]`)?.value || '';
            }

            formData['score3_19'] = document.getElementById('score3_19').textContent;
            formData['comision3_19'] = document.getElementById('comision3_19').textContent;

            // Observations

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