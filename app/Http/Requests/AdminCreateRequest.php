<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|max:40',
            'email' => 'required|email|unique:admins|max:191',
            'password' => 'required|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'Bir kullanıcın olmalı.',
            'email'=> 'Geçerli bir email girin',
            'password' => 'Parola geçerli değil.',
        ];
    }

    public function messages()
    {
        return [
            'username' => 'test',
            'email' => 'hakan',
            'password' => 'wtf',
        ];
    }
}
