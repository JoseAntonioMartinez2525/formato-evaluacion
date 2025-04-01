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
        #formSelect {
            margin-bottom: 1rem;
        }

        body.dark-mode .btn-success {
            background-color: rgb(56, 163, 79);
        }

        body.dark-mode .btn-danger {
            background-color: rgb(218, 65, 81);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-general-header />
    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            @if (Route::has('login'))
                @if (Auth::check() && Auth::user()->user_type === '')
                    <x-nav-menu :user="Auth::user()">
                        <div>
                            <ul style="list-style: none;"">
                                            <li class=" nav-item">
                                <a class="nav-link active enlaceSN" style="width: 300px;" href="{{route('dynamic_forms')}}"
                                    title="Ingresar nuevo formulario"><i class="fa-solid fa-folder-plus"></i>&nbspIngresar
                                    nuevo</a>
                                </li>
                            </ul>
                        </div>
                    </x-nav-menu>
                @endif
                <button id="toggle-dark-mode" class="btn btn-secondary printButtonClass"><i
                        class="fa-solid fa-moon"></i>&nbspModo Obscuro</button>

                <div class="container mt-4">
                    <h3>Editar/Eliminar Formulario</h3>

                    <form id="editDeleteForm" method="POST">
                        @csrf



                        <input type="hidden" name="_method" id="formMethod">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                        <input type="hidden" name="user_type" value="{{ auth()->user()->user_type }}">
                        <input type="hidden" name="form_id" id="form_id">


                        <!--cambiar el input por un select option, con todos los formularios de la base de datos-->

                        <label for="formSelect">Seleccionar Formulario:</label>
                        <select id="formSelect" name="form_name">
                            <option value="">Selecciona un formulario</option>
                            @foreach($forms as $form)
                                <option value="{{ $form->form_name }}" data-id="{{ $form->id }}">{{ $form->form_name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <div id="dynamicTableContainer">

                        </div>
                        <!--Las columnas, valores, el puntaje_maximo deben de aparecer con celdas vacias y no ya con celdas pobladas-->

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success" id="updateBtn">Guardar Cambios</button>
                            <button type="button" class="btn btn-danger" id="deleteBtn" onclick="deleteForm()">Eliminar
                                Formulario</button>
                        </div>
                    </form>
            @endif
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
                                    if (data.success) {

                                        // Agrupar valores por columna
                                        const valuesByColumn = {};
                                        data.columns.forEach(column => {
                                            valuesByColumn[column.id] = [];
                                        });

                                        data.values.forEach(value => {
                                            if (valuesByColumn[value.dynamic_form_column_id]) {
                                                valuesByColumn[value.dynamic_form_column_id].push(value);
                                            }
                                        });

                                        // Obtener los IDs de las columnas
                                        const columnIds = Object.keys(valuesByColumn);
                                        // Mostrar el puntaje máximo en la parte superior
                                        let tableHTML = `<div style="margin-bottom: 10px;"><strong>Puntaje máximo:</strong> ${data.puntaje_maximo}</div>`;

                                        // Crear la tabla
                                        tableHTML += '<table class="table table-bordered">';

                                        // Encabezados principales
                                        tableHTML += '<thead><tr>';
                                        tableHTML += '<th>Actividad</th>';
                                        tableHTML += `<th colspan="${columnIds.length+1}"></th>`; // Espacio en blanco
                                        tableHTML += '<th>Puntaje a evaluar</th>';
                                        tableHTML += '<th>Puntaje de la Comisión Dictaminadora</th>';
                                        tableHTML += '<th>Observaciones</th>';
                                        tableHTML += '</tr></thead><tbody>';

                                    
                                        // Si hay al menos una columna
                                        if (columnIds.length > 0) {
                                            // Obtener los valores de la primera columna (Actividad)
                                            const actividadValues = valuesByColumn[columnIds[0]] || [];

                                            // Recorrer cada valor de la primera columna
                                            for (let i = 0; i < actividadValues.length; i++) {
                                                const actividadValue = actividadValues[i].value;

                                                // Crear una fila para cada valor
                                                tableHTML += '<tr>';
                                                tableHTML += `<td>${actividadValue}</td>`;
                                                // Obtener los nombres de las columnas dinámicas
                                                const columnNames = {};
                                                data.columns.forEach(column => {
                                                    columnNames[column.id] = column.column_name;
                                                    // Añadir cada nombre de columna como encabezado
                                                    if (column.column_name !== 'Actividad') {
                                                        tableHTML += `<td>${column.column_name}</td>`;
                                                    }
                                                });
                                                // Añadir valores para cada columna dinámica
                                                for (let j = 1; j < columnIds.length; j++) {
                                                    const columnId = columnIds[j];
                                                    const columnValues = valuesByColumn[columnId] || [];
                                                    const columnValue = i < columnValues.length ? columnValues[i].value : '';
                                                   
                                                    tableHTML += `<td>${columnValue}</td>`;
                                                        
                                        
                                                }

                                                // Columnas de puntaje a evaluar y comisión
                                                // Aplicar estilos solo a la primera fila
                                                if (i === 0) {
                                                    tableHTML += '<td style="background-color: #0b5967; color: #ffff;">0</td>';
                                                    tableHTML += '<td style="background-color: #ffcc6d;">0</td>';
                                                } else {
                                                    tableHTML += '<td>0</td>';
                                                    tableHTML += '<td>0</td>';
                                                }

                                                // Columna de observaciones
                                                tableHTML += '<td></td>';

                                                tableHTML += '</tr>';
                                            }
                                        }

                                        tableHTML += '</tbody></table>';

                                        // Agregar la tabla al contenedor
                                        dynamicTableContainer.innerHTML = tableHTML;

                                        // Añadir el campo para editar el puntaje máximo
                                        dynamicTableContainer.innerHTML += `
                         <div class="mt-3">
                             <label for="puntajeMaximo">Puntaje Máximo:</label>
                             <input type="number" id="puntajeMaximo" name="puntajeMaximo" value="${data.puntaje_maximo}" style="margin-bottom: 1rem;" required>
                             <input type="hidden" name="form_name" value="${selectedForm}">
                         </div>
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
            </div>
        </div>
    </div>
</body>

</html>