<?php

namespace App\Http\Controllers;

use App\ApiResponse\Facades\ApiResponseFacades;
use App\Http\ApiRequests\UpdateUserRoleAndPermissionRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::with('roles')->get();
            return ApiResponseFacades::message('لیست کاربران با موفقیت دریافت شد')->data(
                UserResource::collection($users)
            )->status(200)->build();
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User  $user)
    {
        try {
            $user->load(['roles', 'permissions']);
            return ApiResponseFacades::message("اطلاعات کاربر با موفقیت دریافت شد")->data(
                new UserResource($user)
            )->status(200)->build();
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRoleAndPermissionRequest $request, User  $user)
    {
        try {
            DB::beginTransaction();
            // return [$user , $request->all()];
            $user->refreshPermissions($request->permissions);
            $user->refreshRoles($request->roles);
            DB::commit();
            return ApiResponseFacades::message("عملیات باموفقیت انجام شد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return ApiResponseFacades::message("کاربر با موفقیت حذف شد")->status(200)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
}
