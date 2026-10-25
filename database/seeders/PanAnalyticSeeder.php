<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PanAnalytic;
use Illuminate\Database\Seeder;

final class PanAnalyticSeeder extends Seeder
{
    /**
     * Seed the application's analytics.
     */
    public function run(): void
    {
        PanAnalytic::factory()->count(10)->create();
    }
}
