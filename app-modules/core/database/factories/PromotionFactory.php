<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\Business;
use Modules\Core\Models\Category;
use Modules\Core\Models\Promotion;

class PromotionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promotion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        return [
            'business_id' => Business::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->unique()->sentence(2),
            'description' => fake()->text(),
            'image' => 'promotion.png',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ];
    }
}
