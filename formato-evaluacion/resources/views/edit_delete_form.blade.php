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
</head>

<body class="font-sans antialiased">
    <x-general-header />
    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <div class="container mt-4">
                <h3>Editar/Eliminar Formulario</h3>
<form id="editDeleteForm" method="POST" action="{{ route('dynamic-form.update', [$form->id, $column->id]) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

    <label for="formSelect">Seleccionar Formulario:</label>
    <select id="formSelect" name="formId" onchange="updateColumns(this.value)">
        @foreach($forms as $form)
            <option value="{{ $form->id }}">{{ $form->form_name }}</option>
        @endforeach
    </select>

    <label for="columnSelect">Seleccionar Columna:</label>
    <select id="columnSelect" name="columnId">
        <!-- Options will be populated based on the selected form -->
    </select>

    <div class="mt-4">
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <button type="button" class="btn btn-danger" onclick="deleteForm()">Eliminar Formulario</button>
    </div>
</form>

    <script>
    function updateColumns(formId) {
        // Fetch columns based on the selected form ID
        fetch(`/dynamic-form/columns/${formId}`)
            .then(response => response.json())
            .then(data => {
                const columnSelect = document.getElementById('columnSelect');
                columnSelect.innerHTML = ''; // Clear existing options
                data.columns.forEach(column => {
                    const option = document.createElement('option');
                    option.value = column.id;
                    option.textContent = column.column_name;
                    columnSelect.appendChild(option);
                }); 
            });
    }        
        function deleteForm(formId, columnId) {
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
</body>

</html>