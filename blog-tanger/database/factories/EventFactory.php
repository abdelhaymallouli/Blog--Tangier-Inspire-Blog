<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'city' => 'Tangier',
            'date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'image' => null,
        ];
    }
}
