<?php

namespace App\Http\ApiRequests\Role;

use App\ApiResponse\Request\ApiRequestForm;

class UpdateRoleRequest extends ApiRequestForm
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "name" => ['nullable', 'string', 'max:255'],
            "persian_name" => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            "permissions.*" => ['integer', 'exists:permissions,id']
        ];
    }
}
