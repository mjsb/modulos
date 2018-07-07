<?php

namespace CodeEduBook\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriasRequest extends FormRequest
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
        $id = $this->route('categoria');
        return [
            'name' => "required | max:50 | unique:categorias,name,$id"
        ];
    }

   /* public function messages()
    {
        return [
            'required' => 'O :attribute é obrigatório!',
            'unique' => 'O :attribute digitado já está em uso!'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome'
        ];
    }*/
}
