<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{

/*
|--------------------------------------------------------------------------
| protected 方法是供其他方法调用
|--------------------------------------------------------------------------
|
|
|
*/


    /**
     * 激活码
     *
     * @var string
     */
    protected $confirmCode;

    public function __construct()
    {
        $this->confirmCode = str_random(48);
    }

    protected function sendEmail($view, $confirmCode, $email, $subject = '')
    {
        $subject = $subject ? $subject : trans('email.subject');
        \Mail::queue($view, ['confirmCode' => $confirmCode, 'email' => $email], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
        return view('frontend.subscribe.confirm');
    }

    /**
     * 检查邮箱被软删除，未激活的情况
     * 1. 被软删除或未激活。 2. 已经激活存在。 3. 新邮箱
     *
     * @param $email
     * @return mixed
     */
    protected function checkEmail($email)
    {
        $subscribeUser = Subscribe::where('email', $email)->withTrashed()->first();
        // 邮箱是否被软删除, 是否没激活
        if ($subscribeUser) {
            if ($subscribeUser->trashed() || $subscribeUser->is_confirmed == 0) {
                $subscribeUser->restore();
            }
        }
        return $subscribeUser;
    }

    /**
     * 查询订阅用户
     *
     * @param $confirmCode
     * @return mixed
     */
    protected function subscribeUser($confirmCode)
    {
        $subscribeUser = Subscribe::where('confirm_code', $confirmCode)->first();
        return $subscribeUser;
    }

    /**
     * 检查输入邮箱是否是正确的邮箱格式
     *
     * @param $email
     * @return string
     */
    protected function storeEmailFormat($email)
    {
        $request = new Requests\EmailRequest();
        $validator = \Validator::make(['email' => $email], $request->rules());
        return $validator->errors()->first();
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $email = $request->get('email');
        $emailBody = 'frontend.subscribe.email';

        // 检查邮箱格式
        $errorText = $this->storeEmailFormat($email);
        if ($errorText) {
            return view('frontend.subscribe.error', compact('email', 'errorText'));
        }

        // 检查邮箱是否存在
        $subscribeUser = $this->checkEmail($email);

        // 新订阅
        if (! $subscribeUser) {
            Subscribe::create(['email' => $email, 'confirm_code' => $this->confirmCode]);
            $sendEmail = $this->sendEmail($emailBody, $this->confirmCode, $email);
            return $sendEmail;
        }

        // 订阅但邮箱没激活
        if ($subscribeUser->is_confirmed == 0) {
            $sendEmail = $this->sendEmail($emailBody, $subscribeUser->confirm_code, $email);
            return $sendEmail;
        }

        // 已经订阅
        return view('frontend.subscribe.repeat', compact('subscribeUser'));
    }


    /**
     * 确认邮箱
     *
     * @param $confirmCode
     * @param $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmEmail($confirmCode, $email)
    {
        $subscribeUser = $subscribeUser = Subscribe::where(['confirm_code' => $confirmCode, 'email' => $email])->first();
        if ($subscribeUser) {
            $subscribeUser->is_confirmed = 1;
            $subscribeUser->save();
            return view('frontend.subscribe.success', compact('subscribeUser'));
        }
        abort(404);
    }

    /**
     * 直接修改资料再次验证邮箱
     *
     * @param $confirmCode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resendEmail($confirmCode)
    {
        $subscribeUser = $this->subscribeUser($confirmCode);
        $sendEmail = $this->sendEmail('frontend.subscribe.resend', $confirmCode, $subscribeUser->email, trans('email.updateProfile'));
        return $sendEmail;
    }

    /**
     * 修改资料页
     *
     * @param $confirmCode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($confirmCode)
    {
        $subscribeUser = $this->subscribeUser($confirmCode);
        return view('frontend.subscribe.profile', compact('subscribeUser'));
    }

    /**
     * 判断修改的资料是否符合要求
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function updateProfile(Request $request)
    {
        $email = $request->get('email');

        // 检查邮箱格式
        $errorText = $this->storeEmailFormat($email);
        if ($errorText) {
            return back()->with('errorText', $errorText);
        }
        $subscribeUser = $this->subscribeUser($request->get('confirmCode'));
        $checkEmail = $this->checkEmail($email);
        // 数据库有此邮箱 不管激活与否
        if ($checkEmail && $subscribeUser->email !== $email) {
            return back()->with('repeatEmail', trans('email.repeatEmail'));
        }

        // 数据库中没有此邮箱
        $subscribeUser->name = $request->get('name');
        $subscribeUser->email = $email;
        $subscribeUser->save();
        return view('frontend.subscribe.update', compact('subscribeUser'));

    }

    /**
     * 取消订阅
     *
     * @param $confirmCode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unsubscribe($confirmCode)
    {
        $subscribeUser = $this->subscribeUser($confirmCode);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return view('frontend.subscribe.unsubscribe', compact('subscribeUser'));
        }
        /**
         * 这边不能写成 $a = SubscribeUser::where('name', 'ch')->first()->delete();
         * 因为写成这样删除后 $a 就变为空, 再进行 $a->trashed() 会报错
         */
        $subscribeUser->is_confirmed = 0;
        $subscribeUser->confirm_code = $this->confirmCode;
        $subscribeUser->save();
        $subscribeUser->delete();
        if ($subscribeUser->trashed()) {
            return view('frontend.subscribe.delete');
        }
        abort(404);
    }
}