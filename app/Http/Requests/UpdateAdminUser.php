<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUser extends FormRequest
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
        $id = $this->route('admin_user');
        return [
            'name' => 'required',
            'phone' => 'required|min:11|max:14|unique:admin_users,phone,'.$id,
            'email' => 'required|email|unique:admin_users,email,'.$id,
            'address' => 'required',
            'level' => 'required',
            'profile' => 'nullable',
            'password' => 'nullable|min:6'
        ];
    }
}
