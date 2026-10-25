<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

final class RepostSeeder extends Seeder
{
    /**
     * Seed the application's reposts.
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

        $users->each(function (User $user) use ($questions): void {
            $repostable = $questions->where('to_id', '!=', $user->id);

            if ($repostable->isEmpty()) {
                return;
            }

            $repostable->random(min(2, $repostable->count()))->each(function (Question $question) use ($user): void {
                $user->reposts()->firstOrCreate(['question_id' => $question->id]);
            });
        });
    }
}
