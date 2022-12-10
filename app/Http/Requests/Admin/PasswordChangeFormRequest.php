<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_password'      => 'required|min:8',
            'password'              => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
        ];
    }


    public function messages()
    {
        return[
            'current_password.required'      => 'The current password field is required',
            'current_password.min'           => 'The current password field min value length is 8 charecter',
            'password.required'              => 'The password field is required',
            'password.min'                   => 'The password field min value length is 8 charecter',
            'password.confirmed'             => 'The password field and confirm password field value not match',
            'password_confirmation.required' => 'The confirm password field is required',
            'password_confirmation.min'      => 'The confirm password field min value length is 8 charecter',
        ];
    }
}
