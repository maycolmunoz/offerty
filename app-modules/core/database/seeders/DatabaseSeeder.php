<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Business;
use Modules\Core\Models\Category;
use Modules\Core\Models\Promotion;
use Modules\Core\Models\Rating;
use Modules\Core\Models\Type;

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
