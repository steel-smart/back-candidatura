<?php

namespace App\Http\Requests;

use Validator;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            'nome' => 'string|required|max:100|min:2',
            'cpf_cnpj' => 'string|required|max:100|min:2',
            'senha' => 'string|max:80|min:2',
            'login' => 'string|nullable',
            'perfil' => 'required|integer',
        ];



        return $rules;
    }

    public function messages()
    {
        return [
            'integer' => 'O campo deve ser do tipo inteiro',
            'string' => '',
            'required' => 'A algum campo vazio, preenxa por favor',
            'nome.max' => 'O campo nome deve possuir ate 200 caracteres',
            'nome.min' => 'O campo nome deve possuir no minimo 2 caracteres',
            'date' => 'O campo deve ser uma data valida',
            'email' => 'Favor forneca um email valido',
            'perfil.exists' => 'O Perfil informado ainda não existe, confira no menu \'Perfil\''
        ];
    }
}
