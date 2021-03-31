<?php


namespace App\Actions\Games;


use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use MarcReichel\IGDBLaravel\Models\Game;

class FetchSingleGame
{
    use AsAction;

    public function handle(string $slug)
    {
        $duration = config('cache.duration.single_game');
        $duration = 1;

        return Cache::remember('game:' . $slug, $duration, function () use ($slug) {
            return $this->fetchGame($slug);
        });
    }

    private function fetchGame(string $slug)
    {
        return Game
            ::select([
                'name',
                'slug',
                'aggregated_rating',
                'rating',
                'summary',
            ])
            ->with([
                'similar_games' => [
                    'name',
                    'slug',
                    'total_rating',
                ],
                'similar_games.cover' => [
                    'url',
                ],
                'similar_games.platforms' => [
                    'abbreviation',
                ],
                'cover' => [
                    'url',
                ],
                'genres' => [
                    'name',
                ],
                'involved_companies.company' => [
                    'name',
                ],
                'platforms' => [
                    'abbreviation',
                ],
                'videos' => [
                    'video_id',
                ],
                'screenshots' => [
                    'url',
                ],
                'websites' => [
                    'url',
                ],
            ])
            ->where('slug', $slug)
            ->firstOrFail()
            ->toArray();
    }
}
