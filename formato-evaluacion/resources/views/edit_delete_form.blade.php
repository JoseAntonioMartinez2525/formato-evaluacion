@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
$existingFormNames = [];
@endphp
<!DOCTYPE html>
<html lang="{{ $newLocale }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar/Eliminar Formulario</title>
    <x-head-resources />
    <link href="{{ asset('css/edit_delete_form.css') }}" rel="stylesheet">
    <style>
        #formSelect{
            margin-bottom: 1rem;
        }
        body.dark-mode .btn-success{
            background-color:rgb(56, 163, 79);
         }

         body.dark-mode .btn-danger{
            background-color:rgb(218, 65, 81);
         }
         
        /* Estilos para las pestañas */
        .tab-container {
            display: flex;
            width: 100%;
            height: 45px;
            margin-top: 0; /* Eliminar margen superior */
        }
        
        .tab-button {
            flex: 1;
            text-align: center;
            padding: 12px 200px 50px 200px;
            font-weight: bold;
            text-decoration: none;
            color: #555;
            background-color:rgb(192, 206, 221);
            text-transform: uppercase;
            font-size: 14px;
            border-radius: 0.5rem;
            margin: 0 3px;
            transition: all 0.2s ease;
            
        }
        
        .tab-button.active {
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            
        }
        
        /* Contenido principal */
        .main-content {
            margin-left: 200px; /* Espacio para el menú lateral */
            padding: 20px;
        }
        
        /* Botón de modo oscuro */
        .dark-mode-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-general-header />
    
    <!-- Botón de modo oscuro (fuera del flujo normal) -->
    <button id="toggle-dark-mode" class="btn btn-secondary printButtonClass dark-mode-button">
        <i class="fa-solid fa-moon"></i>&nbspModo Obscuro
