<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <h3 class="card-title">Google Map</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    @if (config('settings.google_map_marker_image') != null)
                        <img src="{{ asset('public/storage/'.config('settings.google_map_marker_image')) }}"
                             id="markerImg" style="width: 80px; height: auto;">
                    @else
                        <img src="{{ asset('public/img/resources/map-marker.png')}}" id="markerImg"
                             style="width: 80px; height: auto;">
                    @endif
                </div>
                <div class="form-group col-md-9">
                    <label class="control-label">Site Logo <span style="color:red;">(80 x 97) Max File Size 100KB</span></label>
                    <input class="form-control" type="file" name="google_map_marker_image"
                           onchange="loadFile(event,'markerImg')"/>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label" for="google_latitude">Latitude</label>
                    <input class="form-control" type="text" placeholder="Enter Latitude" id="google_latitude"
                           name="google_latitude" value="{{ config('settings.google_latitude') }}"/>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="google_longitude">Longitude</label>
                    <input class="form-control" type="text" placeholder="Enter Longitude" id="google_longitude"
                           name="google_longitude" value="{{ config('settings.google_longitude') }}"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label class="control-label" for="google_map_marker_title">Marker Title</label>
                    <input class="form-control" type="text" placeholder="Enter Title"
                           id="google_map_marker_title" name="google_map_marker_title"
                           value="{{ config('settings.google_map_marker_title') }}"/>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="google_map_marker_title">Zoom</label>
                    <input class="form-control" type="number" placeholder="Ex: 100" id="google_map_zoom"
                           name="google_map_zoom" value="{{ config('settings.google_map_zoom') }}"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="control-label" for="google_map_api_key">API KEY</label>
                    <input class="form-control" type="text" placeholder="Enter api key" id="google_map_api_key"
                           name="google_map_api_key" value="{{ config('settings.google_map_api_key') }}"/>
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
