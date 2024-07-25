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
  
  <script src="https://kit.fontawesome.com/e72e299160.js" crossorigin="anonymous"></script>
  <style>
    body {
      margin-left: 200px;
      margin-bottom: 600px;
      display: flex;
      justify-content: space-between;

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
  </style>

</head>
@if (Route::has('login'))
  @csrf
  @if (Auth::check())

    <nav class="nav flex-column">
    <li class="nav-item">
    <a class="nav-link disabled" href="#"><i class="fa-solid fa-user"></i>{{ Auth::user()->email }}</a>
</li>@endif
    </li>
    <li class="nav-item">
    <a class="nav-link active" href="{{ route('welcome') }}">FORMATO DE EVALUACIÓN</a>
    </li>
    <ul class="deptos">Departamentos:
    <li>Agropecuarias</li>
    <li>Ciencias del Mar y de la Tierra</li>
    <li>Ciencias Sociales y Humanidades</li>
    <li>Agronomía</li>
    <li>Ciencia Animal y Conservación del Hábitat</li>
    <li>Ciencias de la Tierra</li>
    <li>Ciencias Marinas y Costeras</li>
    <li>Ciencias Sociales y Jurídicas</li>
    <li>Economía</li>
    <li>Humanidades</li>
    <li>Ingeniería en Pesquerías</li>
    <li>Sistemas Computacionales</li>
    </ul>
  </nav>

  <body class="font-sans antialiased">
    <div class="bg-gray-50 text-black/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
      <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
      <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
        <div class="flex lg:justify-center lg:col-start-2"></div>

        <nav class="-mx-3 flex flex-1 justify-end"></nav>
        <div class="table-container">
        <table class="table table-bordered">
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
            <td>377</td>
            <td>I</td>
          </tr>
          <?php
    $minima = [378, 455, 456, 533, 534, 611, 612, 689, 690, 767, 768, 845, 846, 923, 924, 1000];
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
    $puntuacion_maxima = [264, 319, 374, 429, 484, 539, 594, 649, 704];
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
    </script>
  </body>
@endif

</html>