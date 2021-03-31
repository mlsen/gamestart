<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchMostAnticipatedGames;
use App\Utils\ArrayUtil;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class MostAnticipatedGames extends Component
{
    public $mostAnticipatedGames = [];

    public function loadMostAnticipatedGames() {
        $this->mostAnticipatedGames = $this->formatForView((new FetchMostAnticipatedGames())->handle(
            Carbon::now()->timestamp,
            Carbon::now()->addMonths(4)->timestamp,
        ));
    }

    public function render()
    {
        return view('livewire.most-anticipated-games');
    }

    private function formatForView(array $games): array {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverUrl' => Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']),
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }
}
