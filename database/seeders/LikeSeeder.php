<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

final class LikeSeeder extends Seeder
{
    /**
     * Seed the application's likes.
     */
    public function run(): void
    {
        $users = User::query()->get();
        $questions = Question::query()->get();

        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        if ($questions->isEmpty()) {
            $questions = Question::factory()->count(5)->create();
        }

        $questions->each(function (Question $question) use ($users): void {
            $users->random(min(3, $users->count()))->each(function (User $user) use ($question): void {
                $question->likes()->firstOrCreate(['user_id' => $user->id]);
            });
        });
    }
}
