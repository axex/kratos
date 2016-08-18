<?php
namespace App\Repositories\Dashboard;

use App\Models\Subscribe;

class SubscribeRepository
{
    protected $subscribe;

    /**
     * SubscribeRepository constructor.
     * @param $subscribe
     */
    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     * 订阅数
     *
     * @param array $values
     * @return mixed
     */
    public function count(array $values)
    {
        $subscribes = $this->subscribe->where('is_confirmed', 1)->whereBetween('created_at', $values)->count();
        return $subscribes;
    }

}