<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use App\Models\Permissions;
use App\Models\SysLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;

class UsuarioController extends Controller
{

    public function __construct(Request $request)
    {
        $this->user = Auth::user();
        // $this->tabela = 'contas';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Usuario::getAll();
    }
    public function index_usuarios_git()
    {
        $usu = ['wallysonn', 'diego3g', 'filipedeschamps', 'rmanguinho'];
        $usuarios = [];
        foreach ($usu as $key => $value) {
            $client = new Client();

            $request = new Psr7Request('GET', 'https://api.github.com/users/' . $value);
            $res = $client->sendAsync($request)->wait();
            $usuar = json_decode($res->getBody());
            $usuar->created_at = Carbon::parse( $usuar->created_at)->format('d/m/Y');
            $usuarios[] = $usuar;
        }
        return $usuarios;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        try {

        $requestData = $request->all();
        $requestData['user_in'] = $this->user->id;


        $result =   Usuario::create($requestData);

        $user = [
            'name' => $request->nome,
            'perfil' => 2,
            'password' => bcrypt( $requestData['password']),
            'usuario_id' => $result->id,
            'login' =>  $requestData['login']
        ];
        User::create($user);


        return response()->json(['msg' => "Usuario adicionado com sucesso", "conteudo" => $result], 201);
        } catch (\Exception $e) {
            return response()->json($e, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Usuario::getAllById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $id)
    {
        try {
            $evento =   Usuario::find($id);
            $requestData = $request->all();
            $requestData['user_in'] = $this->user->id;

            $result = $evento->update($requestData);
            $uss =   User::find($requestData['usuario_id']);
            $uss->login  = $requestData['login'];
            $uss->perfil  = $requestData['perfil'];
            $uss->password  = bcrypt( $requestData['password']);


            $uss->save();

                return response()->json(['msg' => "Usuario Atualizado com sucesso", "conteudo" => $result], 201);
        } catch (\Exception $e) {
            return response()->json($e, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $flight = Usuario::find(1);

        $flight->delete();
    }
}
