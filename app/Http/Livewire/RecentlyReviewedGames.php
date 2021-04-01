<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchRecentlyReviewedGames;
use App\Utils\ArrayUtil;
use App\ViewModels\GameViewModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class RecentlyReviewedGames extends Component
{
    public Collection $recentlyReviewedGames ;

    public function mounted() {
        $this->recentlyReviewedGames = new Collection();
    }

    public function loadRecentlyReviewedGames() {
        $this->recentlyReviewedGames = collect((new FetchRecentlyReviewedGames())->handle(
            Carbon::now()->subMonths(2)->timestamp,
            Carbon::now()->timestamp,
        ))->map(function ($game) {
            return new GameViewModel($game);
        });

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
}
