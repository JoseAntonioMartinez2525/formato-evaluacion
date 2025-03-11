@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="">

<head>
    <title>Organización de congresos o eventos institucionales del área de conocimiento de la o el Docente</title>
    <meta charset="utf-9">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-head-resources />
    <style>
        #piedepagina { display: none; }

    @media print {
        #piedepagina{
            display: block !important;
        }

       footer {
    position: absolute; /* Usar absolute en lugar de fixed */
    font-size: .8rem;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
    background-color: white;
    z-index: 10;
    padding: 5px 0;
    border-top: 1px solid #ccc;
}

    footer::after {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            
            background: white;
            padding: 5px;
            z-index: 10;
        }


    .prevent-overlap {
        page-break-before: always;
    }

    #convocatoria {
        margin: 0;
        font-size: .8rem;
    }

    #piedepagina {
        margin: 0;
         page-break-inside: avoid; /* Evitar saltos dentro del pie de página */
    }

    div {
        page-break-after: avoid;
        page-break-before: avoid;
    }
    

    @page {
        size: landscape;
        margin: 20mm; /* Ajusta según sea necesario */
        
    }


    .page-number:after {
        content: "Página " counter(page);
    }

}
    </style>
    
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
@endphp

    <button id="toggle-dark-mode" class="btn btn-secondary"><i class="fa-solid fa-moon"></i>&nbspModo Obscuro</button>

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
        <!-- Form for Part 3_18 -->
        <form id="form3_18" method="POST" onsubmit="event.preventDefault(); submitForm('/store-form318', 'form3_18');">
            @csrf
            <input type="hidden" name="dictaminador_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_id" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="user_type" value="">
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
                    <th id="seccion3_18" class="acreditacion" colspan=5> 3.18 Organización de congresos
                        o eventos
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
                    <td id="cantComOrgInt"></td>
                    <td></td>
                    <td id="subtotalComOrgInt"></td>
                    <td>
                        @if ($userType == 'dictaminador')
                            <input type="number"  step="0.01" id="comisionComOrgInt" name="comisionComOrgInt" value="{{ oldValueOrDefault('comisionComOrgInt') }}" oninput="onActv3Comision3_18()">
                        @else
                            <span id="comisionComOrgInt" name="comisionComOrgInt"></span>
                        @endif
                    </td>
                    <td>
                        @if ($userType == 'dictaminador')
                            <input class="table-header" type="text" id="obsComOrgInt">
                        @else
                            <span id="obsComOrgInt" name="obsComOrgInt"></span>
                        @endif
                    </td>
                    </tr>
                    <tr>
                        <td>b)</td>
                        <td>Comité organizador</td>
                        <td></td>
                        <td>Nacional</td>
                        <td id="puntajeComOrgNac"><b>20</b></td>
                        <td id="cantComOrgNac"></td>
                        <td></td>
                        <td id="subtotalComOrgNac"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number"  step="0.01" id="comisionComOrgNac" name="comisionComOrgNac" value="{{ oldValueOrDefault('comisionComOrgNac') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionComOrgNac" name="comisionComOrgNac"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsComOrgNac">
                            @else
                                <span id="obsComOrgNac" name="obsComOrgNac"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>c)</td>
                        <td>Comité organizador</td>
                        <td></td>
                        <td>Regional</td>
                        <td id="puntajeComOrgReg"><b>10</b></td>
                        <td id="cantComOrgReg"></td>
                        <td></td>
                        <td id="subtotalComOrgReg"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number"  step="0.01" id="comisionComOrgReg" name="comisionComOrgReg" value="{{ oldValueOrDefault('comisionComOrgReg') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionComOrgReg" name="comisionComOrgReg"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsComOrgReg">
                            @else
                                <span id="obsComOrgReg" name="obsComOrgReg"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>d)</td>
                        <td>Comisiones de Apoyo</td>
                        <td></td>
                        <td>Internacional</td>
                        <td id="puntajeComApoyoInt"><b>40</b></td>
                        <td id="cantComApoyoInt"></td>
                        <td></td>
                        <td id="subtotalComApoyoInt"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionComApoyoInt" name="comisionComApoyoInt" value="{{ oldValueOrDefault('comisionComApoyoInt') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionComApoyoInt" name="comisionComApoyoInt"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsComApoyoInt">
                            @else
                                <span id="obsComApoyoInt" name="obsComApoyoInt"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>e)</td>
                        <td>Comisiones de Apoyo</td>
                        <td></td>
                        <td>Nacional</td>
                        <td id="puntajeComApoyoNac"><b>20</b></td>
                        <td id="cantComApoyoNac"></td>
                        <td></td>
                        <td id="subtotalComApoyoNac"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionComApoyoNac" name="comisionComApoyoNac" value="{{ oldValueOrDefault('comisionComApoyoNac') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionComApoyoNac" name="comisionComApoyoNac"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsComApoyoNac">
                            @else
                                <span id="obsComApoyoNac" name="obsComApoyoNac"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>f)</td>
                        <td>Comisiones de Apoyo</td>
                        <td></td>
                        <td>Regional</td>
                        <td id="puntajeComApoyoReg"><b>10</b></td>
                        <td id="cantComApoyoReg"></td>
                        <td></td>
                        <td id="subtotalComApoyoReg"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionComApoyoReg" name="comisionComApoyoReg" value="{{ oldValueOrDefault('comisionComApoyoReg') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionComApoyoReg" name="comisionComApoyoReg"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsComApoyoReg">
                            @else
                                <span id="obsComApoyoReg" name="obsComApoyoReg"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>g)</td>
                        <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                        <td>Comité organizador</td>
                        <td>Internacional</td>
                        <td id="puntajeCicloComOrgInt"><b>20</b></td>
                        <td id="cantCicloComOrgInt"></td>
                        <td></td>
                        <td id="subtotalCicloComOrgInt"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionCicloComOrgInt" name="comisionCicloComOrgInt" value="{{ oldValueOrDefault('comisionCicloComOrgInt') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionCicloComOrgInt" name="comisionCicloComOrgInt"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsCicloComOrgInt">
                            @else
                                <span id="obsCicloComOrgInt" name="obsCicloComOrgInt"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>h)</td>
                        <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                        <td>Comité organizador</td>
                        <td>Nacional</td>
                        <td id="puntajeCicloComOrgNac"><b>15</b></td>
                        <td id="cantCicloComOrgNac"></td>
                        <td></td>
                        <td id="subtotalCicloComOrgNac"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionCicloComOrgNac" name="comisionCicloComOrgNac" value="{{ oldValueOrDefault('comisionCicloComOrgNac') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionCicloComOrgNac" name="comisionCicloComOrgNac"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsCicloComOrgNac">
                            @else
                                <span id="obsCicloComOrgNac" name="obsCicloComOrgNac"></span>
                            @endif
                        </td>
                    </tr>
                    <tr class="prevent-overlap">
                        <td>i)</td>
                        <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                        <td>Comité organizador</td>
                        <td>Regional/Institucional</td>
                        <td id="puntajeCicloComOrgReg"><b>10</b></td>
                        <td id="cantCicloComOrgReg"></td>
                        <td></td>
                        <td id="subtotalCicloComOrgReg"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionCicloComOrgReg" name="comisionCicloComOrgReg" value="{{ oldValueOrDefault('comisionCicloComOrgReg') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionCicloComOrgReg" name="comisionCicloComOrgReg"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsCicloComOrgReg">
                            @else
                                <span id="obsCicloComOrgReg" name="obsCicloComOrgReg"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>j)</td>
                        <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                        <td>Comisiones de apoyo</td>
                        <td>Internacional</td>
                        <td id="puntajeCicloComApoyoInt"><b>20</b></td>
                        <td id="cantCicloComApoyoInt"></td>
                        <td></td>
                        <td id="subtotalCicloComApoyoInt"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionCicloComApoyoInt" name="comisionCicloComApoyoInt" value="{{ oldValueOrDefault('comisionCicloComApoyoInt') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionCicloComApoyoInt" name="comisionCicloComApoyoInt"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsCicloComApoyoInt">
                            @else
                                <span id="obsCicloComApoyoInt" name="obsCicloComApoyoInt"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>k)</td>
                        <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                        <td>Comisiones de apoyo</td>
                        <td>Nacional</td>
                        <td id="puntajeCicloComApoyoNac"><b>15</b></td>
                        <td id="cantCicloComApoyoNac"></td>
                        <td></td>
                        <td id="subtotalCicloComApoyoNac"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionCicloComApoyoNac" name="comisionCicloComApoyoNac" value="{{ oldValueOrDefault('comisionCicloComApoyoNac') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionCicloComApoyoNac" name="comisionCicloComApoyoNac"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsCicloComApoyoNac">
                            @else
                                <span id="obsCicloComApoyoNac" name="obsCicloComApoyoNac"></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>l)</td>
                        <td>Ciclo de conferencias, simposio, coloquio, etc.</td>
                        <td>Comisiones de apoyo</td>
                        <td>Regional/Institucional</td>
                        <td id="puntajeCicloComApoyoReg"><b>10</b></td>
                        <td id="cantCicloComApoyoReg"></td>
                        <td></td>
                        <td id="subtotalCicloComApoyoReg"></td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input type="number" step="0.01" id="comisionCicloComApoyoReg" name="comisionCicloComApoyoReg" value="{{ oldValueOrDefault('comisionCicloComApoyoReg') }}"
                                    oninput="onActv3Comision3_18()">
                            @else
                                <span id="comisionCicloComApoyoReg" name="comisionCicloComApoyoReg"></span>
                            @endif
                        </td>
                        <td>
                            @if ($userType == 'dictaminador')
                                <input class="table-header" type="text" id="obsCicloComApoyoReg">
                            @else
                                <span id="obsCicloComApoyoReg" name="obsCicloComApoyoReg"></span>
                            @endif
                        </td>
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
                    <th>
                    @if ($userType != '')
                        <button id="btn3_18" type="submit" class="btn custom-btn printButtonClass">Enviar</button>
                    @endif
                        
                    </th>
                </tr>
            </thead>
        </table>
        </form>
    </main>
    <center>
    <footer id="footerForm3_4">
        <center>
            <div id="convocatoria">
                <!-- Mostrar convocatoria -->
                @if(isset($convocatoria))

                    <div style="margin-right: -700px;">
                        <h1>Convocatoria: {{ $convocatoria->convocatoria }}</h1>
                    </div>
                @endif
            </div>
        </center>

        <div id="piedepagina" style="margin-left: 500px;margin-top:10px;">
            <x-form-renderer :forms="[['view' => 'form3_18', 'startPage' => 24, 'endPage' => 25]]" />
        </div>
    </footer>
    </center>

    <script>
        window.onload = function () {
            const footerHeight = document.querySelector('footer').offsetHeight;
            const elements = document.querySelectorAll('.prevent-overlap');

            elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const viewportHeight = window.innerHeight;

                // Verifica si el elemento está demasiado cerca del footer y aplica page-break-before si es necesario
                if (rect.bottom + footerHeight > viewportHeight) {
                    element.style.pageBreakBefore = "always"; // Forzar salto antes
                }
            });

        };          
        let cant3_18 = ['cantComOrgInt', 'cantComOrgNac', 'cantComOrgReg', 'cantComApoyoInt', 'cantComApoyoNac', 'cantComApoyoReg', 'cantCicloComOrgInt', 'cantCicloComOrgNac', 'cantCicloComOrgReg', 'cantCicloComApoyoInt', 'cantCicloComApoyoNac', 'cantCicloComApoyoReg'];
        let subtotal3_18 = ['subtotalComOrgInt', 'subtotalComOrgNac', 'subtotalComOrgReg', 'subtotalComApoyoInt', 'subtotalComApoyoNac', 'subtotalComApoyoReg', 'subtotalCicloComOrgInt', 'subtotalCicloComOrgNac', 'subtotalCicloComOrgReg', 'subtotalCicloComApoyoInt', 'subtotalCicloComApoyoNac', 'subtotalCicloComApoyoReg'];
        let comision3_18 = ['comisionComOrgInt', 'comisionComOrgNac', 'comisionComOrgReg', 'comisionComApoyoInt', 'comisionComApoyoNac', 'comisionComApoyoReg', 'comisionCicloComOrgInt', 'comisionCicloComOrgNac', 'comisionCicloComOrgReg', 'comisionCicloComApoyoInt', 'comisionCicloComApoyoNac', 'comisionCicloComApoyoReg'];
        let obs3_18 = ['obsComOrgInt', 'obsComOrgNac', 'obsComOrgReg', 'obsComApoyoInt', 'obsComApoyoNac', 'obsComApoyoReg', 'obsCicloComOrgInt', 'obsCicloComOrgNac', 'obsCicloComOrgReg', 'obsCicloComApoyoInt', 'obsCicloComApoyoNac','obsCicloComApoyoReg'];

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
                                    document.getElementById('score3_18').textContent = data.form3_18.score3_18 || '0';

                                    // Cantidades
                                    document.getElementById('cantComOrgInt').textContent = data.form3_18.cantComOrgInt || '0';
                                    document.getElementById('cantComOrgNac').textContent = data.form3_18.cantComOrgNac || '0';
                                    document.getElementById('cantComApoyoInt').textContent = data.form3_18.cantComApoyoInt || '0';
                                    document.getElementById('cantComApoyoNac').textContent = data.form3_18.cantComApoyoNac || '0';
                                    document.getElementById('cantComApoyoReg').textContent = data.form3_18.cantComApoyoReg || '0';
                                    document.getElementById('cantCicloComOrgInt').textContent = data.form3_18.cantCicloComOrgInt || '0';
                                    document.getElementById('cantCicloComOrgNac').textContent = data.form3_18.cantCicloComOrgNac || '0';
                                    document.getElementById('cantCicloComOrgReg').textContent = data.form3_18.cantCicloComOrgReg || '0';
                                    document.getElementById('cantCicloComApoyoInt').textContent = data.form3_18.cantCicloComApoyoInt || '0';
                                    document.getElementById('cantCicloComApoyoNac').textContent = data.form3_18.cantCicloComApoyoNac || '0';
                                    document.getElementById('cantCicloComApoyoReg').textContent = data.form3_18.cantCicloComApoyoReg || '0';
                                    document.getElementById('cantComOrgReg').textContent = data.form3_18.cantComOrgReg || '0';

                                    // Subtotales
                                    document.getElementById('subtotalComOrgInt').textContent = data.form3_18.subtotalComOrgInt || '0';
                                    document.getElementById('subtotalComOrgNac').textContent = data.form3_18.subtotalComOrgNac || '0';
                                    document.getElementById('subtotalComOrgReg').textContent = data.form3_18.subtotalComOrgReg || '0';
                                    document.getElementById('subtotalComApoyoInt').textContent = data.form3_18.subtotalComApoyoInt || '0';
                                    document.getElementById('subtotalComApoyoNac').textContent = data.form3_18.subtotalComApoyoNac || '0';
                                    document.getElementById('subtotalComApoyoReg').textContent = data.form3_18.subtotalComApoyoReg || '0';
                                    document.getElementById('subtotalCicloComOrgInt').textContent = data.form3_18.subtotalCicloComOrgInt || '0';
                                    document.getElementById('subtotalCicloComOrgNac').textContent = data.form3_18.subtotalCicloComOrgNac || '0';
                                    document.getElementById('subtotalCicloComOrgReg').textContent = data.form3_18.subtotalCicloComOrgReg || '0';
                                    document.getElementById('subtotalCicloComApoyoInt').textContent = data.form3_18.subtotalCicloComApoyoInt || '0';
                                    document.getElementById('subtotalCicloComApoyoNac').textContent = data.form3_18.subtotalCicloComApoyoNac || '0';
                                    document.getElementById('subtotalCicloComApoyoReg').textContent = data.form3_18.subtotalCicloComApoyoReg || '0';


                                    // Populate hidden inputs
                                    document.querySelector('input[name="user_id"]').value = data.form3_18.user_id || '';
                                    document.querySelector('input[name="email"]').value = data.form3_18.email || '';
                                    document.querySelector('input[name="user_type"]').value = data.form3_18.user_type || '';

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
                            // Lógica para obtener datos de DictaminatorsResponseForm3_18
                            try {
                                const response = await fetch('/get-dictaminators-responses');
                                const dictaminatorResponses = await response.json();
                                // Filtrar la entrada correspondiente al email seleccionado
                                const selectedResponseForm3_18 = dictaminatorResponses.form3_18.find(res => res.email === email);
                                if (selectedResponseForm3_18) {

                                    document.querySelector('input[name="dictaminador_id"]').value = selectedResponseForm3_18.dictaminador_id || '0';
                                    document.querySelector('input[name="user_id"]').value = selectedResponseForm3_18.user_id || '';
                                    document.querySelector('input[name="email"]').value = selectedResponseForm3_18.email || '';
                                    document.querySelector('input[name="user_type"]').value = selectedResponseForm3_18.user_type || '';
                                    document.getElementById('score3_18').textContent = selectedResponseForm3_18.score3_18 || '0';
                                    document.getElementById('comision3_18').textContent = selectedResponseForm3_18.comision3_18 || '0';

                                    // Cantidades
                                    document.getElementById('cantComOrgInt').textContent = selectedResponseForm3_18.cantComOrgInt || '0';
                                    document.getElementById('cantComOrgNac').textContent = selectedResponseForm3_18.cantComOrgNac || '0';
                                    document.getElementById('cantComOrgReg').textContent = selectedResponseForm3_18.cantComOrgReg || '0';
                                    document.getElementById('cantComApoyoInt').textContent = selectedResponseForm3_18.cantComApoyoInt || '0';
                                    document.getElementById('cantComApoyoNac').textContent = selectedResponseForm3_18.cantComApoyoNac || '0';
                                    document.getElementById('cantComApoyoReg').textContent = selectedResponseForm3_18.cantComApoyoReg || '0';
                                    document.getElementById('cantCicloComOrgInt').textContent = selectedResponseForm3_18.cantCicloComOrgInt || '0';
                                    document.getElementById('cantCicloComOrgNac').textContent = selectedResponseForm3_18.cantCicloComOrgNac || '0';
                                    document.getElementById('cantCicloComOrgReg').textContent = selectedResponseForm3_18.cantCicloComOrgReg || '0';
                                    document.getElementById('cantCicloComApoyoInt').textContent = selectedResponseForm3_18.cantCicloComApoyoInt || '0';
                                    document.getElementById('cantCicloComApoyoNac').textContent = selectedResponseForm3_18.cantCicloComApoyoNac || '0';
                                    document.getElementById('cantCicloComApoyoReg').textContent = selectedResponseForm3_18.cantCicloComApoyoReg || '0';

                                    // Subtotales
                                    document.getElementById('subtotalComOrgInt').textContent = selectedResponseForm3_18.subtotalComOrgInt || '0';
                                    document.getElementById('subtotalComOrgNac').textContent = selectedResponseForm3_18.subtotalComOrgNac || '0';
                                    document.getElementById('subtotalComOrgReg').textContent = selectedResponseForm3_18.subtotalComOrgReg || '0';
                                    document.getElementById('subtotalComApoyoInt').textContent = selectedResponseForm3_18.subtotalComApoyoInt || '0';
                                    document.getElementById('subtotalComApoyoNac').textContent = selectedResponseForm3_18.subtotalComApoyoNac || '0';
                                    document.getElementById('subtotalComApoyoReg').textContent = selectedResponseForm3_18.subtotalComApoyoReg || '0';
                                    document.getElementById('subtotalCicloComOrgInt').textContent = selectedResponseForm3_18.subtotalCicloComOrgInt || '0';
                                    document.getElementById('subtotalCicloComOrgNac').textContent = selectedResponseForm3_18.subtotalCicloComOrgNac || '0';
                                    document.getElementById('subtotalCicloComOrgReg').textContent = selectedResponseForm3_18.subtotalCicloComOrgReg || '0';
                                    document.getElementById('subtotalCicloComApoyoInt').textContent = selectedResponseForm3_18.subtotalCicloComApoyoInt || '0';
                                    document.getElementById('subtotalCicloComApoyoNac').textContent = selectedResponseForm3_18.subtotalCicloComApoyoNac || '0';
                                    document.getElementById('subtotalCicloComApoyoReg').textContent = selectedResponseForm3_18.subtotalCicloComApoyoReg || '0';


                                    // Comisiones
                                    document.querySelector('#comisionComOrgInt').textContent = selectedResponseForm3_18.comisionComOrgInt || '0';
                                    document.querySelector('#comisionComOrgNac').textContent = selectedResponseForm3_18.comisionComOrgNac || '0';
                                    document.querySelector('#comisionComOrgReg').textContent = selectedResponseForm3_18.comisionComOrgReg || '0';
                                    document.querySelector('#comisionComApoyoInt').textContent = selectedResponseForm3_18.comisionComApoyoInt || '0';
                                    document.querySelector('#comisionComApoyoNac').textContent = selectedResponseForm3_18.comisionComApoyoNac || '0';
                                    document.querySelector('#comisionComApoyoReg').textContent = selectedResponseForm3_18.comisionComApoyoReg || '0';
                                    document.querySelector('#comisionCicloComOrgInt').textContent = selectedResponseForm3_18.comisionCicloComOrgInt || '0';
                                    document.querySelector('#comisionCicloComOrgNac').textContent = selectedResponseForm3_18.comisionCicloComOrgNac || '0';
                                    document.querySelector('#comisionCicloComOrgReg').textContent = selectedResponseForm3_18.comisionCicloComOrgReg || '0';
                                    document.querySelector('#comisionCicloComApoyoInt').textContent = selectedResponseForm3_18.comisionCicloComApoyoInt || '0';
                                    document.querySelector('#comisionCicloComApoyoNac').textContent = selectedResponseForm3_18.comisionCicloComApoyoNac || '0';
                                    document.querySelector('#comisionCicloComApoyoReg').textContent = selectedResponseForm3_18.comisionCicloComApoyoReg || '0';

                                    // Observaciones
                                    document.querySelector('#obsComOrgInt').textContent = selectedResponseForm3_18.obsComOrgInt || '';
                                    document.querySelector('#obsComOrgNac').textContent = selectedResponseForm3_18.obsComOrgNac || '';
                                    document.querySelector('#obsComOrgReg').textContent = selectedResponseForm3_18.obsComOrgReg || '';
                                    document.querySelector('#obsComApoyoInt').textContent = selectedResponseForm3_18.obsComApoyoInt || '';
                                    document.querySelector('#obsComApoyoNac').textContent = selectedResponseForm3_18.obsComApoyoNac || '';
                                    document.querySelector('#obsComApoyoReg').textContent = selectedResponseForm3_18.obsComApoyoReg || '';
                                    document.querySelector('#obsCicloComOrgInt').textContent = selectedResponseForm3_18.obsCicloComOrgInt || '';
                                    document.querySelector('#obsCicloComOrgNac').textContent = selectedResponseForm3_18.obsCicloComOrgNac || '';
                                    document.querySelector('#obsCicloComOrgReg').textContent = selectedResponseForm3_18.obsCicloComOrgReg || '';
                                    document.querySelector('#obsCicloComApoyoInt').textContent = selectedResponseForm3_18.obsCicloComApoyoInt || '';
                                    document.querySelector('#obsCicloComApoyoNac').textContent = selectedResponseForm3_18.obsCicloComApoyoNac || '';
                                    document.querySelector('#obsCicloComApoyoReg').textContent = selectedResponseForm3_18.obsCicloComApoyoReg || '';


                                } else {
                                    console.error('No form3_18 data found for the selected dictaminador.');

                                    // Reset input values if no data found
                                    document.querySelector('input[name="dictaminador_id"]').value = '0';
                                    document.querySelector('input[name="user_id"]').value = '0';
                                    document.querySelector('input[name="email"]').value = '';
                                    document.querySelector('input[name="user_type"]').value = '';

                                    document.getElementById('score3_18').textContent = '0';

                                    // Reset cantidad values
                                    for (let i = 0; i < cant3_18.length; i++) {
                                        const cantidad = cant3_18[i];
                                        document.querySelector(`input[name="${cantidad}"]`).value = '0';
                                    }

                                    // Reset subtotal values
                                    for (let j = 0; j < subtotal3_18.length; j++) {
                                        const subtotal = subtotal3_18[j];
                                        document.querySelector(`input[name="${subtotal}"]`).value = '0';
                                    }

                                    // Reset comision values
                                    for (let k = 0; k < comision3_18.length; k++) {
                                        const comision = comision3_18[k];
                                        const element = document.querySelector(`input[name="${comision}"]`);
                                        if (element) {
                                            element.textContent = '0';
                                        }
                                    }

                                    // Reset observation values
                                    for (let l = 0; l < obs3_18.length; l++) {
                                        const obs = obs3_18[l];
                                        const element = document.querySelector(`input[name="${obs}"]`);
                                        if (element) {
                                            element.textContent = ''; // Asignar un valor vacío
                                        }
                                    }

                                    document.getElementById('comision3_18').textContent = '0';
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
            for (let i = 0; i < cant3_18.length; i++) {
                formData[cant3_18[i]] = document.getElementById(cant3_18[i])?.textContent || '';
            }

            // Subtotales
            for (let j = 0; j < subtotal3_18.length; j++) {
                formData[subtotal3_18[j]] = document.getElementById(subtotal3_18[j])?.textContent || '';
            }

            // Comisiones
            for (let k = 0; k < comision3_18.length; k++) {
                formData[comision3_18[k]] = form.querySelector(`input[id="${comision3_18[k]}"]`)?.value || '';
            }

            // Observaciones
            for (let l = 0; l < obs3_18.length; l++) {
                formData[obs3_18[l]] = form.querySelector(`input[id="${obs3_18[l]}"]`)?.value || '';
            }

            formData['score3_18'] = document.getElementById('score3_18').textContent;
            formData['comision3_18'] = document.getElementById('comision3_18').textContent;

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