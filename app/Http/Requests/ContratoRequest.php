<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ContratoRequest extends FormRequest
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
            'tipo_pessoa'       => 'string|required|max:2|min:2',
            'email_contratante'    => 'string|required|email|max:100|min:2',
            'nome_contratante'     => 'string|required|max:100|min:2',
            'documento'       => 'string|max:18|min:11',
            'imovel_id'  => 'integer|required',
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
