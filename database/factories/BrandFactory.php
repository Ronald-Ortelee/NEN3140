<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
        ];
    }

    /**
     * Indicate that the brand is a well-known manufacturer.
     */
    public function wellKnown(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => fake()->randomElement([
                'Siemens',
                'ABB',
                'Schneider Electric',
                'Eaton',
                'Legrand',
                'Hager',
                'Phoenix Contact',
                'Weidmüller',
                'Wago',
                'Rockwell Automation',
            ]),
        ]);
    }
} 