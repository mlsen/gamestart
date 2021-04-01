<?php

namespace App\View\Components;

use App\ViewModels\GameViewModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GameCardSmall extends Component
{
    /**
     * @var GameViewModel
     */
    public GameViewModel $game;

    /**
     * Create a new component instance.
     *
     * @param GameViewModel $game
     */
    public function __construct(GameViewModel $game)
    {
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
