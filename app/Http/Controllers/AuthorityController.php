<?php

namespace App\Http\Controllers;

use App\Events\UserLogin;
use App\Events\UserLogout;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\EmailRequest;
use App\Repositories\AuthorityRepository;
use App\Services\Mail\MailService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorityController extends Controller
{
    protected $authRepository;

    /**
     * AuthorityController constructor.
     * @param AuthorityRepository $authRepository
     */
    public function __construct(AuthorityRepository $authRepository)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->authRepository = $authRepository;
    }

    /**
     * 注册页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRegister()
    {
        return view('authority.register');
    }

    /**
     * 验证注册
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterRequest $request)
    {
        $user = $this->authRepository->create($request->all());
        $this->authRepository->login($user);

        return redirect()->intended(route('dashboard.console'));
    }

    /**
     * 登录页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('authority.login');
    }

    /**
     * 验证登录
     *
     * @param LoginRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        $user = $this->authRepository->attempt(
            $request->get('username'),
            $request->get('password'),
            $request->has('remember')
        );

        if ($user) {
            event(new UserLogin(Auth::user()));    // 触发登录事件
            // intended 方法将会将用户重定向到登录之前用户想要访问的URL，在目标URL无效的情况下备用URI将会传递给该方法。
            return redirect()->intended(route('dashboard.console'));
        }
        return back()->withInput()->withErrors(trans('auth.failed'));
    }

    /**
     * 退出
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        event(new UserLogout(Auth::user()));   // 触发退出事件
        $this->authRepository->logout();
        return redirect('/');
    }

    /**
     * 密码重置页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEmail()
    {
        return view('authority.password');
    }

    /**
     * 密码重置发送邮件
     *
     * @param EmailRequest $request
     * @param MailService $mail
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEmail(EmailRequest $request, MailService $mail)
    {
        $email = $request->get('email');
        $user = $this->authRepository->getUser('email', $email);

        if ($user) {
            $mail->send('authority.mail', ['reset_code' => $user->reset_code], $email, trans('passwords.subject'));

            return back()->with('status', trans('passwords.sent'));
        }

        return back()->with('fail', trans('passwords.nouser'));
    }

    /**
     * 密码重置页面
     *
     * @param $resetCode
     *
     * @return $this
     */
    public function getReset($resetCode)
    {
        $user = $this->authRepository->getUser('reset_code', $resetCode);

        if (! $user) {
            throw new NotFoundHttpException;
        }

        return view('authority.reset')->with(['resetCode' => $resetCode, 'email' => $user->email]);
    }

    /**
     * 密码重置
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReset(RegisterRequest $request)
    {
        $user = $this->authRepository->getUser('reset_code', $request->get('reset_code'));
        if ($user) {
            $this->authRepository->update([
                'password' => $request->get('password'),
                'reset_code' => getVerifyCode()
            ], $user->id);

            return redirect()->route('login')->with('status', trans('passwords.reset'));
        }

        return back()->with('fail', trans('passwords.nouser'));
    }
}
