<?php

namespace Estivenm0\Core\Database\Factories;

use Estivenm0\Core\Models\Business;
use Estivenm0\Core\Models\Rating;
use Estivenm0\Moonlaunch\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'business_id' => Business::factory(),
            'stars' => random_int(1, 5),
            'comment' => fake()->sentence(4),
        ];
    }
}
