<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchPopularGames;
use App\Utils\ArrayUtil;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class PopularGames extends Component
{
    public $popularGames = [];

    public function loadPopularGames()
    {
        $this->popularGames = $this->formatForView((new FetchPopularGames())->handle(
            Carbon::now()->subMonths(2)->timestamp,
            Carbon::now()->addMonths(2)->timestamp,
        ));

        collect($this->popularGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('recentlyReviewedGameWithRatingAdded', [
                'slug' => 'popular_' . $game['slug'],
                'rating' => $game['rating'] / 100,
            ]);
        });
    }

    private function formatForView(array $games): array
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => isset($game['total_rating']) ? round($game['total_rating']) : null,
                'platforms' => array_key_exists('platforms', $game)
                    ? ArrayUtil::toSeparatedString($game['platforms'], 'abbreviation', ', ')
                    : null,
            ]);
        })->toArray();
    }

    public function render()
    {
        return view('livewire.popular-games');
    }
}
