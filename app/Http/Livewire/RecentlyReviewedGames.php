<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchRecentlyReviewedGames;
use App\ViewModels\GameViewModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Game;

class RecentlyReviewedGames extends Component
{
    public Collection $recentlyReviewedGames;

    public function mount(): void
    {
        $this->recentlyReviewedGames = new Collection();
    }

    public function loadRecentlyReviewedGames(): void
    {
        $this->recentlyReviewedGames = collect((new FetchRecentlyReviewedGames())->handle(
            Carbon::now()->subMonths(2)->timestamp,
            Carbon::now()->timestamp,
        ))->map(function ($game) {
            return new GameViewModel($game);
        });

        collect($this->recentlyReviewedGames)->filter(function (GameViewModel $game) {
            return $game->totalRating() !== null;
        })->each(function (GameViewModel $game) {
            $this->emit('recentlyReviewedGameWithRatingAdded', [
                'slug' => 'reviewed_' . $game->slug(),
                'rating' => $game->totalRating() / 100,
            ]);
        });
    }

    public function render()
    {
        return view('livewire.recently-reviewed-games');
    }
}
