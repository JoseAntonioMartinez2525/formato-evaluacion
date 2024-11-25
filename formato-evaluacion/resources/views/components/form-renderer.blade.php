@props(['forms'])

@foreach ($forms as $form)
    @for ($page = $form['startPage']; $page <= $form['endPage']; $page++)
        <div>
            {{-- Mostrar los números de página en la vista actual --}}
            <p>Página {{ $page }} de {{ $form['endPage'] }}</p>
        </div>
    @endfor
@endforeach