<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchMostAnticipatedGames;
use App\ViewModels\GameViewModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class MostAnticipatedGames extends Component
{
    public Collection $mostAnticipatedGames;

    public function mount() {
        $this->mostAnticipatedGames = new Collection();
    }

    public function loadMostAnticipatedGames() {
        $this->mostAnticipatedGames = collect((new FetchMostAnticipatedGames())->handle(
            Carbon::now()->timestamp,
            Carbon::now()->addMonths(4)->timestamp,
        ))->map(function ($game) {
            return new GameViewModel($game);
        });
    }

    public function render()
    {
        return view('livewire.most-anticipated-games');
    }
}
