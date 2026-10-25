<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PollOption;
use App\Models\Question;
use Illuminate\Database\Seeder;

final class PollOptionSeeder extends Seeder
{
    /**
     * Seed the application's poll options.
     */
    public function run(): void
    {
        if (! Question::query()->whereNotNull('poll_expires_at')->exists()) {
            Question::factory()->poll()->create();
        }

        Question::query()
            ->whereNotNull('poll_expires_at')
            ->each(function (Question $question): void {
                if ($question->pollOptions()->exists()) {
                    return;
                }

                PollOption::factory()
                    ->count(fake()->numberBetween(2, 4))
                    ->create(['question_id' => $question->id]);
            });
    }
}
