<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\RoleRequest;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;

class AdminRoleController extends Controller
{
    protected $roleRepository;

    protected $permissionRepository;

    /**
     * AdminRoleController constructor.
     *
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {

        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = $this->roleRepository->paging();
        return view('dashboard.role.index', compact('roles'));
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = $this->permissionRepository->all();
        return view('dashboard.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = $this->roleRepository->create($request->all());
        $permissions = [];

        if ($role) {
            if ($request->has('permissions')) {
                $permissions = $request->get('permissions');
            }

            $this->roleRepository->sync($role, $permissions);

            return redirect()->route('dashboard.dashboard.role.index')->with('message', trans('validation.notice.create_role_success'));
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
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findOrFail($id);

        $permissions = $this->permissionRepository->all();

        $ownPermissions = $role->perms->pluck('id')->all();

        return view('dashboard.role.edit', compact('role', 'permissions', 'ownPermissions'));
    }

    /**
     * @param RoleRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, $id)
    {
        $permissions = $request->permissions;

        $role = $this->roleRepository->findOrFail($id);

        $status = $this->roleRepository->update($request->all(), $role->id);

        if ($status) {
            if (!$permissions) {
                $permissions = [];
            }

            $this->roleRepository->sync($role, $permissions);

            return redirect()->route('dashboard.dashboard.role.index')->with('message', trans('validation.notice.update_role_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->roleRepository->destroy($id);

        return redirect()->route('dashboard.dashboard.role.index')->with('message', trans('validation.notice.delete_role_success'));
    }
}
