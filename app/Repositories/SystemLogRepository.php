<?php
namespace App\Repositories;

use App\Models\SystemLog;
use Maatwebsite\Excel\Facades\Excel;

class SystemLogRepository
{
    protected $log;

    /**
     * SystemSettingRepository constructor.
     * @param SystemLog $log
     */
    public function __construct(SystemLog $log)
    {
        $this->log = $log;
    }

    public function all()
    {
        return $this->log->with('user')->latest()->get();
    }

    public function find($id)
    {
        return $this->log->find($id);
    }

    public function paginate()
    {
        return $this->log->with('user')->latest()->paginate(\Cache::get('page_size', 10));
    }

    /**
     *
     * @param string $username
     * @param string $ip
     * @return mixed
     */
    public function search($username, $ip)
    {
        $logs = tap($this->log->with('user'), function ($query) use ($username, $ip) {

            if ($username) {
                $query->join('users', function ($join) use ($username) {
                    $join->where('users.username', 'like', $username . '%');
                });
            }

            if ($ip) {
                $query->where('operator_ip', 'like', $ip . '%');
            }

            if ($username && $ip) {
                $query->join('users', function ($join) use ($username, $ip) {
                    $join->where('operator_ip', 'like', $ip . '%')->where('users.username', 'like', $username . '%');
                });
            }
        })->paginate(\Cache::get('page_size', 10));

        return $logs;
    }

    /**
     * 导出日志到 excel
     *
     * @param $cell
     */
    public function exportExcel($cell)
    {
        // 文件名
        Excel::create('系统日志', function ($excel) use ($cell) {
            // 表名
            $excel->sheet('system_logs', function ($sheet) use ($cell) {
                $sheet->rows($cell);
            });
        })->export('xls');
    }
}