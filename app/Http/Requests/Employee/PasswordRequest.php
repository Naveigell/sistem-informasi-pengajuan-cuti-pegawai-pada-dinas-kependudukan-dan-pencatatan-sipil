<?php

namespace App\Http\Requests\Employee;

use App\Rules\OldPassword;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "old_password" => ["required", "string", "max:100", new OldPassword($this->old_password)],
            "password" => "required|string|max:100|same:repeat_password",
            "repeat_password" => "required|string|max:100|same:password",
        ];
    }
}
