<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <h3 class="card-title">Application Logo</h3>
            <hr>
            <div class="form-row">
                <div class="col-3">
                    @if (config('settings.site_logo') != null)
                        <img src="{{ asset('public/'. config('settings.site_logo')) }}" id="logoImg"
                             style="width: 80px; height: auto;">
                    @else
                        <img src="{{ asset('public/img/resources/logo.png')}}" id="logoImg"
                             style="width: 80px; height: auto;">
                    @endif
                </div>
                <div class="col-9">
                    <div class="form-group">
                        <label class="control-label">Application Logo <span style="color:red;">(203 x 48) Max File Size 250KB</span></label>
                        <input class="form-control" type="file" name="site_logo"
                               onchange="loadFile(event,'logoImg')"/>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-3">
                    @if (config('settings.site_favicon') != null)
                        <img src="{{ storage_path('public/'.config('settings.site_favicon')) }}" id="faviconImg"
                             style="width: 80px; height: auto;">
                    @else
                        <img src="{{ asset('public/img/footer/footer-logo.png')}}" id="faviconImg"
                             style="width: 80px; height: auto;">
                    @endif
                </div>
                <div class="col-9">
                    <div class="form-group">
                        <label class="control-label">Application Favicon</label>
                        <input class="form-control" type="file" name="site_favicon"
                               onchange="loadFile(event,'faviconImg')"/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row d-print-none mt-2">
                    <div class="col-12 text-right">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update
                            Settings
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        loadFile = function (event, id) {
            var output = document.getElementById(id);
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endpush
