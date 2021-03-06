<?php


namespace App\Actions\Games;


use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use MarcReichel\IGDBLaravel\Models\Game;

class FetchPopularGames
{
    use AsAction;

    public function handle(int $from, int $to, int $limit = 12)
    {
        $duration = config('cache.duration.popular_games');

        return Cache::remember('popular-games', $duration, function () use ($to, $from, $limit) {
            return $this->fetchGames($from, $to, $limit);
        });
    }

    private function fetchGames(int $from, int $to, int $limit = 12) {
        return Game
            ::select([
                'name',
                'aggregated_rating',
                'total_rating',
                'slug',
            ])
            ->with([
                'cover' => [
                    'url',
                    'width',
                    'height',
                ],
                'platforms' => [
                    'abbreviation',
                ]
            ])
            ->where('total_rating_count', '>', 0)
            ->where('first_release_date', '>=', $from)
            ->where('first_release_date', '<', $to)
            ->whereIn('platforms', [48, 49, 130, 6])
            ->orderBy('total_rating_count', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
