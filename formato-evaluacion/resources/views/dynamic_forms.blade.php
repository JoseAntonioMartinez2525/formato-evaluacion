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
    <title>Añadir nuevo Formulario</title>

    <x-head-resources />
    <style>
        @media print {
            .footer-number::after {
                content: "1";
            }
        }

        .table input {
            width: 100%;
            box-sizing: border-box;
            padding: 5px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        #formName,
        #numColumns,
        #numRows {
            width: 300px;
        }

        #actividadPrincipal {
            width: 380px;
        }

        #puntajeAEvaluar,
        #puntajeComision {
            width: 150px;
            background-color: transparent;
            font-weight: bold;
        }

        #puntajeAEvaluar,
        {
        color: #ffff;

        }

         body.dark-mode .btn-success{
            background-color:rgb(56, 163, 79);
         }

         body.dark-mode .btn-danger{
            background-color:rgb(218, 65, 81);
         }
    </style>

</head>

<body class="font-sans antialiased">
    <x-general-header />
    <button id="toggle-dark-mode" class="btn btn-secondary printButtonClass"><i class="fa-solid fa-moon"></i>&nbspModo Obscuro</button>

    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            @if (Route::has('login'))
                @if (Auth::check() && Auth::user()->user_type === '')
                    <x-nav-menu :user="Auth::user()">
                        <div>
                            <ul style="list-style: none;"">
                                <li class="nav-item">
                                    <a class="nav-link active enlaceSN" style="width: 300px;" href="{{route('edit_delete_form')}}"
                                        title="Editar ó eliminar formulario"><i class="fa-solid fa-user-pen"></i>&nbspEditar/Eliminar</a>
                                </li>
                            </ul>
                        </div>
                    </x-nav-menu>
                @endif

                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2"></div>

                    <nav class="-mx-3 flex flex-1 justify-end"></nav>

@php
    $user = Auth::user();
    $userType = $user->user_type;
    $user_identity = $user->id; 
@endphp



    <!--Llenado de los campos-->
    <div class="container mt-4">
        <!-- Título -->
        <h3>Generador de Formulario Dinámico</h3>

        <!-- Nombre del formulario -->
        <form id="dynamicForm" method="POST">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
            <input type="hidden" name="user_type" value="{{ auth()->user()->user_type }}">
            @csrf
            <label for="formName">Nombre del formulario:</label>
            <input type="text" id="formName" placeholder="Ingrese el nombre del formulario">

            <!-- Puntaje máximo -->
            <div class="mt-3">
                <h4>Puntaje máximo</h4>
                @if($userType == '') <!-- usuario secretaria -->
                    <input class="pmax text-white px-4 mt-3" id="puntajeMaximo" placeholder="0" readonly>
                    <button type="button" class="btn custom-btn"
                        onclick="habilitarEdicion('puntajeMaximo')">Editar</button>
                    <button type="button" class="btn custom-btn"
                        onclick="guardarEdicion('puntajeMaximo')">Guardar</button>
                @else
                    <span id="puntajeMaximoLabel"></span>
                @endif
            </div>

            <!-- Configuración dinámica -->
            <div class="mt-4">
                <h5>Configuración de la tabla</h5>
                <label for="numColumns">Número de columnas:</label>
                <input type="number" id="numColumns" min="1" placeholder="Ingrese el número de columnas">

                <label for="numRows">Número de filas:</label>
                <input type="number" id="numRows" min="1" placeholder="Ingrese el número de filas">

                <button type="button" class="btn btn-primary" onclick="generateTable()">Generar
                    Tabla</button>
            </div>

            <!-- Tabla dinámica -->
            <table id="dynamicTable" class="table mt-4">
                <thead>
                    <tr id="defaultHeader">
                        <th>Actividad</th>
                        <th>Puntaje a evaluar</th>
                        <th>Puntaje de la Comisión Dictaminadora</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="actividadPrincipal"
                                placeholder="Ingrese la actividad principal"></td>
                        <td style="background-color: #0b5967; color: #ffff;"><span
                                id="puntajeAEvaluar">0</span></td>

                        <td style="background-color: #ffcc6d"><span id="puntajeComision">0</span></td>
                    </tr>
                    <tr class="puntajes"><!-- Las filas dinámicas serán insertadas aquí --></tr>


                </tbody>
            </table>

            <!-- Botones de acción -->
            <div class="mt-4">
                <button type="button" class="btn btn-success" onclick="guardarTabla()">Guardar</button>
                <button type="reset" class="btn btn-danger">Eliminar</button>
            </div>
        </form>
    </div>


    @endif
</div>
</main>


</div>
</div>
</div>

