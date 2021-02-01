<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
            @csrf
            <h3 class="card-title">Footer &amp; SEO</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="control-label" for="site_copyright_text">Footer Copyright Text</label>
                    <textarea class="form-control" rows="4" placeholder="Enter footer copyright text"
                              id="site_copyright_text"
                              name="site_copyright_text">{{ config('settings.site_copyright_text') }}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label class="control-label" for="seo_meta_title">SEO Meta Title</label>
                    <input class="form-control" type="text" placeholder="Enter seo meta title for store"
                           id="seo_meta_title" name="seo_meta_title" value="{{ config('settings.seo_meta_title') }}"/>
                </div>
                <div class="form-group col-md-12">
                    <label class="control-label" for="seo_meta_description">SEO Meta Description</label>
                    <textarea class="form-control" rows="4" placeholder="Enter seo meta description for store"
                              id="seo_meta_description"
                              name="seo_meta_description">{{ config('settings.seo_meta_description') }}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label class="control-label" for="seo_meta_keywords">SEO Meta Description</label>
                    <textarea class="form-control" rows="4" placeholder="Comma (,) separated value"
                              id="seo_meta_keywords"
                              name="seo_meta_keywords">{{ config('settings.seo_meta_keywords') }}</textarea>
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
