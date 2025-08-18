<?php

namespace App\ApiResponse\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequestForm extends FormRequest {
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException( response()->json([
            'status' => "warning",
            'message' => $validator->errors(),
            ],500));

    }
}
