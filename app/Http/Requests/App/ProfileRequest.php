<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        return [
            'name' => 'nullable|string|min:4|max:90',
            'username' => "nullable|string|min:6|max:25|unique:users,username",
            'email' => "nullable|email|unique:users,email",
            'bio' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|file|max:2000|mimes:jpg,jpeg,png,webp',
        ];
    }
}
