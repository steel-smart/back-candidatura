<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PastasRequest extends FormRequest
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
            'nome'        => 'string|required|max:100|min:2',
            'subpastas_id'          => 'integer|required',
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