</button>
    
    <div class="bg-gray-50 text-black/50">
        <div class="d-flex">
            @if (Route::has('login'))
                @if (Auth::check() && Auth::user()->user_type === '')
                    <!-- Componente de menú de navegación -->
                    <x-nav-menu :user="Auth::user()">
                        <div>
                            <ul style="list-style: none;">
                                <li class="nav-item">
                                    <a class="nav-link active enlaceSN" style="width: 300px;" 
                                       href="{{route('dynamic_forms')}}"
                                       title="Ingresar nuevo formulario">
                                       <i class="fa-solid fa-folder-plus"></i>&nbspIngresar nuevo
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </x-nav-menu>
                @endif

                <!-- Sección principal del contenido -->
                <div class="main-content">
                    <!-- Pestañas de navegación -->
                    <div class="tab-container">
                        <a href="{{ route('edit_delete_form') }}" class="tab-button">EDITAR/ELIMINAR FORMULARIO</a>
                        <a href="{{ route('dynamic_forms') }}" class="tab-button  active">AÑADIR NUEVO FORMULARIO</a>
                    </div>

                    <!-- Contenido del formulario -->
                    <div class="mt-4">
                        <h3>Editar/Eliminar Formulario</h3>

                        <form id="editDeleteForm" method="POST">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="user_type" value="{{ auth()->user()->user_type }}">
                            <input type="hidden" name="form_id" id="form_id">

                            <div class="form-group">
                                <label for="formSelect">Seleccionar Formulario:</label>
                                <select id="formSelect" name="form_name">
                                    <option value="">Selecciona un formulario</option>
                                    @foreach($forms as $form)
                                        <option value="{{ $form->form_name }}" data-id="{{ $form->id }}">{{ $form->form_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="dynamicTableContainer">
                                <!-- Table will be loaded here -->
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success" id="updateBtn">Guardar Cambios</button>
                                <button type="button" class="btn btn-danger" id="deleteBtn" onclick="deleteForm()">Eliminar Formulario</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

<script>
    const formSelect = document.getElementById('formSelect');
    console.log('Dropdown Options:', Array.from(formSelect.options).map(option => option.value)); // Log the dropdown options

    formSelect.addEventListener('change', function () {

        const selectedOption = this.options[this.selectedIndex];
        const selectedForm = selectedOption.getAttribute('value');
        const selectedFormId = selectedOption.getAttribute('data-id');

        document.getElementById('form_id').value = selectedFormId;
        document.getElementById('editDeleteForm').action = `/forms/${selectedFormId}`;

        const dynamicTableContainer = document.getElementById('dynamicTableContainer');

        console.log('Selected Form Type:', selectedForm); // Log the selected form type

        // Add these logs
        console.log('Selected Form ID:', selectedFormId);
        console.log('Form Action Before:', document.getElementById('editDeleteForm').action);

        document.getElementById('form_id').value = selectedFormId;
        document.getElementById('editDeleteForm').action = `/forms/${selectedFormId}`;

        // Add this log
        console.log('Form Action After:', document.getElementById('editDeleteForm').action);


        if (selectedForm) {
            fetch(`/get-form-data/${selectedForm}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Returned Data:', data);
                    console.log('Columns:', data.columns); // Log the columns
                    console.log('Values:', data.values); // Log the values
                    console.log('Puntaje máximo:', data.puntaje_maximo);
                    console.log('Acreditación:', data.acreditacion); // Log the acreditación
                    if (data.success) {

                        dynamicTableContainer.innerHTML = '';
                        // Mostrar el puntaje máximo en la parte superior con fondo negro
                        let tableHTML = `<div style="margin-bottom: 10px;"><strong>Puntaje máximo</strong> <input style="background-color: #000; color: #fff; padding: 2px 10px;" placeholder="${data.puntaje_maximo}"></input></div>`;

                        // Crear la tabla
                        tableHTML += '<table class="table table-bordered">';

                        // Encabezados principales
                        tableHTML += '<thead><tr>';
                        tableHTML += '<th>Actividad</th>';

                        // Agregar los nombres de las columnas dinámicas
                        const columnNames = data.columns.map(column => column.column_name);
                        // Filtrar solo subencabezados dinámicos (excluyendo los fijos)
                        const fixedHeaders = ['Actividad', 'Puntaje a evaluar', 'Puntaje de la Comisión Dictaminadora', 'Observaciones'];
                        const dynamicColumnNames = data.columns
                            .map(column => column.column_name)
                            .filter(name => !fixedHeaders.includes(name));
                        // Agregar solo las columnas dinámicas (subencabezados)
                        dynamicColumnNames.forEach(columnName => {
                            tableHTML += `<th><input value="${columnName}" readonly /></th>`;
                        });


                        tableHTML += '<th>Puntaje a evaluar</th>';
                        tableHTML += '<th>Puntaje de la Comisión Dictaminadora</th>';
                        tableHTML += '<th>Observaciones</th>';
                        tableHTML += '</tr></thead><tbody>';

                        // Agrupar valores por columna
                        const valuesByColumn = {};
                        data.columns.forEach(column => {
                            valuesByColumn[column.id] = data.values.filter(value => 
                                value.dynamic_form_column_id === column.id
                            );
                        });

                        // Obtener los IDs de las columnas
                        const columnIds = Object.keys(valuesByColumn);

                        // Obtener todos los valores como un array plano para filtrar después
                        const allValues = data.values.map(item => item.value);

                        // Primera fila: formName y valores
                        tableHTML += '<tr>';
                        tableHTML += `<td><input value="${selectedForm}" readonly /></td>`; // formName en la primera columna

                        // Agregar celdas para cada columna dinámica
                        //(subencabezados)
                        dynamicColumnNames.forEach(columnName => {
                            // Buscar el ID de columna para este nombre
                            const column = data.columns.find(c => c.column_name === columnName);
                            if (column) {
                                const columnId = column.id;
                                const columnValues = valuesByColumn[columnId] || [];
                                const columnValue = columnValues.length > 0 ? columnValues[0].value : '';
                                tableHTML += `<td><input value="${columnValue}"></input></td>`;
                            } else {
                                tableHTML += '<td><input value=""></input></td>';
                            }
                        });

                        // Celdas para puntaje a evaluar y comisión con estilos
                        tableHTML += '<td style="background-color: #0b5967; color: #ffff;">0</td>';
                        tableHTML += '<td style="background-color: #ffcc6d;">0</td>';
                        // Observaciones 
                        tableHTML += '<td><input value="comentarios"></td>';
                         
                        tableHTML += '</tr>';

                        // Segunda fila: valor dinámico (que no sea formName, nombre de columna, ni número)
                        // Encontrar un valor que no sea el nombre del formulario, ni nombre de columna, ni puntaje_maximo, ni un número
                        let secondRowValue = '';

                        for (let i = 0; i < data.values.length; i++) {
                            const value = data.values[i].value;

                            if (
                                value !== selectedForm && // No es el nombre del formulario
                                !columnNames.includes(value) && // No es un nombre de columna
                                value !== data.puntaje_maximo && // No es el puntaje máximo
                                value.trim() !== '' // No es una cadena vacía
                            ) {
                                secondRowValue = value;
                                break;
                            }
                        }

                        // Si no encontramos un valor adecuado, usar un valor predeterminado
                        if (!secondRowValue) {
                            secondRowValue = 'Valor adicional';
                        }

                        tableHTML += '<tr>';
                        tableHTML += `<td><input value="${secondRowValue}"></input></td>`;

                        // Celdas para cada columna dinámica
                        dynamicColumnNames.forEach(() => {
                            tableHTML += '<td><input value=""></input></td>';
                        });

                        // Celdas para puntaje y observaciones (ahora correctamente alineadas)
                        tableHTML += '<td><input value="0"></td>';
                        tableHTML += '<td><input value="0"></td>';
                        tableHTML += '<td><input value="comentarios"></td>';
                        tableHTML += '</tr>';

                        // Tercera fila: Acreditación
                        tableHTML += '<tr>';
                        tableHTML += '<td>Acreditación:</td>';

                        // Calcular el número de columnas (incluye las dinámicas + las fijas)
                        const totalColumnSpan = dynamicColumnNames.length + 3; // 3 = columnas fijas (Puntaje a evaluar, Comisión, Observaciones)
                        tableHTML += `<td colspan="${totalColumnSpan}">`;
                        tableHTML += `<input id="acreditacion" type="text" value="${data.acreditacion || ''}" placeholder="Información sobre acreditación" class="form-control">`;
                        tableHTML += '</td>';
                        tableHTML += '</tr>';

                        tableHTML += '</tbody></table>';

                        // Agregar la tabla al contenedor
                        dynamicTableContainer.innerHTML = tableHTML;

                        // Añadir el campo para editar el puntaje máximo
                        dynamicTableContainer.innerHTML += `
    `;
                    } else {
                        alert('Error fetching form data.');
                    }
                })
                .catch(error => console.error('Error fetching form data:', error));
        } else {
            dynamicTableContainer.innerHTML = ''; // Clear the container if no form is selected
        }
    });

    function deleteForm() {
        var formId = document.getElementById('form_id').value;
        if (!formId) {
            alert('Error: No form selected');
            return;
        }

        if (confirm('¿Está seguro de que desea eliminar este formulario?')) {
            $.ajax({
                url: `/forms/${formId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function (response) {
                    if (response.success) {
                        alert('Formulario eliminado correctamente');
                        window.location.href = "{{ route('secretaria') }}";
                    } else {
                        alert('Formulario no eliminado: ' + (response.message || 'Error desconocido'));
                    }
                },
                error: function (xhr) {
                    alert('Error al eliminar formulario: ' + (xhr.responseJSON?.message || 'Error desconocido'));
                }
            });
        }
    }
    document.getElementById("editDeleteForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission
        const formId = document.getElementById('form_id').value;
        if (!formId) {
            alert("Error: No se ha seleccionado un formulario válido.");
            return;
        }
        let formData = new FormData(this);
        console.log("Form Data:", Object.fromEntries(formData)); // Log data being sent

        // Convert FormData to JSON object
        let formDataObject = {
            _token: formData.get('_token'),
            _method: formData.get('_method'),
            user_id: formData.get('user_id'),
            email: formData.get('email'),
            user_type: formData.get('user_type'),
            form_name: formData.get('form_name'),
            puntajeMaximo: formData.get('puntajeMaximo'),
            column_name: [],
            value: []
        };
        //Process form Data
        formData.forEach((value, key) => {
            // Handle array inputs
            if (key.endsWith('[]')) {
                let arrayKey = key.slice(0, -2);
                if (!formDataObject[arrayKey]) {
                    formDataObject[arrayKey] = [];
                }
                formDataObject[arrayKey].push(value);
            } else {
                formDataObject[key] = value;
            }
        });

        const formName = formData.get('form_name');
        const isDelete = formData.get('_method').toLowerCase() === 'delete';

        // Determine the appropriate endpoint and method
        const endpoint = `/forms/${formId}`;
        const method = isDelete ? 'DELETE' : 'PUT';

        fetch(endpoint, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "X-Requested-With": "XMLHttpRequest",
                'Accept': 'application/json'
            },
            body: JSON.stringify(formDataObject)
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        console.error('Server Error:', err);
                        throw new Error(err.message || 'Server error');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log("Server Response:", data);
                if (data.success) {
                    alert('Form updated successfully');
                    window.location.reload();
                } else {
                    alert('Error updating form: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert('Error updating form: ' + error.message);
            });
    });

    document.getElementById('updateBtn').addEventListener('click', function () {
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('editDeleteForm').submit();
    });

    document.getElementById('deleteBtn').addEventListener('click', function () {
        document.getElementById('formMethod').value = 'DELETE';
        document.getElementById('editDeleteForm').submit();
    });

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