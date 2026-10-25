<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Seed the application's users.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();

        $users->each(function (User $user) use ($users): void {
            $followerIds = $users
                ->where('id', '!=', $user->id)
                ->modelKeys();

            $user->followers()->syncWithoutDetaching(
                fake()->randomElements($followerIds, min(3, count($followerIds))),
            );
        });
    }
}
