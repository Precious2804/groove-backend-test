<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return [
            'firstname' =>  ['nullable', 'string', 'max:255'],
            'lastname' =>  ['nullable', 'string', 'max:255'],
            'email' =>  ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'numeric', 'unique:users,phone,' . $user->id],
            'date_of_birth' => ['nullable', 'date'],
        ];
    }
}
