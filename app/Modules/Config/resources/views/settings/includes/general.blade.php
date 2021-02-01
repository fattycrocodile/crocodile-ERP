<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
            @csrf
            <h3 class="card-title">General Settings</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label" for="site_name">Application Name</label>
                    <input class="form-control" type="text" placeholder="Enter application name" id="site_name"
                           name="site_name" value="{{ config('settings.site_name') }}"/>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="site_title">Application Title</label>
                    <input class="form-control" type="text" placeholder="Enter application title" id="site_title"
                           name="site_title" value="{{ config('settings.site_title') }}"/>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group  col-md-6">
                    <label class="control-label" for="default_email_address">Default Email Address</label>
                    <input class="form-control" type="email" placeholder="Enter  default email address"
                           id="default_email_address" name="default_email_address"
                           value="{{ config('settings.default_email_address') }}"/>
                </div>
                <div class="form-group  col-md-6">
                    <label class="control-label" for="default_email_address_2">Default Email Address 2</label>
                    <input class="form-control" type="email" placeholder="Enter second email address"
                           id="default_email_address_2" name="default_email_address_2"
                           value="{{ config('settings.default_email_address_2') }}"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="control-label" for="phone">Phone</label>
                    <input class="form-control" type="tel" placeholder="Enter phone" id="phone" name="phone"
                           value="{{ config('settings.phone') }}"/>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="phone_2">Phone 2</label>
                    <input class="form-control" type="tel" placeholder="Enter phone" id="phone_2" name="phone_2"
                           value="{{ config('settings.phone_2') }}"/>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="phone_3">Phone 3</label>
                    <input class="form-control" type="tel" placeholder="Enter phone" id="phone_3" name="phone_3"
                           value="{{ config('settings.phone_3') }}"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label" for="fax">Fax</label>
                    <input class="form-control" type="text" placeholder="Enter Fax" id="fax" name="fax"
                           value="{{ config('settings.fax') }}"/>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="fax_2">Fax 2</label>
                    <input class="form-control" type="text" placeholder="Enter Fax" id="fax_2" name="fax_2"
                           value="{{ config('settings.fax_2') }}"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="control-label" for="address">Address</label>
                    <textarea class="form-control" rows="4" placeholder="Enter address" id="address"
                              name="address">{{ config('settings.address') }}</textarea>
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
