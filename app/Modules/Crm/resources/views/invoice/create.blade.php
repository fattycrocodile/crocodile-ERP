@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Create Invoice' }} @endsection

@push('styles')
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
@endpush
@section('content')

    @include('inc.flash')

    https://laravelarticle.com/laravel-autocomplete

    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Basic Elements</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="product_id">Basic Input</label>
                                        <input type="text" class="form-control typeahead " id="product_id">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="helpInputTop">Input text with help</label>
                                        <small class="text-muted">eg.<i>someone@example.com</i></small>
                                        <input type="text" class="form-control" id="helpInputTop">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="disabledInput">Disabled Input</label>
                                        <input type="text" class="form-control" id="disabledInput" disabled="">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="disabledInput">Readonly Input</label>
                                        <input type="text" class="form-control" id="readonlyInput" readonly="readonly"
                                               value="You can't update me :P">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="disabledInput">Input with Placeholder</label>
                                        <input type="email" class="form-control" id="placeholderInput"
                                               placeholder="Enter Email Address">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="disabledInput">Static Text</label>
                                        <p class="form-control-static" id="staticInput">email@pixinvent.com</p>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="roundText">Rounded Input</label>
                                        <input type="text" id="roundText" class="form-control round"
                                               placeholder="Rounded Input">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="squareText">Square Input</label>
                                        <input type="text" id="squareText" class="form-control square"
                                               placeholder="square Input">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="helperText">With Helper Text</label>
                                        <input type="text" id="helperText" class="form-control" placeholder="Name">
                                        <p>
                                            <small class="text-muted">Find helper text here for given textbox.</small>
                                        </p>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="form-repeater">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="repeat-form">Repeating Forms</h4>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
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
                        <div class="card-body">
                            <div class="repeater-default">
                                <div data-repeater-list="car">
                                    <div data-repeater-item="">
                                        <form class="form row">
                                            <div class="form-group mb-1 col-sm-12 col-md-2">
                                                <label for="email-addr">Email address</label>
                                                <br>
                                                <input type="email" class="form-control" id="email-addr"
                                                       placeholder="Enter email">
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-2">
                                                <label for="pass">Password</label>
                                                <br>
                                                <input type="password" class="form-control" id="pass"
                                                       placeholder="Password">
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-2">
                                                <label for="bio" class="cursor-pointer">Bio</label>
                                                <br>
                                                <textarea class="form-control" id="bio" rows="2"></textarea>
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                                <label for="tel-input">Gender</label>
                                                <br>
                                                <input class="form-control" type="tel" value="1-(555)-555-5555"
                                                       id="tel-input">
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-2">
                                                <label for="profession">Profession</label>
                                                <br>
                                                <select class="form-control" id="profession">
                                                    <option>Select Option</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                <button type="button" class="btn btn-danger" data-repeater-delete=""><i
                                                        class="ft-x"></i> Delete
                                                </button>
                                            </div>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group overflow-hidden">
                                    <div class="col-12">
                                        <button data-repeater-create="" class="btn btn-primary btn-lg">
                                            <i class="icon-plus4"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript"></script>

    <!-- Script -->
    <script type="text/javascript">

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {

            $("input.typeahead").autocomplete({
                minLength: 1,
                autoFocus: true,
                source: function (request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('productNameAutoComplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function (event, ui) {
                    // console.log(event);
                    // console.log(ui);
                    return false;
                },
                select: function (event, ui) {
                    // Set selection
                    $('input.typeahead').val(ui.item.label); // display the selected text
                    // $('#employeeid').val(ui.item.value); // save selected id to input
                    return false;
                },
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                var inner_html = '<div>' + item.label + ' (<i>' + item.code + ')</i></div>';
                return $("<li>")
                    .data("item.autocomplete", item)
                    .append(inner_html)
                    .appendTo(ul);
            };
        });
    </script>
@endpush
