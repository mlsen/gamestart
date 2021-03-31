<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GameCard extends Component
{
    /**
     * @var array
     */
    public $game;

    /**
     * @var string
     */
    public $ratingSlugPrefix;

    public $eventBased = false;

    /**
     * Create a new component instance.
     *
     * @param array $game
     * @param string $ratingSlugPrefix
     * @param bool $eventBased
     */
    public function __construct(array $game, string $ratingSlugPrefix, bool $eventBased)
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
