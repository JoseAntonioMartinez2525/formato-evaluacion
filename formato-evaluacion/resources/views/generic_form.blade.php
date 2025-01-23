@extends('layouts.app')

@section('content')
<div id="formContainer">
    <h2>{{ $formTitle }}</h2>
    <form id="dynamicForm" method="POST" action="{{ route('store.dynamic.form') }}">
        @csrf
        @foreach($formFields as $field)
            <div class="form-group">
                <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                    id="{{ $field['name'] }}" value="{{ $field['value'] }}">
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection