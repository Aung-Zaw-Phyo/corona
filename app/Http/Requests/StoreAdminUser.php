<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class StoreAdminUser extends FormRequest
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
            'name' => 'required',
            'phone' => 'required|min:11|max:14|unique:admin_users,phone',
            'email' => 'required|email|unique:admin_users,email',
            'address' => 'required',
            'level' => 'required',
            'profile' => 'nullable',
            'password' => 'required|min:6'
        ];
    }
}
