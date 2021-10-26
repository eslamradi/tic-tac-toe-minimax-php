<?php 

namespace TicTacToe;

class Player {
    
    public $name;
    public $sign;

    public function __construct($name)
    {
        $this->name = $name;
    }
}