@php
    $errors = Session::get('error');
    $messages = Session::get('success');
    $info = Session::get('info');
    $warnings = Session::get('warning');
@endphp

@if($errors) @foreach($errors as $key => $value)
    <div class="alert alert-icon-right alert-info alert-dismissible mb-2 flash-messages" role="alert">
        <span class="alert-icon"><i class="fa fa-bug"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Error!</strong> {{ $value }}
    </div>
@endforeach @endif

@if($messages) @foreach($messages as $key => $value)
    <div class="alert alert-icon-right alert-success alert-dismissible mb-2 flash-messages" role="alert">
        <span class="alert-icon"><i class="fa fa-info"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Success!</strong> {{ $value }}
    </div>
@endforeach @endif

@if($info) @foreach($info as $key => $value)
    <div class="alert alert-icon-right alert-info alert-dismissible mb-2 flash-messages" role="alert">
        <span class="alert-icon"><i class="fa fa-info"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Info!</strong> {{ $value }}
    </div>
@endforeach @endif

@if($warnings) @foreach($warnings as $key => $value)
    <div class="alert alert-icon-right alert-info alert-dismissible mb-2 flash-messages" role="alert">
        <span class="alert-icon"><i class="fa fa-warning"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Warning!</strong> {{ $value }}
    </div>
@endforeach @endif
@push('scripts')
    <script>
        $("document").ready(function () {
            $(".flash-messages").fadeTo(2000, 500).slideUp(500, function () {
                $(".flash-messages").slideUp(500);
            });
        });
    </script>
@endpush
