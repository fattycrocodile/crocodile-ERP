@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Brands' }} @endsection
@push('styles')
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/datatable/select.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/extensions/colReorder.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css') }}">

    <!-- END VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/toastr.css') }}">
@endpush

@section('content')
    @include('inc.flash')
    <div class="row">
        <div class="col-12 text-right">
            <button type="button" class="btn btn-info btn-min-width mr-1 mb-1" data-toggle="modal"
                    data-target="#bootstrap"><i
                    class="fa fa-plus"></i> Add New
            </button>
        </div>
    </div>

    <!-- Responsive integration (Bootstrap) table -->
    <section id="bs-responsive">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">BRANDS</h4>
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




    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <!-- Modal -->
            <div class="modal fade text-left" id="bootstrap" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel35"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel35"> Create</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Brands Name">
                                </fieldset>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="title1">Description</label>
                                    <textarea class="form-control" id="description" rows="3"
                                              placeholder="Description"></textarea>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                                       value="close">
                                <input type="submit" class="btn btn-outline-primary btn-lg" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <!-- BEGIN PAGE VENDOR JS-->
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>

    {!! $dataTable->scripts() !!}

    <script>
        $('#brands-table').on('click', '.btn-delete[data-remote]', function (e) {

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
                    $('#brands-table').DataTable().draw(false);
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
