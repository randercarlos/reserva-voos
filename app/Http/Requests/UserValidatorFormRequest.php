<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidatorFormRequest extends FormRequest
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
        // Recupera o id do Usuário pela URI(segment1 => panel, segment2 => users, segment3 => id do usuário).
        // Necessário para que a validação unique ignore o próprio id ao validar se o campo é único na tabela do BD
        $id = $this->segment(3);

        return [
            'name' => 'required|min:5|max:50',
            'email' => 'required|email|max:40|unique:users,email,'.$id,
            'password' => 'min:3|max:8',
            'password_confirm' => 'required_unless:password,null|same:password',
            'image' => 'image',
            'is_admin' => 'boolean',
        ];
    }
}
