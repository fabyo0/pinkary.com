<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

final class QuestionSeeder extends Seeder
{
    /**
     * Seed the application's questions.
     */
    public function run(): void
    {
        $users = User::query()->get();

        if ($users->count() < 2) {
            $users = $users->merge(
                User::factory()->count(2 - $users->count())->create(),
            );
        }

        $channels = Channel::query()->get();

        $participants = function () use ($users): array {
            $from = $users->random();
            $to = $users->where('id', '!=', $from->id)->random();

            return ['from_id' => $from->id, 'to_id' => $to->id];
        };

        Question::factory()
            ->count(20)
            ->state(fn (): array => $participants())
            ->create();

        Question::factory()
            ->count(5)
            ->state(fn (): array => [
                ...$participants(),
                'answer' => null,
                'answer_created_at' => null,
                'answer_updated_at' => null,
            ])
            ->create();

        $root = Question::factory()
            ->state(fn (): array => [
                ...$participants(),
                'content' => 'What is your favorite editor?',
            ])
            ->create();

        Question::factory()
            ->count(2)
            ->state(fn (): array => [
                'from_id' => $root->from_id,
                'to_id' => $root->to_id,
                'parent_id' => $root->id,
                'root_id' => $root->id,
            ])
            ->create();

        Question::factory()
            ->count(3)
            ->poll()
            ->state(fn (): array => $participants())
            ->create();

        if ($channels->isNotEmpty()) {
            Question::factory()
                ->count(10)
                ->state(fn (): array => [
                    ...$participants(),
                    'channel_id' => $channels->random()->id,
                ])
                ->create();
        }

        Question::factory()
            ->count(2)
            ->state(fn (): array => [
                ...$participants(),
                'quoted_question_id' => $root->id,
            ])
            ->create();

        $user = $users->random();

        Question::factory()
            ->sharedUpdate()
            ->create([
                'from_id' => $user->id,
                'to_id' => $user->id,
                'parent_id' => $root->id,
                'root_id' => $root->id,
            ]);

        Channel::query()->each(function (Channel $channel): void {
            $channel->update([
                'questions_count' => $channel->questions()->count(),
            ]);
        });
    }
}
