<tr class="table-wrap">
    <td>{{ $inciso }}</td>
    <td>{{ $actividad }}</td>
    <td></td>
    <td>{{ $nivel }}</td>
    <td><b>{{ $puntaje }}</b></td>
    <td class="form3_19_dark"></td>
    <td></td>
    <td class="subtotal"></td>
    <td>
        @if ($userType == 'dictaminador')
            <input type="number" step="0.01" class="comision" name="{{ $comisionName }}"
                value="{{ oldValueOrDefault($comisionName) }}" oninput="onActv3Comision3_19()">
        @else
            <span class="comision form3_19_dark"></span>
        @endif
    </td>
    <td>
        @if ($userType == 'dictaminador')
            <input class="table-header" type="text" name="{{ $obsName }}">
        @else
            <span class="form3_19_dark"></span>
        @endif
    </td>
</tr>