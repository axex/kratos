<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminSystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $system = SystemSetting::get()->toArray();
        foreach ($system as $s) {
            $systemData[$s['name']] = $s['value'];
        }
        return view('dashboard.system_setting.index', compact('systemData'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $systemData = $request->input('systemData');
        if ($systemData && is_array($systemData)) {
            foreach ($systemData as $key => $value) {
                $value = e($value);
                SystemSetting::where('name', $key)->update(['value' => $value]);
                \Cache::forever($key, $value);
            }
            return redirect()->route('dashboard.system.setting')->with('message', trans('validation.notice.update_system_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));
    }

}
