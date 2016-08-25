<?php

namespace App\Http\Controllers\Dashboard;

use App\Repositories\SystemLogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSystemLogController extends Controller
{
    protected $logRepository;


    /**
     * AdminSystemLogController constructor.
     * @param SystemLogRepository $logRepository
     */
    public function __construct(SystemLogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function index(Request $request)
    {
        $username = $request->get('s_username');
        $ip = $request->get('s_ip');

        if ($username || $ip) {
            $logs = $this->logRepository->search($username, $ip);
        } else {
            $logs = $this->logRepository->paginate();
        }
        return view('dashboard.system_log.index', compact('logs'));
    }

    public function show($id)
    {
        $log = $this->logRepository->find($id);
        return view('dashboard.system_log.show', compact('log'));
    }

    public function excelExport()
    {
        $logs = $this->logRepository->all();

        $rowOne = [['操作者', '操作者IP', '操作URL', '操作内容', '操作时间']];

        $log = [];
        foreach($logs as $key => $value) {
            $log[$key] = [$value->user->username, $value->operator_ip, $value->url, $value->content, $value->created_at->toDateTimeString()];
        }
        $cellData = array_merge($rowOne, $log);

        $this->logRepository->exportExcel($cellData);
    }
}
