<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
            'nome'      => 'string|required|max:200|min:2',
            'sigla'     => 'string|max:45|min:2',
            'descricao' => 'max:100',
            'status'    => 'required|integer',
            'user_in'           => 'string|max:100|min:2',
            'user_up'           => 'string|max:100|min:2'
        ];
    }

    public function messages()
    {
        return [

            'integer'  => 'O campo deve ser do tipo INT',
            'required' => 'O campo deve ser obrigatorio',
            'nome.max' => 'O campo nome deve possuir ate 200 caracteres',
            'nome.min' => 'O campo nome deve possuir no minimo 2 caracteres'
        ];
    }
}
