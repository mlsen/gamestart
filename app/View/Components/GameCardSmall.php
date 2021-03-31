<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GameCardSmall extends Component
{
    /**
     * @var array
     */
    public $game;

    /**
     * Create a new component instance.
     *
     * @param array $game
     */
    public function __construct(array $game)
    {
        //
        $this->game = $game;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.game-card-small');
    }
}
