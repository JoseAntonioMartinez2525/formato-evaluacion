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
.table th, .table td {
    text-align: center;
    vertical-align: middle;
}

#formName, #numColumns, #numRows{
    width: 300px;
}

#actividadPrincipal{
    width: 380px;
}

#puntajeAEvaluar, #puntajeComision{
    width: 150px;
    background-color: transparent;
    font-weight: bold;
}

#puntajeAEvaluar,{
    color: #ffff;

}


    </style>

</head>

<body class="font-sans antialiased">
    <x-general-header />
    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            @if (Route::has('login'))
                                @if (Auth::check() && Auth::user()->user_type === '')
                                    <section role="region" aria-label="Response form">
                                        <form>
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
                                                    <a class="nav-link active enlaceSN" style="width: 200px;" href="{{route('rules')}}">Artículo
                                                        10
                                                        REGLAMENTO
                                                        PEDPD</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active enlaceSN" style="width: 200px;"
                                                        href="{{route('resumen_comision')}}">Resumen (A ser
                                                        llenado por la Comisión del PEDPD)</a>
                                                </li><br>
                                            </nav>
                                        </form>
                                @endif
                                </section>

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
                                    <button type="button" class="btn custom-btn" onclick="habilitarEdicion('puntajeMaximo')">Editar</button>
                                    <button type="button" class="btn custom-btn" onclick="guardarEdicion('puntajeMaximo')">Guardar</button>
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

                                <button type="button" class="btn btn-primary" onclick="generateTable()">Generar Tabla</button>
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
                                        <td><input type="text" id="actividadPrincipal" placeholder="Ingrese la actividad principal"></td>
                                        <td style="background-color: #0b5967; color: #ffff;"><span id="puntajeAEvaluar">0</span></td>

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
        // Función para actualizar el objeto data con los valores de los campos del formulario
        function actualizarData() {
            data[this.id] = this.value;
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

            // Actualiza el puntaje máximo dinámicamente
            function actualizarPuntajeMaximo(valor) {
                puntajeMaximoGlobal = valor;
                console.log('Puntaje máximo actualizado:', puntajeMaximoGlobal);
            }

    // Genera los subencabezados dinámicamente
    function generateSubheaders(numColumns) {
        const subheader = document.createElement('tr');
        subheader.classList.add('subheader');

        // Celda vacía bajo "Actividad Principal"
        subheader.innerHTML = `<th colspan="${numColumns}" id="encabezado_actividad_principal"><input placeholder="Nombre de Apartado"></th></tr>`;

        // Generar subencabezados dinámicos
        for (let i = 0; i < numColumns; i++) {
            subheader.innerHTML += `<td id="encabezado_${i + 1}"><input placeholder="Subencabezado ${i + 1}"></td>`;

        }



        return subheader;
    }
           function generateTable() {
                const numColumns = parseInt(document.getElementById('numColumns').value) || 0;
                const numRows = parseInt(document.getElementById('numRows').value) || 0;
                const tableBody = document.getElementById('dynamicTable').querySelector('tbody');
                
               tableBody.innerHtml = '';
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
            <td><input type="text" name="observation[]"></td>
        `;

                    puntajesRow.insertAdjacentElement('afterend', row);
                }
            }

            function guardarTabla() {
                const formName = document.getElementById('formName').value;
                const puntajeMaximo = document.getElementById('puntajeMaximo').value;
                const tableData = [];

                // Recolecta datos de la tabla
                const rows = document.querySelectorAll('#dynamicTable tbody tr');
                rows.forEach((row) => {
                    const rowData = Array.from(row.querySelectorAll('input')).map((input) => input.value);
                    tableData.push(rowData);
                });
                // Prepara los datos para enviar
                const formData = {
                    form_name: formName,
                    puntaje_maximo: puntajeMaximo,
                    table_data: tableData,
                    user_id: document.querySelector('input[name="user_id"]').value,
                    email: document.querySelector('input[name="email"]').value,
                    user_type: document.querySelector('input[name="user_type"]').value,
                };

                // Enviar datos al servidor
                fetch('/dynamic-form/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify(formData),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert('Formulario guardado exitosamente.');
                        } else {
                            alert('Error al guardar el formulario.');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('Error al guardar el formulario.');
                    });

                console.log({
                    formName,
                    puntajeMaximo,
                    tableData,
                });

                alert('Formulario guardado exitosamente.');


            }

            function loadFormData(userId) {
                    fetch(`/dynamic-form/${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const form = data.form;

                                // Rellenar los datos del formulario
                                document.getElementById('formName').value = form.form_name;
                                document.getElementById('puntajeMaximo').value = form.puntaje_maximo;

                                // Recuperar y generar la tabla
                                const tableData = JSON.parse(form.table_data);
                                const tableBody = document.getElementById('dynamicTable').querySelector('tbody');
                                tableBody.innerHTML = ''; // Limpiar tabla actual

                                tableData.forEach((rowData) => {
                                    const row = document.createElement('tr');

                                    // Crear celdas con los datos de la tabla
                                    row.innerHTML = `
                        <td><input type="text" value="${rowData[0]}" disabled></td>
                        <td><input type="text" value="${rowData[1]}" disabled></td>
                        <td><input type="number" value="${rowData[2]}" disabled></td>
                        <td><input type="number" value="${rowData[3]}" disabled></td>
                        <td><input type="text" value="${rowData[4]}" disabled></td>
                    `;

                                    tableBody.appendChild(row);
                                });
                            } else {
                                alert('Formulario no encontrado.');
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            alert('Error al cargar el formulario.');
                        });
                }


    </script>

</body>

</html>