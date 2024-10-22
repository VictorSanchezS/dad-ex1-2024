<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Infraction>
 */
class InfractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->numerify('########'), // Genera un DNI de 8 dígitos
            'fecha' => $this->faker->dateTimeBetween('-1 years', 'now'), // Fecha entre un año atrás y ahora
            'plate' => $this->faker->regexify('[A-Z]{3}-[0-9]{3}'), // Ejemplo: ABC-123
            'infraccion' => $this->faker->sentence(6), // Oración de 6 palabras
            'description' => $this->faker->text(200), // Texto de 200 caracteres
        ];
    }
}
