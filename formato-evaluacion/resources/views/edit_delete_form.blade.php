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
    <title>Editar/Eliminar Formulario</title>
    <x-head-resources />
    <link href="{{ asset('css/edit_delete_form.css') }}" rel="stylesheet">
</head>

<body class="font-sans antialiased">
    <x-general-header />
    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <div class="container mt-4">
                <h3>Editar/Eliminar Formulario</h3>

    <form id="editDeleteForm" method="POST" action="{{ route('form.update', $form->id) }}">
                    @csrf
                    

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <input type="hidden" name="user_type" value="{{ auth()->user()->user_type }}">
                    <input type="hidden" name="form_id" value="{{ $form->id }}">

                   <!--cambiar el input por un select option, con todos los formularios de la base de datos-->
                   
                    <label for="form_name">Introduce el nombre de formulario:</label>
<input type="text" id="form_name" name="form_name" value="{{ $form->form_name }}" required> <br>

<!--Las columnas, valores, el puntaje_maximo deben de aparecer con celdas vacias y no ya con celdas pobladas-->
@foreach($columns as $column)
    <label for="column_name_{{ $column->id }}">Nombre de la Columna:</label>
        <input type="text" id="column_name_{{ $column->id }}" style="margin-bottom:1rem;" name="columns[{{ $column->id }}]" value="{{ $values->firstWhere('key', $column->column_name)->value ?? '' }}" required> <br>
@endforeach 

    @foreach($values as $value)
        <label for="value_{{ $value->id }}">Valor:</label>
        <input type="text" id="value_{{ $value->id }}" style="margin-bottom:1rem;" name="value[]" value="{{ $value->value ?? '' }}" required><br>
    @endforeach

<label for="puntajeMaximo">Puntaje Máximo:</label>
<input type="number" id="puntajeMaximo" name="puntajeMaximo" value="{{ $form->puntaje_maximo }}" required>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <button type="button" class="btn btn-danger" onclick="deleteForm({{ $form->id }})">Eliminar Formulario</button>
                    </div>
                </form>

                <script>
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
