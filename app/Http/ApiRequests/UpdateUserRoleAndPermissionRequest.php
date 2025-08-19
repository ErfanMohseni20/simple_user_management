<?php

namespace App\Http\ApiRequests;

use App\ApiResponse\Request\ApiRequestForm;

class UpdateUserRoleAndPermissionRequest extends ApiRequestForm
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "roles" => ['nullable', 'array'],
            "roles.*" => ['integer', 'exists:roles,id'],
            'permissions' => ['nullable', 'array'],
            "permissions.*" => ['integer', 'exists:permissions,id']
        ];
    }
}
