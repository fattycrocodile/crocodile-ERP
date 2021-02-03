@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
@endpush

@section('content')
    @include('inc.flash')
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Admin</h4>
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
                        <form class="form" method="post" action="{{route('users.admins.update',$admin->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categoryName">Full Name</label>
                                            <input type="text" id="categoryName" class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Full Name" value="{{ old('name')?old('name'):$admin->name }}"
                                                   name="name">
                                            @error('name')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">User Name</label>
                                            <input type="text" id="username" class="form-control @error('username') is-invalid @enderror"
                                                   placeholder="User Name" value="{{ old('username')?old('username'):$admin->username }}"
                                                   name="username">
                                            @error('username')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                   placeholder="Email" value="{{ old('email')?old('email'):$admin->email }}"
                                                   name="email">
                                            @error('email')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Password" value="{{ old('password')}}"
                                                   name="password">
                                            @error('password')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="store">Store</label>
                                            <select id="store" name="store_id" class="select2 form-control @error('store_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Store
                                                </option>
                                                @foreach($stores as $key => $store)
                                                    <option value="{{ $store->id }}" {{(old('store_id')?old('store_id'):$admin->store_id)==$store->id?'selected':''}}> {{ $store->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('store_id')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select id="role" name="roles" class="select2 form-control @error('roles') is-invalid @enderror" multiple>
                                                @foreach($roles as $key => $role)
                                                    <option value="{{ $role->id }}" {{(old('roles')==$role->id || $admin->hasRole($role->id))?'Selected':''}}> {{ $role->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('roles')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a type="button" href="{{ route('users.admins.index') }}"
                                   class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i> Update
                                </button>
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
@endpush
