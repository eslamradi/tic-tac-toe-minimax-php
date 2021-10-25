<?php 

require __DIR__ . 'vendor/autoload.php';

use TicTacToe\Engine;

$engine = new Engine;

$engine->initializeGame();

while ($engine->continuePlay()) {
    $engine->startRound();
}

$engine->outputFinalResult();

exit;