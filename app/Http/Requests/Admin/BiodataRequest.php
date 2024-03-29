<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BiodataRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /* @var User $user */
        $user = auth()->user()->load('biodata');

        $rules = [
//            "nip" => "required|unique:biodatas|string|max:50", // need advance validation, do it if you want
            "name" => "required|string|max:70",
            "username" => "required|unique:users|string|max:70",
            "email" => "required|unique:users|string|max:70",
            "phone" => "required|string|regex:/(08)[0-9]{5,17}/",
            "address" => "required|string|max:255",
        ];

        if ($this->isMethod('post')) {
            if ($this->username == $user->username) {
                $rules['username'] = 'required|string|max:60';
            }

            if ($this->email == $user->email) {
                $rules['email'] = 'required|string|max:70';
            }

//            if ($this->nip == $user->biodata->nip) {
//                $rules['nip'] = 'required|string|max:70';
//            }
        }

        return $rules;
    }
}
