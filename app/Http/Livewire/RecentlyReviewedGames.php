<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchRecentlyReviewedGames;
use App\Utils\ArrayUtil;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class RecentlyReviewedGames extends Component
{
    public $recentlyReviewedGames = [];

    public function loadRecentlyReviewedGames() {
        $this->recentlyReviewedGames = $this->formatForView((new FetchRecentlyReviewedGames())->handle(
            Carbon::now()->subMonths(2)->timestamp,
            Carbon::now()->timestamp,
        ));

        collect($this->recentlyReviewedGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('gameWithRatingAdded', [
                'slug' => 'reviewed_' . $game['slug'],
                'rating' => $game['rating'] / 100,
            ]);
        });
    }

    public function render()
    {
        return view('livewire.recently-reviewed-games');
    }

    private function formatForView(array $games): array {
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
}
