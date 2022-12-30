<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'login' => 'admin.teste',
            'password' => bcrypt("10203040"),
            'usuario_id' => $this->faker->numberBetween(0, 20),
            'user_in' => '1',
            'perfil' => '1',
            'user_up' => '1'
        ];
    }
}
