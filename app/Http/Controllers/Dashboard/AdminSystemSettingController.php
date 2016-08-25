<?php

namespace App\Http\Controllers\Dashboard;

use App\Repositories\SystemSettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AdminSystemSettingController extends Controller
{
    protected $settingRepository;

    /**
     * AdminSystemSettingController constructor.
     * @param SystemSettingRepository $settingRepository
     */
    public function __construct(SystemSettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $system = Cache::rememberForever('systemSetting', function () {
            return (object) $this->settingRepository->first()->toArray();
        });

        return view('dashboard.system_setting.index', compact('system'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $status = $this->settingRepository->update($request->all());

        if ($status) {
            Cache::forever('systemSetting', (object) $request->except('_token'));

            return redirect()->route('dashboard.system.setting')->with('message', trans('validation.notice.update_system_success'));
        }

        return back()->with('fail', trans('validation.notice.database_error'));
    }
}
