<?php


namespace App\Actions\Games;


use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use MarcReichel\IGDBLaravel\Models\Game;

class FetchMostAnticipatedGames
{
    use AsAction;

    public function handle(int $from, int $to, int $limit = 4)
    {
        $duration = config('cache.duration.most_anticipated_games');

        return Cache::remember('most-anticipated-games', $duration, function () use ($from, $to, $limit) {
            return $this->fetchGames($from, $to, $limit);
        });
    }

    private function fetchGames(int $from, int $to, int $limit = 4)
    {
        return Game
            ::select([
                'name',
                'first_release_date',
                'hypes',
                'slug',
            ])
            ->with([
                'cover' => [
                    'url',
                    'width',
                    'height'
                ]
            ])
            ->where('hypes', '>', 0)
            ->where('first_release_date', '>=', $from)
            ->where('first_release_date', '<', $to)
            ->whereIn('platforms', [48, 49, 130, 6])
            ->orderBy('hypes', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
