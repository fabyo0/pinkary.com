<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

final class BookmarkSeeder extends Seeder
{
    /**
     * Seed the application's bookmarks.
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
            $questions->random(min(2, $questions->count()))->each(function (Question $question) use ($user): void {
                $user->bookmarks()->firstOrCreate(['question_id' => $question->id]);
            });
        });
    }
}
