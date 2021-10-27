<?php 

if (php_sapi_name() != 'cli') {
    die('you can only acess this app from the command line');
 }

require __DIR__ . '/vendor/autoload.php';


use TicTacToe\Engine;

$engine = new Engine;

$engine->initializeGame();

while ($engine->keepPlaying()) {
    $engine->startRound();
}

// exit;