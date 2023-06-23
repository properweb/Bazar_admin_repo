<?php

namespace Modules\Role\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\Login\Entities\User;
use Illuminate\Support\Facades\Hash;



class RoleService
{
    /**
     * Create Role
     *
     * @param array $requestData
     * @return string
     */
    public function submitRole(array $requestData): string
    {
        $name = $requestData['role'];
        $Role = Role::create(['name' => $name]);
        $checkboxValues = $requestData['checkbox'];
        foreach($checkboxValues as $permission)
        {
            $Role->givePermissionTo([$permission]);
        }
        return '';
    }

    /**
     * Show Role
     *
     * @return array
     */
    public function show(): array
    {
        $role = Role::where('id', '!=', '1')
            ->get();
        $allRole = [];
        if (!empty($role)) {
            foreach ($role as $v) {
                if ($v->status == 1) {
                    $status = 'Active';
                } else {
                    $status = 'Inactive';
                }
                $allRole[] = array(
                    'id' => $v->id,
                    'role' => $v->name,
                    'status' => $status
                );
            }
        }
        return $allRole;
    }

    /**
     * Details of role
     *
     * @param $requestData
     * @return array
     */
    public function details($requestData): array
    {
        $role = Role::findOrFail($requestData->id);

        $permissions = $role->permissions;
        $rolePermission = [];
        if(!empty($permissions))
        {
            foreach($permissions as $permission)
            {
                $rolePermission[] = $permission->id;
            }
        }

        $data['role'] = $role->name;
        $data['status'] = $role->status;
        $data['permissions'] = $rolePermission;
        return $data;
    }

    /**
     * Get all Pages
     *
     * @return string
     */
    public function getPages(): string
    {
        return Permission::all();
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
        $role = Role::findOrFail($id);
        $role->name = $requestData['role'];
        $role->status = $requestData['status'];
        $role->save();
        $role->syncPermissions($checkboxValues);
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
            ->where('roles.id','!=','1')
            ->select('users.first_name', 'users.last_name', 'users.email', 'roles.name', 'users.id')
            ->get();
        $allUser = [];
        if (!empty($adminUser)) {
            foreach ($adminUser as $v) {
                $allUser[] = array(
                    'id' => $v->id,
                    'first_name' => $v->first_name,
                    'last_name' => $v->last_name,
                    'email' => $v->email,
                    'role' => $v->name,
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
        $role = Role::where('name', '!=', 'Super Admin')
            ->get();
        $allRole = [];
        if (!empty($role)) {
            foreach ($role as $v) {
                $allRole[] = array(
                    'id' => $v->id,
                    'role' => $v->name
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
