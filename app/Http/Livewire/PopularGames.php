<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchPopularGames;
use App\ViewModels\GameViewModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class PopularGames extends Component
{
    public Collection $popularGames;

    public function mount() {
        $this->popularGames = new Collection();
    }

    public function loadPopularGames()
    {
        $this->popularGames = collect((new FetchPopularGames())->handle(
            Carbon::now()->subMonths(2)->timestamp,
            Carbon::now()->addMonths(2)->timestamp,
        ))->map(function ($game) {
            return new GameViewModel($game);
        });

        $this->popularGames->filter(function ($game) {
            return $game->totalRating();
        })->each(function ($game) {
            $this->emit('popularGameWithRatingAdded', [
                'slug' => 'popular_' . $game->slug(),
                'rating' => $game->totalRating() / 100,
            ]);
        });
    }

    public function render()
    {
        return view('livewire.popular-games');
    }
}
