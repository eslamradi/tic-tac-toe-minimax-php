<?php

namespace TicTacToe;

use TicTacToe\State;
use TicTacToe\Printer;

class Board
{
    /**
     * board state
     *
     * @var State
     */
    public $state;

    /**
     * Initialize a new board with a stale state
     */
    public function __construct()
    {
        $this->state = new State();
    }
}
