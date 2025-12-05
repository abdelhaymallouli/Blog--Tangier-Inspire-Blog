<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username'              => fake()->userName(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password_hash'     => Hash::make('password'),
            'role'              => fake()->randomElement(['writer', 'admin']),
            'remember_token'    => Str::random(10),
        ];
    }
}