<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileValidatorFormRequest extends FormRequest
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
        $id = auth()->user()->id;

        return [
            'name' => "required|min:5|max:50|unique:users,name,$id,id",
            'email' => 'required|email|max:50|unique:users,email,'.$id,
            'password' => 'min:3|max:8',
            'password_confirm' => 'required_unless:password,null|same:password',
            'image' => 'image',
        ];
    }
}
