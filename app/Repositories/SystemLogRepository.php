<?php
namespace App\Repositories;

use App\Models\SystemLog;
use App\Repositories\Criteria\Repository;
use Maatwebsite\Excel\Facades\Excel;

class SystemLogRepository extends Repository
{
    protected function model()
    {
        return SystemLog::class;
    }

    /**
     *
     * @param string $username
     * @param string $ip
     *
     * @return mixed
     */
    public function search($username, $ip)
    {
        $logs = tap($this->model->with('user'), function ($query) use ($username, $ip) {

            if ($username && !$ip) {
                $query->join('users', function ($join) use ($username) {
                    $join->where('users.username', 'like', $username . '%');
                });
            }

            if (!$username && $ip) {
                $query->where('operator_ip', 'like', $ip . '%');
            }

            if ($username && $ip) {
                $query->join('users', function ($join) use ($username, $ip) {
                    $join->where('system_logs.operator_ip', 'like', $ip . '%')->where('users.username', 'like', $username . '%');
                });
            }
        })->paginate(getPerPageRows());

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