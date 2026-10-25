<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Hashtag;
use App\Models\Question;
use Illuminate\Database\Seeder;

final class HashtagSeeder extends Seeder
{
    /**
     * Seed the application's hashtags.
     */
    public function run(): void
    {
        $hashtags = collect(['laravel', 'php', 'pinkary', 'opensource', 'webdev'])
            ->map(fn (string $name): Hashtag => Hashtag::query()->firstOrCreate([
                'name' => $name,
            ]));

        if (! Question::query()->exists()) {
            Question::factory()->count(5)->create();
        }

        Question::query()
            ->get()
            ->each(function (Question $question) use ($hashtags): void {
                $hashtagIds = $hashtags
                    ->random(min(2, $hashtags->count()))
                    ->map(fn (Hashtag $hashtag): int => $hashtag->id)
                    ->all();

                $question->hashtags()->syncWithoutDetaching($hashtagIds);
            });
    }
}
