<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Seeder;

final class ChannelSeeder extends Seeder
{
    /**
     * Seed the application's channels.
     */
    public function run(): void
    {
        $users = User::query()->get();

        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        $users->each(function (User $user): void {
            Channel::factory()
                ->count(fake()->numberBetween(1, 2))
                ->create(['user_id' => $user->id]);
        });
    }
}
