<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\AddUser;
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected $userRepository;

    private $roleRepository;

    /**
     * AdminUserController constructor.
     *
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $name = $request->get('s_name');

        if ($name) {
            $users = $this->userRepository->search($name);
        } else {
            $users = $this->userRepository->paging('roles');
        }

        return view('dashboard.user.index', compact('users'));
    }

    /**
     * 新增用户
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = $this->roleRepository->all();

        return view('dashboard.user.create', compact('roles'));
    }

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepository->create($request->all());

        if ($user) {
            $user->roles()->sync([$request->input('role')]);
            $this->userRepository->sync($user, [$request->get('role')]);

            event(new AddUser($user)); // 触发事件

            return redirect()->route('dashboard.dashboard.user.index')->with('message', trans('validation.notice.create_user_success'));
        }

        return back()->with('fail', trans('validation.notice.database_error'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepository->findOrFail($id);

        $roles = $this->roleRepository->all();

        return view('dashboard.user.edit', compact('user', 'roles'));
    }

    /**
     * @param UserRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->userRepository->findOrFail($id);

        if ($request->has('password')) {
            $status = $this->userRepository->update($request->all(), $user->id);
        } else {
            $status = $this->userRepository->update($request->except('password'), $user->id);
        }

        if ($status) {
            $this->userRepository->sync($user, [$request->role]);
            return redirect()->route('dashboard.dashboard.user.index')->with('message', trans('validation.notice.update_user_success'));
        }

        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->userRepository->destroy($id);

        return redirect()->route('dashboard.dashboard.user.index')->with('message', trans('validation.notice.delete_user_success'));
    }
}
