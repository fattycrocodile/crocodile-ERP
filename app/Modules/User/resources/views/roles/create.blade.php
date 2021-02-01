@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/icheck/icheck.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/icheck/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/checkboxes-radios.css')}}">
@endpush

@section('content')
    @include('inc.flash')
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Roles</h4>
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
                <div class="card-content collpase show">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route('users.roles.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="roles">Roles Name</label>
                                    <input type="text" id="roles" class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Role Name" value="{{ old('name') }}"
                                           name="name">
                                    @error('name')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>
                                @php
                                $i =1;
                                @endphp

                                @foreach($permission_group as $group)
                                    <hr>
                                <div class="row skin skin-square">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <fieldset >
                                                <input type="checkbox" id="group{{$i}}permission" class="group{{$i}}" onclick="checkGroup('permission_group{{ $i }}permissions',this)" >
                                                <label for="group{{$i}}permission" >{{$group->group}}</label>
                                            </fieldset>
                                        </div>
                                    </div>
                                    @php
                                        $permissions = \App\Modules\User\Models\User::getPermissionByGroup($group->group);
                                        $j =1;
                                    @endphp
                                    <div class="col-md-9 permission_group{{ $i }}permissions">
                                        @foreach($permissions as $permission)
                                        <div class="form-group">
                                            <fieldset >
                                                <input type="checkbox" name="permissions[]" id="permissions{{$permission->id}}" value="{{$permission->name}}" class="icheckbox_square-green">
                                                <label for="permissions{{$permission->id}}">{{$permission->name}}</label>
                                            </fieldset>
                                        </div>
                                            @php
                                                $j++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach


                                <div class="form-actions">
                                    <a type="button" href="{{ route('users.roles.index') }}"
                                       class="btn btn-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check-square-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')


    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/checkbox-radio.js')}}" type="text/javascript"></script>
    <script>
        function checkGroup(className,group)
        {
            console.log('work');
            const groupId = $("#"+group.id);
            const permissionClass = $("."+className+" input");

            if(groupId.is(':checked'))
            {
                permissionClass.prop('checked',true);
            }
            else
            {
                permissionClass.prop('checked',false);
            }
        }
    </script>
@endpush
