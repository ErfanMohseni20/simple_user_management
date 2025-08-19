<?php

namespace App\Models;

use App\Services\Permissions\Traits\HasPermission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermission;
    protected $fillable = ['name' , 'persian_name'];
    public function permissions() {
        return $this->belongsToMany(Permission::class , 'permission_role' , 'permission_id' , 'role_id');
    }

}
