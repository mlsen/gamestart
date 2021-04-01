<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchComingSoonGames;
use App\ViewModels\GameViewModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class ComingSoonGames extends Component
{
    /**
     * @var Collection
     */
    public Collection $comingSoonGames;

    /**
     * Initializes the Component
     */
    public function mount() {
        $this->comingSoonGames = new Collection();
    }

    /**
     * Loads the games asynchronously
     */
    public function loadComingSoonGames()
    {
        $this->comingSoonGames = collect((new FetchComingSoonGames())->handle(
            Carbon::now()->timestamp,
        ))->map(function ($game) {
            return new GameViewModel($game);
        });
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.coming-soon-games');
    }
}
