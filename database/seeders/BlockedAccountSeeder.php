<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BlockedAccount;
use Illuminate\Database\Seeder;

final class BlockedAccountSeeder extends Seeder
{
    /**
     * Seed the application's blocked accounts.
     */
    public function run(): void
    {
        BlockedAccount::factory()->count(5)->create();
    }
}
