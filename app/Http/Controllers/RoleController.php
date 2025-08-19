<?php

namespace App\Http\Controllers;

use App\ApiResponse\Facades\ApiResponseFacades;
use App\Http\ApiRequests\Role\AddNewRoleRequest;
use App\Http\ApiRequests\Role\UpdateRoleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Role::get();

            return ApiResponseFacades::message("لیست نقش ها با موفقیت دریافت شدند")->data(
                RoleResource::collection($roles)
            )->status(200)->build();
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddNewRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            Role::create([
                'name' => $request->name,
                "persian_name" => $request->persian_name,
            ]);
            DB::commit();
            return ApiResponseFacades::message("نقش با موفقیت اضافه شد")->status(201)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        try {
            $role->load('permissions');
            return ApiResponseFacades::message("اطلاعات نقش با موفقیت دریافت شد")->data(
                new RoleResource($role)
            )->status(200)->build();
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();
            $data = [];
            $fileds = ['name', 'persian_name'];
            foreach ($fileds as $field) {
                if ($request->has($field) && $request->$field != '') {
                    $data[$field] = $request->$field;
                }
            }
            $role->update($data);
            $role->refreshPermissions($request->permissions);
            DB::commit();
            return ApiResponseFacades::message("نقش با موفقیت ویرایش شد")->status(201)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            DB::beginTransaction();
            $role->delete();
            DB::commit();
            return ApiResponseFacades::message("نقش با موفقیت حذف شد")->status(201)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
}
