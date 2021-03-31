<?php

namespace App\Http\Livewire;

use App\Actions\Games\FetchComingSoonGames;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class ComingSoonGames extends Component
{
    public $comingSoonGames = [];

    public function loadComingSoonGames()
    {
        $this->comingSoonGames = $this->formatForView((new FetchComingSoonGames())->handle(
            Carbon::now()->timestamp,
        ));
    }

    public function render()
    {
        return view('livewire.coming-soon-games');
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
