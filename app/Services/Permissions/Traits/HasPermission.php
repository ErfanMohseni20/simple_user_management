<?php

namespace App\Services\Permissions\Traits;

use App\Models\Permission;
use Illuminate\Support\Arr;

trait HasPermission
{

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions->isEmpty()) {
            return $this;
        }
        $this->permissions()->syncWithoutDetaching($permissions);
        return $this;
    }
    public function withdrawPermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->sync($permissions);
        return $this;
    }
    public function hasPermission(Permission $permission)
    {

        return $this->hasPermissionsThroughRole($permission) || $this->permissions->contains($permission);
    }
    protected function hasPermissionsThroughRole(Permission $permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) return true;
        }
        return false;
    }
    protected function getAllPermissions(array $permissions)
    {
        $permissions = Arr::flatten($permissions);
        return Permission::whereIn('id', $permissions)->get();
    }
}
