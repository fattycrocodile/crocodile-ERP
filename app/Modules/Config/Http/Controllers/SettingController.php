<?php

namespace App\Modules\Config\Http\Controllers;


use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Setting;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Class SettingController
 * @package App\Http\Controllers\Admin
 */
class SettingController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission:settings.index|settings.create|settings.edit|settings.delete', ['only' => ['index','show']]);
        $this->middleware('permission:settings.create', ['only' => ['create','store']]);
        $this->middleware('permission:settings.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:settings.delete', ['only' => ['delete']]);
    }

    use UploadAble;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Settings', 'Manage Settings');
        return view('Config::settings.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {
            if (config('settings.site_logo') != null) {
                $this->deleteOne(config('settings.site_logo'));
            }
            $logo = $this->uploadOne($request->file('site_logo', 'uploads'), 'img');
            Setting::set('site_logo', $logo);
        } elseif ($request->has('site_favicon') && ($request->file('site_favicon') instanceof UploadedFile)) {
            if (config('settings.site_favicon') != null) {
                $this->deleteOne(config('settings.site_favicon'));
            }
            $favicon = $this->uploadOne($request->file('site_favicon'), 'img');
            Setting::set('site_favicon', $favicon);
        } elseif ($request->has('google_map_marker_image') && ($request->file('google_map_marker_image') instanceof UploadedFile)) {
            if (config('settings.google_map_marker_image') != null) {
                $this->deleteOne(config('settings.google_map_marker_image'));
            }
            $favicon = $this->uploadOne($request->file('google_map_marker_image'), 'img');
            Setting::set('google_map_marker_image', $favicon);
        } else {
            $keys = $request->except('_token');
            foreach ($keys as $key => $value) {
                Setting::set($key, $value);
            }
        }
        return $this->responseRedirectBack('Settings updated successfully.', 'success');
    }
}
