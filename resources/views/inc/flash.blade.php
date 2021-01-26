@php
    $errors = Session::get('error');
    $messages = Session::get('success');
    $info = Session::get('info');
    $warnings = Session::get('warning');
@endphp

@if($errors) @foreach($errors as $key => $value)
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Error!</strong> {{ $value }}
    </div>
@endforeach @endif

@if($messages) @foreach($messages as $key => $value)
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Success!</strong> {{ $value }}
    </div>
@endforeach @endif

@if($info) @foreach($info as $key => $value)
    <div class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Info!</strong> {{ $value }}
    </div>
@endforeach @endif

@if($warnings) @foreach($warnings as $key => $value)
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Warning!</strong> {{ $value }}
    </div>
@endforeach @endif
