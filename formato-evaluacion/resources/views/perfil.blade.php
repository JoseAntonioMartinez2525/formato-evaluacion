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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<body>
    <h1>Datos del Resumen</h1>

        <p>Email: 
            <span id="email"></span>
        </p>
        <p>Comisión Actividad 1 Total: 
            <span id="comision_actividad_1_total"></span>
        </p>
        <p>Comisión Actividad 2 Total: 
            <span id="comision_actividad_2_total"></span>
        </p>
        <p>Comisión Actividad 3 Total: 
            <span id="comision_actividad_3_total"></span>
        </p>
        <p>Total Puntaje: 
            <span id="total_puntaje"></span>
        </p>
        <p>Mínima Calidad: 
            <span id="minima_calidad"></span>
        </p>
        <p>Mínima Total: 
            <span id="minima_total"></span>
        </p>
  

    <h1>Persona Evaluadora y Firma</h1>

        <table>
            <thead>
                <td>Nombre de la Persona Evaluadora:  <span id="evaluator_name"></span></td>
                <td><img  id="signature_path" alt="Signature" style="max-width: 300px;"></td>
            </thead>
        </table>
</body>
<script>
    
        async function loadAllData() {
            let dataResume = await fetchData('/get-data-resume', { user_id: userId });
            let dataSignature = await fetchData('/get-evaluator-signature', { user_id: userId });

            // Populate labels with the retrieved data
            document.getElementById('email').innerText = dataResume ? dataResume.email : '';
            document.getElementById('comision_actividad_1_total').innerText = dataResume ? dataResume.comision_actividad_1_total : '';
            document.getElementById('comision_actividad_2_total').innerText = dataResume ? dataResume.comision_actividad_2_total : '';
            document.getElementById('comision_actividad_3_total').innerText = dataResume ? dataResume.comision_actividad_3_total : '';
            document.getElementById('total_puntaje').innerText = dataResume ? dataResume.total_puntaje : '';
            document.getElementById('minima_calidad').innerText = dataResume ? dataResume.minima_calidad : '';
            document.getElementById('minima_total').innerText = dataResume ? dataResume.minima_total : '';

            document.getElementById('evaluator_name').innerText = dataSignature ? dataSignature.evaluator_name : '';
            document.getElementById('signature_path').src = dataSignature ? '/storage/' + dataSignature.signature_path : '';
           


        }

    
</script>

</html>

