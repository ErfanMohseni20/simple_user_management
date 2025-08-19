<?php

namespace App\Http\ApiRequests;

use App\ApiResponse\Request\ApiRequestForm;
class RoleToUserRequest extends ApiRequestForm
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "roles" => ['required' , 'array'] , 
            "roles.*" => ['integer' , 'exists:roles,id']
        ];
    }
}
