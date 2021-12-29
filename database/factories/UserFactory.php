<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'mazlan',
            'username' => 'mazlan94',
            'email' => 'maz@lan94.com' ,
            'password' => bcrypt('pass12345'),
            'phone' => '0123456789',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
    
    // 'name' => $this->faker->name(),
    // 'email' => $this->faker->unique()->safeEmail(),
    // // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    // 'password' => Hash::make('pass12345'),
    // // 'email_verified_at' => now(),
    // 'remember_token' => Str::random(10),
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
