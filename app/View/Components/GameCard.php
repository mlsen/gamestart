<?php

namespace App\View\Components;

use App\ViewModels\GameViewModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GameCard extends Component
{
    /**
     * @var GameViewModel
     */
    public GameViewModel $game;

    /**
     * @var string
     */
    public string $ratingSlugPrefix;

    public bool $eventBased = false;

    /**
     * Create a new component instance.
     *
     * @param GameViewModel $game
     * @param string $ratingSlugPrefix
     * @param bool $eventBased
     */
    public function __construct(GameViewModel $game, string $ratingSlugPrefix, bool $eventBased)
    {
        //
        $this->game = $game;
        $this->ratingSlugPrefix = $ratingSlugPrefix;
        $this->eventBased = $eventBased;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.game-card');
    }
}
