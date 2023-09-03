<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class EmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /* @var User $employee */
        $employee = $this->route('employee');

        $groups = collect(User::GROUPS)->map(function ($group) {
            return collect($group)->keys();
        })->flatten();

        $rules = [
            "nip" => "required|numeric|max_digits:30", // need advance validation, do it if you want
            "group" => "required|string|in:" . $groups->join(','),
            "role" => "required|string|in:" . join(',', [User::ROLE_EMPLOYEE]),
            "name" => "required|string|max:50",
            "username" => "required|unique:users|string|max:60",
            "email" => "required|email|unique:users|string|max:70",
            "phone" => "required|string|regex:/(08)[0-9]{5,17}/",
            "address" => "required|string|max:255",
        ];

        if ($this->isMethod('put')) {
            if ($this->username == $employee->username) {
                $rules['username'] = 'required|string|max:60';
            }

            if ($this->email == $employee->email) {
                $rules['email'] = 'required|string|max:70';
            }
        }

        return $rules;
    }
}
