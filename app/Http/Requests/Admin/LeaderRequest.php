<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LeaderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /* @var User $leader */
        $leader = $this->route('leader');
        $leader->load('biodata');

        $rules = [
            "nip" => "required|unique:biodatas|string|max:50", // need advance validation, do it if you want
            "role" => "required|string|in:" . join(',', [User::ROLE_HEAD_OF_DEPARTMENT, User::ROLE_HEAD_OF_FIELD]),
            "name" => "required|string|max:50",
            "username" => "required|unique:users|string|max:60",
            "email" => "required|email|unique:users|string|max:70",
            "phone" => "required|string|regex:/(08)[0-9]{5,17}/",
            "address" => "required|string|max:255",
        ];

        if ($this->isMethod('put')) {
            if ($this->username == $leader->username) {
                $rules['username'] = 'required|string|max:60';
            }

            if ($this->email == $leader->email) {
                $rules['email'] = 'required|string|max:70';
            }

            if ($this->nip == $leader->biodata->nip) {
                $rules['nip'] = 'required|string|max:70';
            }
        }

        return $rules;
    }
}
