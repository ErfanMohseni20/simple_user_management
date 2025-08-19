<?php

namespace App\Http\ApiRequests\Auth;

use App\ApiResponse\Request\ApiRequestForm;
class RegisterRequest extends ApiRequestForm
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "name" => ['required' , 'string' , 'max:255'] , 
            "email" => ['required' , 'email' , 'unique:users,email'] , 
            "password" => ['required' , 'string' , 'min:8' , "confirmed"]
        ];
    }
}
