<?php

namespace CodeEduBook\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivrosCreateRequest extends FormRequest
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
            'title' => 'required | max:255',
            'subtitle' => 'required | max:255',
            'price' => 'required | numeric',
            'categorias' => 'required | array',
            'categorias.*' => 'exists:categorias,id',
            'dedication' => 'required',
            'description' => 'required',
            'website' => 'required | max:255 | url',
            'percent_complete' => 'required | integer | min:0'
        ];
    }

    public function messages()
    {
        $result = [];
        $categorias =$this->get('categorias', []);
        $count = count($categorias);
        if(is_array($categorias) && $count > 0){

            foreach (range(0, $count-1) as $value){

                $field = \Lang::get('validation.attributes.categorias_*', ['num' => $value + 1]);
                $message = \Lang::get('validation.exists', ['attribute' => $field]);
                $result["categorias.$value.exists"] = $message;

            }
        }

        return $result;
    }
}
