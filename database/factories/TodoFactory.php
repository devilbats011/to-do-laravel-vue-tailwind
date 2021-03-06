<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::first();
        return [
            'title' => $this->faker->text(10),
            'description'  => $this->faker->text(45),
            'user_id' => $user->id,
        ];
    }
}
