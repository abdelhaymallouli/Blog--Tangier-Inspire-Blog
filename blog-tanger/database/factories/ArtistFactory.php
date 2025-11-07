<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'city' => 'Tangier',
            'field' => $this->faker->randomElement(['Painter', 'Musician', 'Photographer']),
            'bio' => $this->faker->paragraph,
            'photo' => null,
        ];
    }
}
