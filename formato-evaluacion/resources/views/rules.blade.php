@php
$userType = Auth::user()->user_type;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>FORMATO DE EVALUACION</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css" media="print" />
  <link href="{{ asset('css/darkmode.css') }}" rel="stylesheet">
  <script src="https://kit.fontawesome.com/e72e299160.js" crossorigin="anonymous"></script>
  <style>
    body {
      margin-left: 200px;
      margin-bottom: 600px;
      display: flex;
      justify-content: space-between;
      background-color: #f4f4f4;

    }
    .enlaceSN {
        color: #4281a4;
        /* Elige el color que prefieras */
    }

    .enlaceSN:hover {
        color: #086375;
        /* Puedes cambiar el color en el hover también */
    }
    nav {
      margin-left: -180px;
      padding-top: 50px;
      width: 300px;

    }

    .deptos ul {
      list-style-type: none;
      padding: 0;
    }

    .deptos li {
      margin-bottom: 10px;
      margin-left: 20px;
      list-style-type: none;
    }

    table {
      border-collapse: collapse;
      width: calc(100% - 300px);
      margin: auto;
      margin-left: -900px;
      border: 4px solid black !important;
    }

    .borderless th {
      border: none;
    }

    th,
    td {
      border: solid black;
      padding: 8px;
      width: 50px;
      text-align: center;

    }

    .table-container {
      display: flex;
      justify-content: space-between;
    }

    .table-container2 {
      margin-bottom: 100px;
      justify-content: space-between;
      margin-left: 60px;
    }

  .nav-max-content{
      height: max-content !important;
      color: white;
      width: max-content;

  }
  .nav-max-content a{
      color: white;
      font-size: larger;
  } 
  .a-font-larger a{
      font-size: larger;
      color: white;
  }
  </style>

