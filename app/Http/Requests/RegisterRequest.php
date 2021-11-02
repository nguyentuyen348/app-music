<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
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
            'user_name' => 'required|min:4|max:12|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:8|confirmed'
        ];

    }

    public function messages()
    {
        return [
            'user_name.required' => 'Tên tài khoản được để trống!',
            'user_name.min' => 'Tên tài khoản cần phải nhập từ 4 đến 12 ký tự',
            'user_name.max' => 'Tên tài khoản cần phải nhập từ 4 đến 12 ký tự',
            'user_name.unique' => 'Tên tài khoản đã tồn tại',
            'email.required' => 'Vui lòng điền email',
            'email.email' => 'Email không hợp lệ!',
            'email.unique' => 'Email đã tồn tại!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.min' => 'Mật khẩu cần phải nhập từ 6 đến 8 ký tự',
            'password.max' => 'Mật khẩu cần phải nhập từ 6 đến 8 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp!'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
