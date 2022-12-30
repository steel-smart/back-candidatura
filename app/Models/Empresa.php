<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';

    protected $fillable = ['id', 'nome', 'sigla', 'descricao', 'status', 'user_in' ,'user_up'];

    static function getAll()
    {
        return  DB::table('empresa')
            ->join('users as users_inclusao','users_inclusao.id','=','empresa.user_in')
            ->leftjoin('users as users_alteracao','users_alteracao.id','=','empresa.user_up')
            ->select('empresa.*','users_inclusao.name as usuario_inclusao','users_alteracao.name as usuario_alteracao')
            ->get();
    }

    static function getAllById($id)
    {
        return  DB::table('empresa')
            ->join('users as users_inclusao','users_inclusao.id','=','empresa.user_in')
            ->leftjoin('users as users_alteracao','users_alteracao.id','=','empresa.user_up')
            ->select('empresa.*','users_inclusao.name as usuario_inclusao','users_alteracao.name as usuario_alteracao')
            ->where('empresa.id',$id)
            ->get();
    }

    static function block($id,$usuario)
    {   
        $update_colunas = array(
            'status' => '0',
            'user_up' => $usuario
        );

        return DB::table('empresa')
            ->where('id', $id)
            ->update($update_colunas);
    }

    static function unlock($id, $usuario)
    {

        $update_colunas = array(
            'status' => '1',
            'user_up' => $usuario
        );

        return DB::table('empresa')
            ->where('id', $id)
            ->update($update_colunas);
    }
}
