<?php

namespace App\Http\Controllers;

use App\ApiResponse\Facades\ApiResponseFacades;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{


    public function Register(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            $token = JWTAuth::fromUser($user);
            Auth::login($user);
            DB::commit();
            return ApiResponseFacades::message("ثبت نام با موفقیت انجام شد ")->data($token)->status(201)->build();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
    public function Login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                return ApiResponseFacades::message("کاربری یافت نشد")->status(404)->build();
            }
            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponseFacades::message("ایمیل یا رمز عبور نادرست است")->status(404)->build();
            }
            return ApiResponseFacades::message(" ورود با موفقیت انجام شد ")->data($token)->status(201)->build();
        } catch (\Throwable $th) {
            return ApiResponseFacades::message("خطا سمت سرور")->data($th->getMessage())->status(500)->build();
        }
    }
}
