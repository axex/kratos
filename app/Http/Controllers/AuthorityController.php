<?php

namespace App\Http\Controllers;

use App\Events\UserLogin;
use App\Events\UserLogout;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\EmailRequest;
use App\Repositories\AuthorityRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorityController extends Controller
{
    /**
     * AuthorityController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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
     * @param AuthorityRepository $authorityRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterRequest $request, AuthorityRepository $authorityRepository)
    {
        $user = $authorityRepository->create(
            array_merge($request->all(), ['reset_code' => str_random(48)])
        );
        $authorityRepository->login($user);
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
     * @param AuthorityRepository $authorityRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request, AuthorityRepository $authorityRepository)
    {
        $user = $authorityRepository->attempt(
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
        Auth::logout();
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
     * 密码重置
     *
     * @param EmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEmail(EmailRequest $request)
    {
        $email = $request->get('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            \Mail::send('authority.mail', ['reset_code' => $user->reset_code], function ($m) use ($email) {
                $m->to($email)->subject(trans('passwords.subject'));
            });
            return back()->with('status', trans('passwords.sent'));
        }
        return back()->with('fail', trans('passwords.nouser'));
    }

    public function getReset($resetCode)
    {
        if (! User::where('reset_code', $resetCode)->first()) {
            throw new NotFoundHttpException;
        }
        return view('authority.reset')->with('resetCode', $resetCode);
    }

    public function postReset(RegisterRequest $request)
    {
        $user = User::where('reset_code', $request->get('reset_code'))->first();
        if ($user->email === $request->get('email')) {
            $user->update([
               'password' => $request->get('password'),
                'reset_code' => str_random(48)
            ]);
            return redirect()->route('login')->with('status', trans('passwords.reset'));
        }
        return back()->with('fail', trans('passwords.nouser'));
    }
}
