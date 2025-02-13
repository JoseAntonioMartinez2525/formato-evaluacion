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
    </style>
</head>

<body class="font-sans antialiased">
    <x-general-header />
    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
@if (Route::has('login'))
                    @if (Auth::check() && Auth::user()->user_type === '')
                    <x-rutas-secretaria/>
                    @endif
                            <div class="container mt-4">
                                <h3>Editar/Eliminar Formulario</h3>

                            <form id="editDeleteForm" method="POST" action="{{ route('form.update', $form->id) }}">
                            @csrf
                                @method('PUT')


                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                    <input type="hidden" name="user_type" value="{{ auth()->user()->user_type }}">
                                   <!--<input type="hidden" name="form_id" value="{{ $form->id }}"> -->


                                   <!--cambiar el input por un select option, con todos los formularios de la base de datos-->

                <label for="formSelect">Seleccionar Formulario:</label>
        <select id="formSelect">
            <option value="">Selecciona un formulario</option>
            @foreach($forms as $form)
                <option value="{{ $form->form_name }}">{{ $form->form_name }}</option>
            @endforeach
        </select>
                </select> <br>
            <div id="formContainer">
                <!-- Here the form fields will be dynamically populated -->
            </div>
                <!--Las columnas, valores, el puntaje_maximo deben de aparecer con celdas vacias y no ya con celdas pobladas-->

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                        <button type="button" class="btn btn-danger" onclick="deleteForm({{ $form->id }})">Eliminar Formulario</button>
                                    </div>
                                </form>
@endif
                <script>
                    const formSelect = document.getElementById('formSelect');
                        console.log('Dropdown Options:', Array.from(formSelect.options).map(option => option.value)); // Log the dropdown options

 formSelect.addEventListener('change', function () {

        const selectedForm = this.value;
        const formContainer = document.getElementById('formContainer');

            console.log('Selected Form Type:', selectedForm); // Log the selected form type

        if (selectedForm) {
            fetch(`/get-form-data/${selectedForm}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Returned Data:', data);
                    if (data.success) {
                        // Clear existing fields
                        formContainer.style.marginBottom = "1rem";
                        formContainer.innerHTML = '';

                        // Populate columns
                        data.columns.forEach(column => {
                            console.log('Column Data:', column); // Log each column data

                            formContainer.innerHTML += `
                            <label for="column_name_${column.id}">Nombre de la Columna:</label>
                            <input type="text" id="column_name_${column.id}" name="columns[${column.id}]" value="${column.value}" style="margin-bottom: 1rem;" required><br>
                        `;
                        });

                        // Populate values
                        data.values.forEach(value => {
                            formContainer.innerHTML += `
                            <label for="value_${value.id}">Valor:</label>
                            <input type="text" id="value_${value.id}" name="value[]" value="${value.value}" style="margin-bottom: 1rem;" required><br>
                        `;
                        });

                         // Set the maximum score
                        formContainer.innerHTML += `
                        <label for="puntajeMaximo">Puntaje Máximo:</label>
                        <input type="number" id="puntajeMaximo" name="puntajeMaximo" value="${data.puntaje_maximo}" style="margin-bottom: 1rem;" required>
                    `;

                    } else {
                        alert('Error fetching form data.');
                    }
                })
                .catch(error => console.error('Error fetching form data:', error));
        } else {
            formContainer.innerHTML = ''; // Clear the container if no form is selected
        }
    });                   
                    
    function deleteForm(formId) {
                        if (confirm('¿Estás seguro de que deseas eliminar este formulario?')) {
                            fetch(`/dynamic-form/${formId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    alert('Formulario eliminado exitosamente.');
                                    window.location.href = '{{ route('secretaria') }}';
                                } else {
                                    alert('Error al eliminar el formulario.');
                                }
                            });
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</body>
</html>
