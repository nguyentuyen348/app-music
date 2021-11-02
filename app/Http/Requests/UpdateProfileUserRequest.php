<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileUserRequest extends FormRequest
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
            'full_name' => 'required|',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required|',
            'email' => 'required|email',
            'avatar' => '',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Trường này không được để trống !',
            'phone.required'=>'Trường này không được để trống !',
            'phone.numeric'=>'Trường này có định dạng là số !',
            'phone.digits'=>'Trường này bắt buộc có 10 số !',
            'address.required'=>'Trường này không được để trống !',
            'email.required'=>'Trường này không được để trống !',
            'email.email'=>'Trường này có định dạng là email',
            'email.unique'=>'Email này đã tồn tại',
        ];
    }
}
