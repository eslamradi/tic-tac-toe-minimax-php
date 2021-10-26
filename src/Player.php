<?php 

namespace TicTacToe;

class Player {
    
    public $name;
    public $sign;
    public $score;

    public function __construct($name)
    {
        $this->name = $name;
        $this->score = 0;
    }

    public function increaseScore() {
        $this->score++;
    }
}