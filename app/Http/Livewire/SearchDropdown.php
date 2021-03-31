<?php

namespace App\Http\Livewire;

use App\Actions\Games\SearchGames;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $query = '';
    public $searchResults = [];

    public function render()
    {
        if (strlen($this->query) >= 2) {
            $this->searchResults = SearchGames::run($this->query, 10);
        }

        return view('livewire.search-dropdown');
    }
}
