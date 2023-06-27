<?php

namespace Modules\Role\Http\Services;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $rolePermissions = Role::create(['name' => $name]);
        $checkboxValues = $requestData['checkbox'];
        foreach($checkboxValues as $permission)
        {
            $rolePermissions->givePermissionTo([$permission]);
        }
        return true;
    }

    /**
     * Show Role
     *
     * @return array
     */
    public function show(): array
    {
        $excludedRoles = [Role::ROLE_SUPER, Role::ROLE_ADMIN, Role::ROLE_CONTENT];
        $roles = Role::whereNotIn('name', $excludedRoles)
            ->get();
        $allRoles = [];
        if (!empty($roles)) {
            foreach ($roles as $role) {
                if ($role->status == Role::ROLE_ACTIVE) {
                    $status = 'Active';
                } else {
                    $status = 'Inactive';
                }
                $allRoles[] = array(
                    'id' => $role->id,
                    'role' => $role->name,
                    'status' => $status
                );
            }
        }
        return $allRoles;
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
        $permissions = $role->permissions->pluck('id')->toArray();
        $data['role'] = $role->name;
        $data['status'] = $role->status;
        $data['permissions'] = $permissions;
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
        $excludedRoles = [Role::ROLE_SUPER, Role::ROLE_BRAND, Role::ROLE_RETAILER, User::ROLE_SUPERID];
        $adminUsers = User::whereNotIn('role', $excludedRoles)
            ->with('roles')
            ->get();
        $allUsers = [];
        if (!empty($adminUsers)) {
            foreach ($adminUsers as $adminUser) {
                $role = json_decode($adminUser->roles);
                $allUsers[] = array(
                    'id' => $adminUser->id,
                    'first_name' => $adminUser->first_name,
                    'last_name' => $adminUser->last_name,
                    'email' => $adminUser->email,
                    'role' => $role[0]->name
                );

            }
        }

        return [
            'res' => true,
            'msg' => '',
            'data' => $allUsers
        ];
    }

    /**
     * Show all admin user
     *
     * @return array
     */
    public function showTrash(): array
    {

        $trashUsers = User::with('roles')
            ->onlyTrashed()
            ->get();
        $allUsers = [];
        if (!empty($trashUsers)) {
            foreach ($trashUsers as $trashUser) {
                $role = json_decode($trashUser->roles);
                $allUsers[] = array(
                    'id' => $trashUser->id,
                    'first_name' => $trashUser->first_name,
                    'last_name' => $trashUser->last_name,
                    'email' => $trashUser->email,
                    'role' => $role[0]->name
                );

            }
        }

        return [
            'res' => true,
            'msg' => '',
            'data' => $allUsers
        ];
    }

    /**
     * Show Role
     *
     * @return array
     */
    public function getRole(): array
    {
        $roles = Role::where('name', '!=', Role::ROLE_SUPER)
            ->get();
        $allRoles = [];
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $allRoles[] = array(
                    'id' => $role->id,
                    'role' => $role->name
                );
            }
        }
        return [
            'res' => true,
            'msg' => '',
            'data' => $allRoles
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
        $user->assignRole($role);

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
        $user = User::findOrFail($id);
        $role = Role::findOrFail($role);
        $user->assignRole($role);
        return [
            'res' => true,
            'msg' => 'Successfully updated',
            'data' => ''
        ];
    }
}
