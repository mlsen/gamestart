<?php


namespace App\Actions\Games;


use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use MarcReichel\IGDBLaravel\Models\Game;

class FetchRecentlyReviewedGames
{
    use AsAction;

    public function handle(int $from, int $to, int $limit = 3)
    {
        $duration = config('cache.duration.recently_reviewed_games');

        return Cache::remember('recently-reviewed-games', $duration, function () use ($from, $to, $limit) {
            return $this->fetchGames($from, $to, $limit);
        });
    }

    private function fetchGames(int $from, int $to, int $limit = 3)
    {
        return Game
            ::select([
                'name',
                'aggregated_rating',
                'aggregated_rating_count',
                'total_rating',
                'total_rating_count',
                'summary',
                'slug',
            ])
            ->with(['cover' => ['url', 'width', 'height'], 'platforms'])
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
