<?php

namespace Database\Seeders;



use Illuminate\Database\Seeder;

use App\Models\Usuario;
use App\Models\User;





class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
     



        $usuarioAdm = Usuario::factory()->create();
        
        User::factory()->create([
            'usuario_id' => $usuarioAdm->id,
        ]);

        //  $usuarios = Usuario::factory(1)->create();

        // foreach ($usuarios as $usuario) {
        //     User::factory()->create([
        //         'name' => $usuario->nome,
        //         'email' => $usuario->email,
        //         'usuario_id' => $usuario->id,
        //     ]);
        // }


     
   

   

    }
}
