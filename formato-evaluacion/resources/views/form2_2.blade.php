@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="{{ $newLocale }}">

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
    <script src="{{ asset('js/subtotales.js') }}"></script>
    <script src="{{ asset('js/comisiones.js') }}"></script>
    <script src="{{ asset('js/privileges.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>


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
                                    <a class="nav-link active" style="width: 200px;" href="{{route('welcome')}}">Formato
                                        Evaluación, apartados 1 y 2</a>
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
                                <li id="jsonDataLink" class="d-none">
                                    <a href="{{ route('json-generator') }}" class="btn btn-primary">Mostrar datos de los
                                        Usuarios</a>
                                </li>
                                <li>
                                    <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                        Reporte</a>

                                </li>

                            </nav>
                </form>@endif
                </section>
                       
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">

                    <div class="flex lg:justify-center lg:col-start-2"></div>
                    <nav class="-mx-3 flex flex-1 justify-end"></nav>
                </header>

            @endif
            </div>
            </div>


        <main class="container">
            <!--Actividad 1: Permanencia en las actividades de la docencia	-->
        
      <form id="form2_2" method="POST" onsubmit="event.preventDefault(); submitForm('/store3', 'form2_2');">
      @csrf
      <div>
      <!--Actividad 2: Dedicacion en el Desempeño docente	-->
      <h4>Puntaje máximo
      <l    abel class="bg-black text-white px-4 mt-3" for="">200</l>
      </h4>
      </div>
      <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
      <input type="hidden" name="email" value="{{ auth()->user()->email }}">
      <table class="table table-sm">
      <thead>
      <tr>
      <th scope="col">Actividad</th>
      <th class="table-ajust" scope="col">Horas</th>
      <th class="table-ajust cd" scope="col">Puntaje a evaluar</th>
      <th class="table-ajust cd" scope="col">Puntaje de la Comisión Dictaminadora</th>
      <th class="table-ajust" scope="col">Observaciones</th>
      </tr>
      </thead>
      <tbody>
      <tr>
      <td><b>2. Dedicacion en el Desempeño docente</b></td>
      <td for=""></td>
      <td id="hours" name="hours" for=""><label id="hoursText" for="">0</label></td>
      <td id="actv2Comision" name="actv2Comision" for=""></td>
      </tr>
      <tr>
      <td><label for="">a) Posgrado</label>
      <label for="">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Semestre </label>
      </td>
        <span id="horasPosgrado"></span></td>
      <td class="puntajeEvaluar2"><label id="DSE" class="puntajeEvaluar" type="text"></label></td>
      <td class="comision actv"><input id="comisionPosgrado" placeholder="0" for=""
      oninput="onActv2Comision()"></input></td>
      <td><input id="obs2" name="obs2" class="table-header" type="text"></td>
      </tr>
      <tr>
      <td>b) Licenciatura y TSU
      <label for="">&nbsp &nbsp &nbsp &nbsp Horas </label>
      </td>
      <td><span id="horasSemestre"></span>
      </td>
      <td class="puntajeEvaluar2"><label id="DSE2" class="puntajeEvaluar" type="text"></label></td>
      <td class="comision actv"><input id="comisionLic" placeholder="0" oninput="onActv2Comision()"></input>
      </td>
      <td><input id="obs2_2" name="obs2_2" class="table-header" type="text"></input></td>
      </tr>
      </tbody>
      </table>
      <table>
      <thead>
      <tr>
      <th style="font-weight: normal; text-size: 20px;" scope="col">Acreditacion: </th>
                  <th style="width:60px;padding-left: 100px;">DSE/DIIP</th>
      <t    h style="font-weight: normal; padding-left: 100px;">8.5 puntos por cada hora/semana/año en cada
      caso
                  </t>
                  <th>
                  <button type="submit" class="btn btn-primary" id="form2_2Button">Enviar</button>
              </th>
      </tr>
              </thead>
      </table>      
                  </form>
        
            
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Leer los datos de localStorage
        const data = JSON.parse(localStorage.getItem('docenteData'));

        if (data) {
            // Actualizar los spans con los datos
            document.getElementById('horasPosgrado').textContent = data.horasPosgrado || '';
            document.getElementById('horasSemestre').textContent = data.horasSemestre || '';
            document.getElementById('dse').textContent = data.dse || '';
            document.getElementById('dse2').textContent = data.dse2 || '';
        }

        // Limpiar los datos de localStorage si ya no son necesarios
        //localStorage.removeItem('docenteData');
    });

    </script>
</script>

</html>