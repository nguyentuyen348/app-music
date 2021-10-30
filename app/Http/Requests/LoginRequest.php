<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user_name' => 'required',
            'password' => 'required|min:6|max:8'
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => 'Trường này không được để trống!',
            'password.required' => 'Trường này không được để trống!',
            'password.min' => 'Trường này có ít nhất 6 ký tự!',
            'password.max' => 'Trường này có nhiều nhất 8 ký tự!',
        ];
    }
}
