<?php

namespace App\Http\Controllers;

use App\ApiResponse\Facades\ApiResponseFacades;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $permissions = Permission::get();
            return ApiResponseFacades::message("لیست دسترسی ها با موفقیت دریافت شدند")->data(
                PermissionResource::collection($permissions)
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
        try {
            DB::beginTransaction();
            Permission::create([
                'name' => $request->name,
                "name_fa" => $request->name_fa,
            ]);
            DB::commit();
            return ApiResponseFacades::message("دسترسی با موفقیت اضافه شد")->status(201)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        try {
            return ApiResponseFacades::message("اطلاعات دسترسی با موفقیت دریافت شد")->data(
                new PermissionResource($permission)
            )->status(200)->build();
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Permission $permission, Request $request)
    {
        try {
            DB::beginTransaction();
            $data = [];
            $fileds = ['name', 'name_fa'];
            foreach ($fileds as $field) {
                if ($request->has($field)) {
                    $data[$field] = $request->$field;
                }
            }
            $permission->update($data);
            DB::commit();
            return ApiResponseFacades::message("دسترسی با موفقیت ویرایش شد")->status(201)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            DB::beginTransaction();
            $permission->delete();
            DB::commit();
            return ApiResponseFacades::message("دسترسی با موفقیت حذف شد")->status(201)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
}
