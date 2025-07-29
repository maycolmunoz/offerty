<?php

namespace Database\Seeders;

use Estivenm0\Core\Database\Seeders\DatabaseSeeder as CoreSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CoreSeeder::class,
        ]);

    }
}
