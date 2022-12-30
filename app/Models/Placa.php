<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Placa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'placa';

    protected $fillable = [
        'id','nome','placa', 'date','usuario_id',
        'user_in', 'user_up'
    ];


    static function getAll($id)
    {
        $data =  DB::table('placa')
            ->leftjoin('users', 'users.id', 'placa.usuario_id')
            ->select('placa.*')
            ->where('users.id',$id)
            ->get();

        foreach ($data as $item) {
            $DataAtual = new DateTime($item->date);
            
            $item->date2 =$item->date;
            $item->date = $DataAtual->format('d/m/Y ');

        }
        return $data;
    }

    static function getAllById($id)
    {
        return  DB::table('placa')
            ->join('users as users_inclusao', 'users_inclusao.id', '=', 'placa.user_in')
            ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'placa.user_up')
            ->select('placa.*', 'users_inclusao.name as placa_inclusao', 'users_alteracao.name as placa_alteracao')
            ->where('placa.id', $id)
            ->get();
    }
}
