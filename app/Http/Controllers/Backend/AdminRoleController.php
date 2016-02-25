<?php

namespace App\Http\Controllers\Backend;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests\Backend;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::paginate(\Cache::get('page_size', 10));
        return view('backend.role.index', compact('roles'));
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('backend.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Backend\RoleRequest $request)
    {
        $role = new Role();
        $role->name = e($request->get('name'));
        $role->display_name = e($request->get('display_name'));
        $role->description = e($request->get('description'));
        if ($role->save()) {
            $role->perms()->sync($request->get('permissions'));
            return redirect()->route('backend.role.index')->with('message', trans('validation.notice.create_role_success'));
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
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get();
        $ownPermissions = $role->perms->pluck('id')->all();
        return view('backend.role.edit', compact('role', 'permissions', 'ownPermissions'));
    }

    /**
     * @param Backend\RoleRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Backend\RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = e($request->get('name'));
        $role->display_name = e($request->get('display_name'));
        $role->description = e($request->get('description'));
        if ($role->save()) {
            // 不关联权限
            if (! $request->get('permissions')) {
                $role->perms()->sync([]);
            } else {
                $role->perms()->sync($request->get('permissions'));
            }
            return redirect()->route('backend.role.index')->with('message', trans('validation.notice.update_role_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('backend.role.index')->with('message', trans('validation.notice.delete_role_success'));
    }
}
