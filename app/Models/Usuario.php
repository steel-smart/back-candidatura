<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuario';

    protected $fillable = [
        'id','nome', 'cpf_cnpj',
        'user_in', 'user_up'
    ];


    static function getAll()
    {
        $data =  DB::table('usuario')
            ->leftjoin('users', 'users.usuario_id', 'usuario.id')
            ->select('usuario.*','users.perfil','users.login','users.id as users_id' , 'cpf_cnpj as documento')
            ->where('users.id','>',1)
            ->get();

        foreach ($data as $item) {
            $item->documento = formata_cpf_cnpj($item->documento);
        }
        return $data;
    }

    static function getAllById($id)
    {
        return  DB::table('usuario')
            ->join('users as users_inclusao', 'users_inclusao.id', '=', 'usuario.user_in')
            ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'usuario.user_up')
            ->select('usuario.*', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao')
            ->where('usuario.id', $id)
            ->get();
    }
}
