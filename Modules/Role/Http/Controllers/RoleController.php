<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Role\Http\Services\RoleService;
use Modules\Role\Http\Requests\RoleRequest;
use Modules\Role\Http\Requests\UserRequest;
use Modules\Role\Http\Requests\UserUpdateRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\Login\Entities\User;


class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display Roles .
     * @return Renderable
     */
    public function show(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }

        $response = $this->roleService->show();
        return view('role::show', ['data' => $response]);
    }

    /**
     * Display view onRole create .
     * @return Renderable
     */
    public function create(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }

        $response = $this->roleService->getPages();

        return view('role::create', ['pages' => json_decode($response)]);
    }

    /**
     * Create Role
     *
     * @param RoleRequest $request
     * @return void
     */
    public function submitRole(RoleRequest $request)
    {
        $this->roleService->submitRole($request->validated());
        return redirect()->back()->with('success', 'Created successfully');

    }

    /**
     * Details of role
     *
     * @param Request $id
     * @return Renderable
     */
    public function details(Request $id): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $role = $this->roleService->details($id);
        $response = $this->roleService->getPages();

        return view('role::details', ['role' => $role, 'pages' => json_decode($response)]);

    }

    /**
     * Update Role
     *
     * @param RoleRequest $request
     * @param $id
     * @return mixed
     */
    public function update(RoleRequest $request, $id): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $this->roleService->update($request->validated(), $id);
        return redirect()->back()->with('success', 'Updated successfully');

    }

    /**
     * Delete Role
     *
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $this->roleService->delete($id);
        User::where('role', $id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    /**
     * Delete Multiple Role
     *
     * @param Request $request
     * @return mixed
     */
    public function deleteMultiple(Request $request): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $ids = $request->ids;
        Role::whereIn('id', $ids)->delete();
        User::whereIn('role', $ids)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Show All Admin User
     *
     * @return Renderable
     */
    public function showAdmin(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $response = $this->roleService->showAdmin();
        return view('role::show-admin', ['data' => $response['data']]);
    }

    /**
     * Show All Trash Admin User
     *
     * @return Renderable
     */
    public function showTrash(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $response = $this->roleService->showTrash();

        return view('role::show-trash', ['data' => $response['data']]);
    }

    /**
     * Display view onRole create .
     * @return Renderable
     */
    public function createUser(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $response = $this->roleService->getRole();

        return view('role::create-user', ['data' => $response['data']]);
    }

    /**
     * Create New Admin User By Role
     *
     * @param UserRequest $request
     * @return mixed
     */

    public function postUser(UserRequest $request): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $this->roleService->postUser($request->validated());
        return redirect()->back()->with('success', 'Created successfully');

    }

    /**
     * Details of users
     *
     * @param Request $id
     * @return Renderable
     */
    public function detailUser(Request $id): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $response = $this->roleService->detailUser($id);

        $role = $this->roleService->getRole();

        return view('role::detail-user', ['role' => $role['data'], 'data' => $response['data']]);

    }

    /**
     * Update user
     *
     * @param UserUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function updateUser(UserUpdateRequest $request, $id): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $this->roleService->updateUser($request->validated(), $id);
        return redirect()->back()->with('success', 'Updated successfully');

    }

    /**
     * Delete User
     *
     * @param $id
     * @return mixed
     */
    public function deleteUser($id): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    /**
     * Restore User
     *
     * @param $id
     * @return mixed
     */
    public function restoreTrash($id): mixed
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->back()->with('success', 'User has been restored.');
    }
}
