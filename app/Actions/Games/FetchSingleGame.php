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
        return Cache::remember('game:' . $slug, 120, function () use ($slug) {
            return $this->fetchGame($slug);
        });
    }

    private function fetchGame(string $slug)
    {
        return Game
            ::select([
                '*'
            ])
            ->with([
                'similar_games',
                'similar_games.cover',
                'similar_games.platforms',
                'artworks',
                'cover',
                'genres',
                'involved_companies',
                'involved_companies.company',
                'platforms',
                'videos',
                'screenshots',
                'websites',
            ])
            ->where('slug', $slug)
            ->firstOrFail()
            ->toArray();
    }
}
