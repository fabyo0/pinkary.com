<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SuppressedEmail;
use Illuminate\Database\Seeder;

final class SuppressedEmailSeeder extends Seeder
{
    /**
     * Seed the application's suppressed emails.
     */
    public function run(): void
    {
        SuppressedEmail::factory()->count(5)->create();
    }
}
