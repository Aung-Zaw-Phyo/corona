<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileInfo extends FormRequest
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
        $id = $this->route('id');
        return [
            'name' => 'required',
            'phone' => 'required|min:11|max:14|unique:users,phone,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'address' => 'nullable',
            'password' => 'nullable',
        ];
    }
}
