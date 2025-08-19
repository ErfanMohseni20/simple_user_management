<?php

namespace App\Http\Controllers;

use App\ApiResponse\Facades\ApiResponseFacades;
use App\Http\ApiRequests\PermissionToUserRequest;
use App\Http\ApiRequests\RoleToUserRequest;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //manage permission 
    public function AddPermission(PermissionToUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user;
            $user->givePermissionsTo($request->permissions);
            DB::commit();
            return ApiResponseFacades::message("دسترسی با موفیقت به کاربر اضافه شد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
    public function WithDrawPermission(PermissionToUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user;
            $user->withdrawPermissions($request->permissions);
            DB::commit();
            return ApiResponseFacades::message("دسترسی با موفیقت از کاربر گرفته شد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
    public function RefreshPermissions(PermissionToUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user;
            $user->refreshPermissions($request->permissions);
            DB::commit();
            return ApiResponseFacades::message("دسترسی های کاربر کاملا ویرایش شد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
    public function HasPermission(Permission $permission, Request $request)
    {
        try {
            $user = $request->user;
            if ($user->HasPermission($permission) == false) {
                return ApiResponseFacades::message("کاربر به این روت دسترسی ندارد")->status(403)->build();
            } else {
                return ApiResponseFacades::message("کاربر به این روت دسترسی دارد")->status(200)->build();
            }
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
    //manage role 
    public function AddRole(RoleToUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user;
            $user->giveRolesTo($request->roles);
            DB::commit();
            return ApiResponseFacades::message("نقش با موفقیت به کاربر اضافه شد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message('خطا سمت سرور')->data($th->getMessage())->status(500)->build();
        }
    }
    public function WithDrawRole(RoleToUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user;
            $user->withDrawRole($request->roles);
            DB::commit();
            return ApiResponseFacades::message("نقش با موفقیت از کاربر گرفته شد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message('خطا سمت سرور')->data($th->getMessage())->status(500)->build();
        }
    }
    public function RefreshRole(RoleToUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user;
            $user->refreshRoles($request->roles);
            DB::commit();
            return ApiResponseFacades::message("تمامی نقش های کاربر با موفقیت تغییر کرد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message('خطا سمت سرور')->data($th->getMessage())->status(500)->build();
        }
    }
    public function HasRole(Role $role, Request $request)
    {
        try {
            $user = $request->user;
            if ($user->HasRole($role) == false) {
                return ApiResponseFacades::message("کاربر به این روت دسترسی ندارد")->status(403)->build();
            } else {
                return ApiResponseFacades::message("کاربر به این روت دسترسی دارد")->status(200)->build();
            }
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }


}
