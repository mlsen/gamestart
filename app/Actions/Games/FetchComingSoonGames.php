<?php


namespace App\Actions\Games;


use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use MarcReichel\IGDBLaravel\Models\Game;

class FetchComingSoonGames
{
    use AsAction;

    public function handle(int $from, int $limit = 4)
    {
        $duration = config('cache.duration.coming_soon_games');

        return Cache::remember('coming-soon-games', $duration, function () use ($from, $limit) {
            return $this->fetchGames($from, $limit);
        });
    }

    private function fetchGames(int $from, int $limit = 4)
    {
        return Game
            ::select([
                'name',
                'first_release_date',
                'slug',
            ])
            ->with([
                'cover' => [
                    'url',
                    'width',
                    'height',
                ]
            ])
            ->where('total_rating_count', '>', 0)
            ->where('first_release_date', '>=', $from)
            ->whereIn('platforms', [48, 49, 130, 6])
            ->orderBy('first_release_date', 'asc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
