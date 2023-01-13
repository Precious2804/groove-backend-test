<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' =>  ['required', 'string', 'max:255'],
            'lastname' =>  ['required', 'string', 'max:255'],
            'email' =>  ['required', 'email', 'max:255', 'unique:users,email'],
            'password' =>  ['required', 'string', 'max:255', 'min:6'],
            'phone' => ['nullable', 'unique:users,phone']
        ];
    }

    public function messages()
    {
        return [];
    }
}
