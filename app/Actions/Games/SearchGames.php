<?php


namespace App\Actions\Games;


use Lorisleiva\Actions\Concerns\AsAction;
use MarcReichel\IGDBLaravel\Models\Game;

class SearchGames
{
    use AsAction;

    public function handle(string $query, int $limit) {
        return Game::search($query)
            ->select(['name', 'slug', 'cover.url'])
            ->with(['cover'])
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
