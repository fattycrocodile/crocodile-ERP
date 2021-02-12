@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Categories' }} @endsection
@push('styles')
    @include('inc.datatable_styles')
@endpush

@section('content')
    @include('inc.flash')
    <div class="row">
        <div class="col-12 text-right">
            <a type="button" class="btn btn-info btn-min-width mr-1 mb-1"
               href="{{route('hr.leaves.create')}}"><i
                    class="fa fa-plus"></i> Apply</a>
        </div>
    </div>
    <!-- Responsive integration (Bootstrap) table -->
    <section id="bs-responsive">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Leave Applicatins</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            {!! $dataTable->table([], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Responsive integration (Bootstrap) table -->
@endsection
@push('scripts')
    @include('inc.datatable_scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $('#leave-table').on('click', '.btn-delete[data-remote]', function (e) {

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            if (confirm('Are you sure you want to delete this row?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    $('#leave-table').DataTable().draw(false);
                    var message = data.message;
                    if (data.success === true) {
                        toastr.success(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    } else {
                        if (!message)
                            message = "Please try again!";
                        toastr.error(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                });
            }

        });
    </script>
@endpush
