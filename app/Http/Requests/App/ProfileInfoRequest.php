<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileInfoRequest extends FormRequest
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
        $user = Auth::user();

        return [
            'name' => 'required|string|min:4|max:90',
            'username' => "required|string|min:6|max:25|unique:users,username," . $user->id,
            'email' => "required|email|unique:users,email," . $user->id,
        ];
    }
}
