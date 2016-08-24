<?php

namespace App\Repositories;

use App\Models\Subscribe;

class SubscribeRepository
{
    protected $subscribe;

    protected $confirmCode;

    /**
     * SubscribeRepository constructor.
     *
     * @param Subscribe $subscribe
     */
    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
        $this->confirmCode = str_random(48);
    }

    /**
     * 新建订阅
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return $this->subscribe->create($attributes);
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

    /**
     * 更新资料
     *
     * @param Subscribe $subscribe
     * @param array $attributes
     * @return bool|int
     */
    public function update($subscribe, array $attributes)
    {
        return $subscribe->update($attributes);
    }

    /**
     * 确认订阅
     *
     * @param string $confirmCode
     * @param string $email
     * @return mixed
     */
    public function confirm($confirmCode, $email)
    {
        $subscribe = $this->subscribe->where(['confirm_code' => $confirmCode, 'email' => $email])->first();
        if ($subscribe) {
            $subscribe->is_confirmed = 1;
            if ($subscribe->save()) {
                return $subscribe;
            }
        }
    }

    /**
     * 软删除订阅者
     *
     * @param Subscribe $subscribe
     */
    public function delete($subscribe)
    {
        $subscribe->is_confirmed = 0;
        $subscribe->confirm_code = $this->confirmCode;
        $subscribe->save();
        $subscribe->delete();
    }

    /**
     * 检查邮箱被软删除，未激活的情况
     * 1. 被软删除或未激活。 2. 已经激活存在 3. 新邮箱
     *
     * @param string $email
     * @return mixed
     */
    public function checkEmail($email)
    {
        $subscribe = $this->subscribe->where('email', $email)->withTrashed()->first();
        // 邮箱是否被软删除
        if ($subscribe->trashed()) {
            $subscribe->restore();
        }
        return $subscribe;
    }

    /**
     * 查找订阅者
     *
     * @param string $confirmCode
     * @return mixed
     */
    public function checkUser($confirmCode)
    {
        $subscribe = $this->subscribe->where('confirm_code', $confirmCode)->first();
        return $subscribe;
    }

    /**
     * 订阅用户分页
     *
     * @return mixed
     */
    public function paginate()
    {
        $subscribes = $this->subscribe->latest()->paginate(\Cache::get('page_size', 10));
        return $subscribes;
    }

    /**
     * 查找指定订阅用户
     *
     * @param int $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $subscribe = $this->subscribe->findOrFail($id);
        return $subscribe;
    }

    /**
     * 永久删除订阅用户
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $subscribe = $this->findOrFail($id);
        return $subscribe->forceDelete();
    }
}