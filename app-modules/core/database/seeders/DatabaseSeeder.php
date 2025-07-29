<?php

namespace Estivenm0\Core\Database\Seeders;

use Estivenm0\Core\Models\Business;
use Estivenm0\Core\Models\Category;
use Estivenm0\Core\Models\Promotion;
use Estivenm0\Core\Models\Rating;
use Estivenm0\Core\Models\Type;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserRoleSeeder::class]);

        $types = Type::factory(10)->create();

        Business::factory(100)
            ->has(Rating::factory()->count(15))
            ->afterCreating(function (Business $business) use ($types) {
                Category::factory()
                    ->has(
                        Promotion::factory()
                            ->for($business)
                            ->count(5)
                    )
                    ->create();

                $business->types()->attach($types->random(3));
            })
            ->create();
    }
}
