<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
            @csrf
            <h3 class="card-title">Opening Closing Hours</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label" for="opening_day">Opening Days</label>
                    <input class="form-control" type="text" placeholder="Ex: MON - SAT DAY" id="opening_day"
                           name="opening_day" value="{{ config('settings.opening_day') }}"/>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="opening_hour">Opening Hour</label>
                    <input class="form-control" type="text" placeholder="Ex: 10.00 - 18.00" id="opening_hour"
                           name="opening_hour" value="{{ config('settings.opening_hour') }}"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label" for="closing_day">Closing Days</label>
                    <input class="form-control" type="text" placeholder="Ex: Sunday" id="closing_day"
                           name="closing_day" value="{{ config('settings.closing_day') }}"/>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="closing_hour">Closing Hour</label>
                    <input class="form-control" type="text" placeholder="Ex: 10.00 - 18.00" id="closing_hour"
                           name="closing_hour" value="{{ config('settings.closing_hour') }}"/>
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
