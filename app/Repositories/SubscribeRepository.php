<?php

namespace App\Repositories;

use App\Models\Subscribe;
use App\Repositories\Criteria\Repository;

class SubscribeRepository extends Repository
{
    protected function model()
    {
        return Subscribe::class;
    }

    /**
     * 订阅数
     *
     * @param array $values
     *
     * @return mixed
     */
    public function count(array $values)
    {
        $subscribes = $this->model->where('is_confirmed', 1)->whereBetween('created_at', $values)->count();
        return $subscribes;
    }

    /**
     * 确认订阅
     *
     * @param string $confirmCode
     * @param string $email
     *
     * @return mixed
     */
    public function confirm($confirmCode, $email)
    {
        $subscribe = $this->findWhere(['confirm_code' => $confirmCode, 'email' => $email]);

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
     * @param $subscribe
     * @return void
     */
    public function delete($subscribe)
    {
        $subscribe->is_confirmed = 0;
        $subscribe->confirm_code = getVerifyCode();
        $subscribe->save();
        $subscribe->delete();
    }

    /**
     * 检查邮箱被软删除，未激活的情况
     * 1. 被软删除或未激活。 2. 已经激活存在 3. 新邮箱
     *
     * @param string $email
     *
     * @return mixed
     */
    public function checkEmail($email)
    {
        $subscribe = $this->model->where('email', $email)->withTrashed()->first();

        // 邮箱是否被软删除
        if ($subscribe && $subscribe->trashed()) {
            $subscribe->restore();
        }

        return $subscribe;
    }

    /**
     * 查找订阅者
     *
     * @param string $confirmCode
     *
     * @return mixed
     */
    public function checkUser($confirmCode)
    {
        $subscribe = $this->findBy('confirm_code', $confirmCode);

        return $subscribe;
    }

    /**
     * 订阅用户分页
     *
     * @return mixed
     */
    public function paginate()
    {
        $subscribes = $this->model->latest()->paginate(\Cache::get('page_size', 10));
        return $subscribes;
    }

    /**
     * 永久删除订阅用户
     *
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $subscribe = $this->findOrFail($id);
        return $subscribe->forceDelete();
    }
}