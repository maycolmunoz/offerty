<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Enums\StatusEnum;
use Modules\Core\Models\Business;
use Modules\Moonlaunch\Models\User;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [

            'user_id' => User::factory(),
            'name' => fake()->unique()->company(),
            'description' => fake()->paragraph(),
            'image' => 'business.png',
            'phone' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->email(),
            'status' => fake()->randomElement([
                StatusEnum::APPROVED->value,
                StatusEnum::PENDING->value,
                StatusEnum::REJECTED->value,
            ]),
            'status_description' => fake()->text(),
            'address' => fake()->address(),
            'longitude' => fake()->longitude(-74.2591, -73.7004),
            'latitude' => fake()->latitude(40.4774, 40.9176),

        ];
    }
}
