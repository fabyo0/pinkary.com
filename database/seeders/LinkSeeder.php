<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Seeder;

final class LinkSeeder extends Seeder
{
    /**
     * Seed the application's links.
     */
    public function run(): void
    {
        $users = User::query()->get();

        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        $users->each(function (User $user): void {
            Link::factory()
                ->count(fake()->numberBetween(1, 3))
                ->create(['user_id' => $user->id]);
        });
    }
}
