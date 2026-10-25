<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

final class PollVoteSeeder extends Seeder
{
    /**
     * Seed the application's poll votes.
     */
    public function run(): void
    {
        $users = User::query()->get();

        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        Question::query()
            ->whereHas('pollOptions')
            ->with('pollOptions')
            ->get()
            ->each(function (Question $question) use ($users): void {
                $voters = $users->random(min(3, $users->count()));
                $pollOptions = $question->pollOptions;

                $voters->each(function (User $user, int $index) use ($pollOptions, $question): void {
                    $pollOption = $pollOptions[$index % $pollOptions->count()];

                    PollVote::query()->firstOrCreate([
                        'user_id' => $user->id,
                        'question_id' => $question->id,
                    ], [
                        'poll_option_id' => $pollOption->id,
                    ]);
                });
            });

        PollOption::query()->each(function (PollOption $pollOption): void {
            $pollOption->update([
                'votes_count' => $pollOption->votes()->count(),
            ]);
        });
    }
}
