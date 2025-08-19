<?php

namespace App\Services\Permissions\Traits;

use App\Models\Role;
use Illuminate\Support\Arr;

trait HasRole
{

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function giveRolesTo(...$roles)
    {
        $roles = $this->getAllRoles($roles);
        if ($roles->isEmpty()) return $this;
        $this->roles()->syncWithoutDetaching($roles);
        return $this;
    }
    public function withDrawRole(...$roles)
    {
        $roles = $this->getAllRoles($roles);
        $this->roles()->detach($roles);
        return $this;
    }
    public function refreshRoles(...$roles)
    {
        $roles = $this->getAllRoles($roles);
        $this->roles()->sync($roles);
        return $this;
    }
    public function HasRole(Role $role)
    {
        return $this->roles->contains('id', $role->id);
    }
    protected function getAllRoles(array $roles)
    {
        $roles = Arr::flatten($roles);
        return Role::whereIn('id', $roles)->get();
    }
}
