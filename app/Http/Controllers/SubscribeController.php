<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Repositories\SubscribeRepository;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{
    /**
     * 激活码
     *
     * @var string
     */
    protected $confirmCode;
    protected $subscribeRepository;
    protected $mail;


    /**
     * SubscribeController constructor.
     *
     * @param SubscribeRepository $subscribeRepository
     * @param EmailService $mail
     */
    public function __construct(SubscribeRepository $subscribeRepository, EmailService $mail)
    {
        $this->confirmCode = str_random(48);
        $this->subscribeRepository = $subscribeRepository;
        $this->mail = $mail;
    }


    /**
     * 订阅
     *
     * @param EmailRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(EmailRequest $request)
    {
        $email = $request->get('email');
        $emailBody = 'frontend.subscribe.email';
        $confirmBody = 'frontend.subscribe.confirm';
        $subject = trans('email.subject');

        // 检查邮箱是否存在
        $subscribeUser = $this->subscribeRepository->checkEmail($email);

        // 新订阅
        if (! $subscribeUser) {
            $this->subscribeRepository->create(['email' => $email, 'confirm_code' => $this->confirmCode]);
            $this->mail->send($emailBody, ['confirmCode' => $this->confirmCode, 'email' => $email], $email, $subject);
            return view($confirmBody);
        }

        // 订阅但邮箱没激活
        if ($subscribeUser->is_confirmed == 0) {
            $this->mail->send($emailBody, ['confirmCode' => $subscribeUser->confirm_code, 'email' => $email], $email, $subject);
            return view($confirmBody);
        }

        // 已经订阅
        return view('frontend.subscribe.repeat', compact('subscribeUser'));
    }


    /**
     * 确认邮箱
     *
     * @param string $confirmCode
     * @param string $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmEmail($confirmCode, $email)
    {
        $subscribeUser = $this->subscribeRepository->confirm($confirmCode, $email);
        if ($subscribeUser) {
            return view('frontend.subscribe.success', compact('subscribeUser'));
        }
    }


    /**
     * 直接修改资料再次验证邮箱
     *
     * @param string $confirmCode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resendEmail($confirmCode)
    {
        $subscribeUser = $this->subscribeRepository->checkUser($confirmCode);
        $this->mail->send('frontend.subscribe.resend', ['confirmCode' => $confirmCode, 'email' => $subscribeUser->email], $subscribeUser->email, trans('email.updateProfile'));
        return view('frontend.subscribe.confirm');
    }


    /**
     * 修改资料页
     *
     * @param string $confirmCode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($confirmCode)
    {
        $subscribeUser = $this->subscribeRepository->checkUser($confirmCode);
        return view('frontend.subscribe.profile', compact('subscribeUser'));
    }


    /**
     * 更新订阅资料
     *
     * @param EmailRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function updateProfile(EmailRequest $request)
    {
        $email = $request->get('email');

        $subscribeUser = $this->subscribeRepository->checkUser($request->get('confirmCode'));
        $checkEmail = $this->subscribeRepository->checkEmail($email);

        // 数据库有此邮箱 不管激活与否
        if ($checkEmail && $subscribeUser->email !== $email) {
            return back()->with('repeatEmail', trans('email.repeatEmail'));
        }

        // 数据库中没有此邮箱
        $this->subscribeRepository->update($subscribeUser, $request->except('confirmCode'));
        return view('frontend.subscribe.update', compact('subscribeUser'));

    }


    /**
     * 取消订阅
     *
     * @param string $confirmCode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unsubscribe($confirmCode)
    {
        $subscribeUser = $this->subscribeRepository->checkUser($confirmCode);
        return view('frontend.subscribe.unsubscribe', compact('subscribeUser'));

    }


    /**
     * 软删除订阅者
     *
     * @param string $confirmCode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete($confirmCode)
    {
        $subscribeUser = $this->subscribeRepository->checkUser($confirmCode);
        if ($subscribeUser) {
            $this->subscribeRepository->delete($subscribeUser);
            return view('frontend.subscribe.delete');
        }
    }
}