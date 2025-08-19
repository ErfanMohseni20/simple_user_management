<?php

namespace App\Http\ApiRequests\Role;

use App\ApiResponse\Request\ApiRequestForm;

class AddNewRoleRequest extends ApiRequestForm
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'max:255'],
            "persian_name" => ['required', 'string', 'max:255'],
        ];
    }
}
