<?php

namespace App\Http\Controllers;

use App\Events\UserLogin;
use App\Events\UserLogout;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorityController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getRegister()
    {
        return view('authority.register');
    }

    public function postRegister(Requests\RegisterRequest $request)
    {
        \Auth::login(User::create(
            array_merge($request->all(), ['reset_code' => str_random(48)])
        ));
        return redirect()->intended(route('backend.console'));
    }

    public function getLogin()
    {
        return view('authority.login');
    }

    public function postLogin(Requests\LoginRequest $request)
    {
        if (\Auth::attempt([
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'is_lock'  => 0
        ], $request->has('remember'))) {
            event(new UserLogin(\Auth::user()));    // 触发登录事件
            // intended 方法将会将用户重定向到登录之前用户想要访问的URL，在目标URL无效的情况下备用URI将会传递给该方法。
            return redirect()->intended(route('backend.console'));
        }
        return back()->withInput()->withErrors(trans('auth.failed'));
    }

    public function logout()
    {
        event(new UserLogout(\Auth::user()));   // 触发退出事件
        \Auth::logout();
        return redirect('/');
    }

    public function getEmail()
    {
        return view('authority.password');
    }

    public function postEmail(Requests\EmailRequest $request)
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

    public function postReset(Requests\RegisterRequest $request)
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
