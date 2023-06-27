<?php

namespace Modules\Role\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Modules\Role\Entities\Role;
use Modules\Role\Entities\Page;
use Modules\Login\Entities\User;
use Illuminate\Support\Facades\Hash;


class RoleService
{
    /**
     * Create Role
     *
     * @param array $requestData
     * @return array
     */
    public function submitRole(array $requestData): array
    {
        $name = $requestData['role'];
        $checkboxValues = $requestData['checkbox'];
        $permission = implode(',', $checkboxValues);
        $role = new Role();
        $role->role = $name;
        $role->status = 1;
        $role->permission = $permission;
        $role->save();
        return [
            'res' => true,
            'msg' => 'Successfully created role',
            'data' => ''
        ];
    }

    /**
     * Show Role
     *
     * @return array
     */
    public function show(): array
    {
        $role = Role::where('role', '!=', 'admin')
            ->where('role', '!=', 'Content Moderator')
            ->get();
        $allRole = [];
        if (!empty($role)) {
            foreach ($role as $v) {
                if($v->status==1)
                {
                    $status = 'Active';
                }
                else
                {
                    $status = 'Inactive';
                }
                $allRole[] = array(
                    'id' => $v->id,
                    'role' => $v->role,
                    'status' => $status
                );
            }
        }
        return [
            'res' => true,
            'msg' => '',
            'data' => $allRole
        ];
    }

    /**
     * Show Details
     *
     * @param $requestData
     * @return array
     */
    public function details($requestData): array
    {
        $role = Role::findOrFail($requestData->id);
        return [
            'res' => true,
            'msg' => '',
            'data' => $role
        ];
    }

    /**
     * Get all Pages
     *
     * @return array
     */
    public function getPages(): array
    {
        $categories = Page::with('parent')->get();

        return ['res' => true, 'msg' => "", 'data' => $categories];
    }

    /**
     * Update Role
     *
     * @param  $requestData
     * @param $id
     * @return array
     */
    public function update($requestData, $id): array
    {

        $checkboxValues = $requestData['checkbox'];
        $permission = implode(',', $checkboxValues);
        $role = Role::findOrFail($id);
        $role->role = $requestData['role'];
        $role->status = $requestData['status'];
        $role->permission = $permission;
        $role->save();
        return [
            'res' => true,
            'msg' => 'Successfully updated',
            'data' => ''
        ];
    }

    /**
     * Delet Role
     *
     * @param $id
     * @return array
     */
    public function delete($id): array
    {

        $user = Role::findOrFail($id);
        $user->delete();
        return [
            'res' => true,
            'msg' => 'Successfully deleted',
            'data' => ''
        ];
    }

    /**
     * Show all admin user
     *
     * @return array
     */
    public function showAdmin(): array
    {
        $adminUser = User::join('roles', 'users.role', '=', 'roles.id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'roles.role', 'users.id')
            ->get();
        $allUser = [];
        if (!empty($adminUser)) {
            foreach ($adminUser as $v) {
                $allUser[] = array(
                    'id' => $v->id,
                    'first_name' => $v->first_name,
                    'last_name' => $v->last_name,
                    'email' => $v->email,
                    'role' => $v->first_name,
                );
            }
        }

        return [
            'res' => true,
            'msg' => '',
            'data' => $allUser
        ];
    }

    /**
     * Show Role
     *
     * @return array
     */
    public function getRole(): array
    {
        $role = Role::where('role', '!=', 'Super Admin')
            ->get();
        $allRole = [];
        if (!empty($role)) {
            foreach ($role as $v) {
                $allRole[] = array(
                    'id' => $v->id,
                    'role' => $v->role
                );
            }
        }
        return [
            'res' => true,
            'msg' => '',
            'data' => $allRole
        ];
    }

    /**
     * Create new user
     *
     * @param array $requestData
     * @return array
     */
    public function postUser(array $requestData): array
    {
        $first_name = $requestData['first_name'];
        $last_name = $requestData['last_name'];
        $email = $requestData['email'];
        $password = Hash::make($requestData['password']);
        $role = $requestData['role'];

        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->password = $password;
        $user->role = $role;
        $user->token = '';
        $user->save();
        return [
            'res' => true,
            'msg' => 'Created Successfully',
            'data' => ''
        ];
    }

    /**
     * Details of user
     *
     * @param $requestData
     * @return array
     */
    public function detailUser($requestData): array
    {
        $user = User::findOrFail($requestData->id);
        return [
            'res' => true,
            'msg' => '',
            'data' => $user
        ];
    }

    /**
     * Update user
     *
     * @param $requestData
     * @param $id
     * @return array
     */
    public function updateUser($requestData, $id): array
    {

        $first_name = $requestData['first_name'];
        $last_name = $requestData['last_name'];
        $email = $requestData['email'];
        if (!empty($requestData['new_password'])) {
            $password = Hash::make($requestData['new_password']);
        }

        $role = $requestData['role'];
        $update = User::findOrFail($id);
        $update->first_name = $first_name;
        $update->last_name = $last_name;
        $update->email = $email;
        if (!empty($requestData['new_password'])) {
            $update->password = $password;
        }
        $update->role = $role;
        $update->save();
        return [
            'res' => true,
            'msg' => 'Successfully updated',
            'data' => ''
        ];
    }
}
