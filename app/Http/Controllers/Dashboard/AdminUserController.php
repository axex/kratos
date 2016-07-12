<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\AddUser;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\Dashboard;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (\Input::get('s_name')) {
            $users = User::where('username', 'like', '%' . e(\Input::get('s_name')) . '%')
                    ->orWhere('realname', 'like', '%' . e(\Input::get('s_name')) . '%')
                    ->paginate(\Cache::get('page_size', 10));
        } else {
            $users = User::paginate(\Cache::get('page_size', 10));
        }
        return view('dashboard.user.index', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::get();
        return view('dashboard.user.create', compact('roles'));
    }

    /**
     * @param Dashboard\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Dashboard\UserRequest $request)
    {
        $user = new User();
        $user->username = e($request->get('username'));
        $user->realname = e($request->get('realname'));
        $user->email = e($request->get('email'));
        $user->password = $request->get('password');
        if ($user->save()) {
            $user->roles()->sync([$request->input('role')]);
            event(new AddUser($user)); // 触发事件
            return redirect()->route('dashboard.user.index')->with('message', trans('validation.notice.create_user_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        // 当前用户所属的用户组
        $currentRole = $user->roles()->value('id');
        return view('dashboard.user.edit', compact('user', 'roles', 'currentRole'));
    }

    /**
     * @param Dashboard\UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Dashboard\UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->has('password')) {
            $status = $user->update($request->all());
        } else {
            $status = $user->update($request->except('password'));
        }

        if ($status) {
            $user->roles()->sync([$request->input('role')]);
            return redirect()->route('dashboard.user.index')->with('message', trans('validation.notice.update_user_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('dashboard.user.index')->with('message', trans('validation.notice.delete_user_success'));
    }
}