</head>
@if (Route::has('login'))
    @csrf
    @if (Auth::check())

      <x-nav-menu :user="Auth::user()" navClass="nav-max-content" emailClass="a-font-larger">
      <div>
      <ul style="list-style: none;">
      <li class="nav-item">
      @if(Auth::user()->user_type === 'dictaminador')
      <a class="nav-link active enlaceSN" style="width: 300px;font-size: 20px;"
      href="{{ route('comision_dictaminadora') }}" title="Formato de Evaluación docente"><i class="fa-solid fa-align-justify"></i>&nbspEvaluación</a>
      @elseif(Auth::user()->user_type === '')
      <a class="nav-link active enlaceSN" style="width: 250px;font-size: 20px;"  title="Formato de Evaluación docente"href="{{ route('secretaria') }}"><i class="fa-solid fa-align-justify"></i>&nbspEvaluación</a>
      @else
      <a class="nav-link active enlaceSN" style="width: 250px;font-size: 20px;"  title="Formato de Evaluación docente"href="{{ route('welcome') }}"><i class="fa-solid fa-align-justify"></i>&nbspEvaluación</a>
      @endif
      </li>

      @if(Auth::user()->user_type === '')
      <li class="nav-item">
      <a class="nav-link active enlaceSN" style="width: 300px;" href="{{route('dynamic_forms')}}"
      title="Ingresar nuevo formulario"><i class="fa-solid fa-folder-plus"></i>&nbspIngresar nuevo</a>
      </li>
      @endif
      </ul>
      <ul class="deptos"><h5><i class="fa-solid fa-brain"></i>&nbspÁreas de Conocimiento:</h5>
      <li><i class="fa-solid fa-seedling"></i>&nbspAgropecuarias</li>
      <li><i class="fa-solid fa-water"></i> Ciencias del Mar y de la Tierra</li>
      <li><i class="fa-solid fa-users"></i>&nbspCiencias Sociales y Humanidades</li>
      </ul>
      <ul class="deptos"><h5><i class="fa-solid fa-building"></i>&nbspDepartamentos:</h5>
      <li><i class="fa-solid fa-leaf"></i>&nbspAgronomía</li>
      <li><i class="fa-solid fa-paw"></i>&nbspCiencia Animal <br> y Conservación del Hábitat</li>
      <li><i class="fa-solid fa-mountain"></i>&nbspCiencias de la Tierra</li>
      <li><i class="fa-solid fa-fish"></i>&nbspCiencias Marinas y Costeras</li>
      <li><i class="fa-solid fa-scale-balanced"></i>&nbspCiencias Sociales y Jurídicas</li>
      <li><i class="fa-solid fa-chart-line"></i>&nbspEconomía</li>
      <li><i class="fa-solid fa-book"></i>&nbspHumanidades</li>
      <li><i class="fa-solid fa-anchor"></i>&nbspIngeniería en Pesquerías</li>
      <li><i class="fa-solid fa-laptop-code"></i>&nbspSistemas Computacionales</li>
      </ul>
      </div>
      </x-nav-menu>

  @endif


    <body class="font-sans antialiased">
      <x-general-header />
    <div class="bg-gray-50 text-black/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
      <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
      <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
      <div class="flex lg:justify-center lg:col-start-2"></div>

      <nav class="-mx-3 flex flex-1 justify-end"></nav>
      <button id="toggle-dark-mode" class="btn btn-secondary printButtonClass" style="margin-right: 100px;"><i class="fa-solid fa-moon"></i>&nbspModo Obscuro</button>
      <div class="table-container">
      <table class="table table-bordered" style="margin-top: 200px;">
      <thead>
      <tr class="borderless">
      <th style="border-left: solid 1px;">&nbsp</th>
      <th>Artículo 10 REGLAMENTO PEDPD</th>
      <th style="border-right: solid 1px;">&nbsp</th>
      </tr>
      <tr>
      <th>PUNTUACIÓN TOTAL MÍNIMA</th>
      <th>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</th>
      <th>NIVEL</th>
      </tr>
      </thead>
      <tbody>
      <tr>
      <td>301</td>
      <td>377.99</td>
      <td>I</td>
      </tr>
      <?php
  $minima = [378, 455.99, 456, 533.99, 534, 611.99, 612, 689.99, 690, 767.99, 768, 845.99, 846, 923.99, 924, 1000];
  $nivel = ['II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX'];
  for ($i = 0; $i < count($minima); $i += 2) {
    echo '<tr>';
    for ($j = 0; $j < 2; $j++) {
      echo '<td>' . $minima[$i + $j] . '</td>';
    }
    echo '<td>' . $nivel[$i / 2] . '</td>';
    echo '</tr>';
  }
      ?>

      </tbody>
      <?php
  $puntuacion_minima = [210, 265, 320, 375, 430, 485, 540, 595, 650];
  $puntuacion_maxima = [264.99, 319.99, 374.99, 429.99, 484.99, 539.99, 594.99, 649.99, 704];
  $nivel = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX'];
      ?>

      <table class="table table-bordered table-container2">
      <thead>
      <tr>
      <th>PUNTUACIÓN MÍNIMA DE CALIDAD</th>
      <th>NIVEL</th>
      </tr>
      </thead>
      <tbody>
      <?php  for ($i = 0; $i < count($puntuacion_minima); $i++): ?>
      <tr>
      <td><?php    echo $puntuacion_minima[$i]; ?> - <?php    echo $puntuacion_maxima[$i]; ?></td>
      <td><?php    echo $nivel[$i]; ?></td>
      </tr>
      <?php  endfor; ?>
      </tbody>
      </table>
      </div>
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

    document.addEventListener('DOMContentLoaded', function () {
      const toggleDarkModeButton = document.getElementById('toggle-dark-mode');

      // Guardar la preferencia del usuario en localStorage
      const currentTheme = localStorage.getItem('theme');
      if (currentTheme) {
      document.body.classList.add(currentTheme);
      if (currentTheme === 'dark') {
      toggleDarkModeButton.classList.replace('btn-secondary', 'btn-primary');
      toggleDarkModeButton.innerHTML = '<i class="fa-solid fa-sun"></i>&nbspModo Claro';
      }
      }

      toggleDarkModeButton.addEventListener('click', function () {
      document.body.classList.toggle('dark-mode');
      let theme = 'light';

      if (document.body.classList.contains('dark-mode')) {
      theme = 'dark';
      toggleDarkModeButton.classList.replace('btn-secondary', 'btn-light');
      toggleDarkModeButton.innerHTML = '<i class="fa-solid fa-sun"></i>&nbspModo Claro';
      } else {
      toggleDarkModeButton.classList.replace('btn-primary', 'btn-secondary');
      toggleDarkModeButton.innerHTML = '<i class="fa-solid fa-moon"></i>&nbspModo Obscuro';
      }
      localStorage.setItem('theme', theme);
      });
      });
    </script>
    </body>
@endif

</html>