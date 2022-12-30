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
            'sobrenome' => 'string|required|max:100|min:2',
            'data_nascimento' => 'required|date',
            'rua' => 'string|max:200|min:2',
            'bairro' => 'string|max:80|min:2',
            'cep' => 'string|nullable',
            'cidade_id' => 'integer|nullable',
            'status' => 'required|integer',
            'profissao_id' => 'integer',
            'sexo_id' => 'integer',
            'naturalidade_id' => 'integer|nullable',
            'telefone1' => 'max:45',
            'telefone2' => 'max:45',
            'perfil_id' => 'required|integer|exists:perfil,id',
        ];

        if (request()->id) {
            $rules['cpf'] = 'int';
            $rules['rg'] = 'int';
            $rules['email'] = 'email|max:200';

        } else {
            $rules['cpf'] = 'required|unique:usuario';
            $rules['rg'] = 'unique:usuario';
            $rules['email'] = 'email|required|unique:usuario|max:200';

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'integer' => 'O campo deve ser do tipo INT',
            'required' => 'O campo deve ser obrigatorio',
            'nome.max' => 'O campo nome deve possuir ate 200 caracteres',
            'nome.min' => 'O campo nome deve possuir no minimo 2 caracteres',
            'date' => 'O campo deve ser uma data valida',
            'email' => 'Favor forneca um email valido',
            'perfil_id.exists' => 'O Perfil informado ainda não existe, confira no menu \'Perfil\''
        ];
    }
}
