<?php

namespace App\Http\Controllers\Backend;

use App\SystemLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminSystemLogController extends Controller
{
    public function index()
    {
        if (\Input::get('s_username') || \Input::get('s_ip')) {
            $logs = SystemLog::join('users', function($join) {
                $join->where('users.username', 'like', '%' . e(\Input::get('s_username')) . '%')
                     ->where('system_logs.operator_ip', 'like', '%' . e(\Input::get('s_ip')) . '%');
            })->latest()->paginate(\Cache::get('page_size', 10));
        } else {
            $logs = SystemLog::latest()->paginate(\Cache::get('page_size', 10));
        }
        return view('backend.system_log.index', compact('logs'));
    }

    public function show($id)
    {
        $log = SystemLog::find($id);
        return view('backend.system_log.show', compact('log'));
    }

    public function excelExport()
    {
        $logs = SystemLog::latest()->get();
        $rowOne = [['操作者', '操作者IP', '操作URL', '操作内容', '操作时间']];
        $log = [];
        foreach($logs as $key => $value) {
            $log[$key] = [$value->user->username, $value->operator_ip, $value->url, $value->content, $value->created_at->toDateTimeString()];
        }
        $cellData = array_merge($rowOne, $log);

        // 文件名
        Excel::create('系统日志', function ($excel) use ($cellData) {
            // 表名
            $excel->sheet('system_logs', function ($sheet) use ($cellData) {
               $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
