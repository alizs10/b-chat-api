<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'always_offline' => 'required|in:0,1',
            'invite_to_groups' => 'required|in:0,1',
            'dark_theme' => 'required|in:0,1',
            'private_account' => 'required|in:0,1',
        ];
    }
}
