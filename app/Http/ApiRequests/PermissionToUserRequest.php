<?php

namespace App\Http\ApiRequests; 

use App\ApiResponse\Request\ApiRequestForm;

class PermissionToUserRequest extends ApiRequestForm
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'permissions' => ['nullable', 'array'],
            "permissions.*" => ['integer', 'exists:permissions,id']
        ];
    }
}