<script>
    const tableData = [];


    function handleClick(event) {
        var currentTarget = event.currentTarget;
        // Use the event data here. 
        console.log('Button clicked: ' + currentTarget.getAttribute('data-id'));
    } document.addEventListener('DOMContentLoaded', onload);
    function onChange() {
        // Obtener los valores de los inputs
        const puntajePosgrado = parseFloat(document.getElementById("horasPosgrado").value);
        const puntajeSemestre = parseFloat(document.getElementById("horasSemestre").value);
        const h = parseFloat(document.querySelector('#hoursText'));

        // Realizar los cálculos
        const dsePosgrado = puntajePosgrado * 8.5;
        const dseSemestre = puntajeSemestre * 8.5;
        const hora = (dsePosgrado + dseSemestre);

        // Actualizar el contenido de las etiquetas <label>
        document.getElementById("DSE").innerText = dsePosgrado;
        document.getElementById("DSE2").innerText = dseSemestre;

        // Mostrar los valores actualizados en la consola
        console.log(dsePosgrado);
        console.log(dseSemestre);

        const minimo = minWithSum(dsePosgrado, dseSemestre);

        document.getElementById("hoursText").innerText = minimo;
        console.log(minimo);


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
        const toggleDarkModeButton = document.getElementById('toggle-dark-mode');
        if (toggleDarkModeButton) {
            const widthDarkButton = window.outerWidth - 230;
            toggleDarkModeButton.style.marginLeft = `${widthDarkButton}px`;
        }
        toggleDarkMode();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        async function submitForm(url, formId) {
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
            switch (formId) {
                case 'form1':
                    formData['convocatoria'] = form.querySelector('input[name="convocatoria"]').value;
                    formData['periodo'] = form.querySelector('input[name="periodo"]').value;
                    formData['nombre'] = form.querySelector('input[name="nombre"]').value;
                    formData['area'] = form.querySelector('select[name="area"]').selectedOptions[0].textContent;
                    formData['departamento'] = form.querySelector('select[name="departamento"]').selectedOptions[0].textContent;
                    break;

                case 'form2':
                    formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                    formData['email'] = form.querySelector('input[name="email"]').value;
                    formData['horasActv2'] = form.querySelector('input[name="horasActv2"]').value;
                    formData['puntajeEvaluar'] = form.querySelector('input[name="puntajeEvaluar"]').value;
                    //formData['comision1'] = form.querySelector('input[name="comision1"]').value;
                    formData['obs1'] = form.querySelector('input[name="obs1"]').value;
                    break;

                case 'form2_2':
                    formData['user_id'] = form.querySelector('input[name="user_id"]').value;
                    formData['email'] = form.querySelector('input[name="email"]').value;
                    let hoursLabel = form.querySelector('label[id="hoursText"]');
                    //let actv2ComisionLabel = form.querySelector('td[id="actv2Comision"]');

                    if (!hoursLabel) {
                        console.error('Label with id "hoursText" not found.');
                    } else {
                        formData['hours'] = hoursLabel.innerText;
                    }



                    formData['obs2'] = form.querySelector('input[name="obs2"]').value;
                    formData['obs2_2'] = form.querySelector('input[name="obs2_2"]').value;
                    break;

            }
            console.log('Form data:', formData);


            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });

                let responseText = await response.text(); // Obtener el texto de la respuesta
                console.log('Raw response from server:', responseText);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                let data = JSON.parse(responseText);
                console.log('Response received from server:', data);
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        window.submitForm = submitForm;
        
    });


    // Función para actualizar el label en el footer con la convocatoria y periodo de evaluación
    function actualizarLabelConvocatoriaPeriodo(convocatoria, periodo) {
        const label = document.getElementById('convocatoriaPeriodoLabel');
        label.textContent = `Convocatoria: ${convocatoria}, Período: ${periodo}`;
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
    document.getElementById('formSelect').addEventListener('change', (event) => {
        const selectedForm = event.target.value;
        const formContainer = document.getElementById('formContainer');

        if (selectedForm) {
            window.location.href = `/${selectedForm}`;
            axios.get(`/get-form-content/${selectedForm}`)
                .then(response => {
                    formContainer.innerHTML = response.data;
                })
                .catch(error => {
                    console.error('Error fetching form content:', error);
                    formContainer.innerHTML = '<p style="margin-left: 120px;">Cargando formulario.....</p>';
                });
        } else {

            formContainer.innerHTML = '';
        }
    });

    let puntajeMaximoGlobal = 40; // Estado global inicial

    // Habilita la edición del input
    function habilitarEdicion(id) {
        const input = document.getElementById(id);
        input.removeAttribute('readonly');
        input.focus();
    }

    // Guarda el valor editado y bloquea el campo
    function guardarEdicion(id) {
        /*const elemento = document.getElementById(id);
        elemento.setAttribute('readonly', true);*/
        const input = document.getElementById(id);
        input.setAttribute('readonly', true);
        input.style.backgroundColor = '#353e4e';
        // Fondo deshabilitado
        /*
        const puntajeMaximo = elemento.value;
        elemento.style.backgroundColor = '#353e4e'; 

        // Enviar el puntaje máximo al backend
        // Enviar el puntaje máximo al backend
        fetch('/update-puntaje-maximo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ puntajeMaximo }) // Usa el valor actualizado
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.message);
                puntajeMaximoGlobal = puntajeMaximo; // Actualiza el valor global
                alert('El puntaje máximo ha sido actualizado: ' + puntajeMaximoGlobal);
            })
            .catch(error => {
                console.error('Error al actualizar el puntaje máximo:', error);
                alert('Hubo un error al actualizar el puntaje máximo.');
            });*/
    }
    /*
                // Actualiza el puntaje máximo dinámicamente
                function actualizarPuntajeMaximo(valor) {
                    puntajeMaximoGlobal = valor;
                    console.log('Puntaje máximo actualizado:', puntajeMaximoGlobal);
                }
    */
    // Genera los subencabezados dinámicamente
    function generateSubheaders(numColumns) {
        const subheader = document.createElement('tr');
        subheader.classList.add('subheader');

        // Celda vacía bajo "Actividad Principal"
        subheader.innerHTML = `<td colspan="${numColumns}" id="encabezado_actividad_principal" data-column-name="main_section"><input placeholder="Nombre de Apartado"></td>`;

        // Generar subencabezados dinámicos
        for (let i = 0; i < numColumns; i++) {
            subheader.innerHTML += `<td id="encabezado_${i + 1}"><input placeholder="Subencabezado ${i + 1}" data-column-name="subheader_${i + 1}"></td>`;


        }



        return subheader;
    }
    function generateTable() {
        const numColumns = parseInt(document.getElementById('numColumns').value) || 0;
        const numRows = parseInt(document.getElementById('numRows').value) || 0;
        const tableBody = document.getElementById('dynamicTable').querySelector('tbody');

        // Limpia filas anteriores

        const puntajesRow = tableBody.querySelector('tr.puntajes');
        puntajesRow.innerHTML = '';

        // Elimina subencabezados existentes si los hay
        const subheaderRow = tableBody.querySelector('tr.subheader');
        if (subheaderRow) subheaderRow.remove();


        // Inserta los subencabezados antes de las filas dinámicas
        const subheader = generateSubheaders(numColumns);
        puntajesRow.insertAdjacentElement('beforebegin', subheader);

        // Genera filas y columnas dinámicamente
        for (let i = 0; i < numRows; i++) {
            const row = document.createElement('tr');

            // Primera columna: Nombre de la actividad
            const activityCell = document.createElement('td');
            activityCell.innerHTML = `<input type="text" placeholder="Nombre de la actividad">`;
            row.appendChild(activityCell);

            // Columnas dinámicas
            for (let j = 0; j < numColumns; j++) {
                const col = document.createElement('td');
                col.innerHTML = `<input type="text" placeholder="Valor">`;
                row.appendChild(col);
            }

            // Puntaje, comisión y observaciones
            row.innerHTML += `
        <td><input type="number" name="score[]" value="0"></td>
        <td><input type="number" name="commission_score[]" value="0"></td>
        <td><input type="text" name="observation[]" value=""></td> <!-- Set default value to empty string -->
    `;

            puntajesRow.insertAdjacentElement('afterend', row);
        }
    }

    function updateSubheaderId(input, id) {
        const subheaderCell = document.getElementById(id);
        if (subheaderCell) {
            subheaderCell.id = input.value || id; // Update ID based on input value
        }
    }

    async function guardarTabla() {
        try {
            const formName = document.getElementById('formName').value;
            const puntajeMaximo = document.getElementById('puntajeMaximo').value;
                    // Extract the numeric part from formName
            const formTypeMatch = formName.match(/^([\d.]+(_[\d.]+)*)?(?=\s|$)/); // Matches the numeric part with dots
            const formType = formTypeMatch ? 'form' + formTypeMatch[0] : 'form'; // Construct formType

            
            const rows = document.querySelectorAll('#dynamicTable tbody tr');
            tableData.length = 0;
            rows.forEach((row) => {
                const rowData = Array.from(row.querySelectorAll('input')).map((input) => input.value);
                tableData.push(rowData);
            });

            // Declare and initialize columnNames
            const columnNames = Array.from(document.querySelectorAll('#dynamicTable .subheader input')).map(input => input.value);

            const formData = {
                form_name: formName,
                form_type: formType, // Add this line
                puntaje_maximo: puntajeMaximo,
                table_data: tableData,
                column_names: columnNames, // Include column names
                user_id: document.querySelector('input[name="user_id"]').value,
                email: document.querySelector('input[name="email"]').value,
                user_type: document.querySelector('input[name="user_type"]').value,
            };

            const response = await fetch('/dynamic-form/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(formData),
            });

            if (!response.ok) {
                const errorData = await response.json();
                const errorMessage = errorData.message || 'Error al guardar el formulario.';
                throw new Error(errorMessage);
            }

            const data = await response.json();

            if (data.success) {
                alert('Formulario guardado exitosamente.');

                console.log({
                    formName,
                    puntajeMaximo,
                    tableData,
                });

                window.location.href = `{{ route('secretaria') }}?formType=${formType}&formName=${encodeURIComponent(formName)}`;
            } else {
                alert('Error al guardar el formulario.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(`Error al guardar el formulario: ${error.message}`);
        }
    }
    
</script>

</body>

</html>
