<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string||unique:users|max:255',
            'password' => 'required|string|min:6',
            'email'    =>  'required|unique:users|email:rfc'
        ];
    }
}
