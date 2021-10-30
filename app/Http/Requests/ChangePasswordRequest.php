<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'currentPassword' => 'required',
            'password' => 'required|min:6|max:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'currentPassword.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải từ 6 đến 8 ký tự',
            'password.max' => 'Mật khẩu phải từ 6 đến 8 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp!'
        ];
    }
}
