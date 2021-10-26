<?php

namespace TicTacToe;

use TicTacToe\Board;
use TicTacToe\Player;
use TicTacToe\Printer;
use TicTacToe\Validator;
use TicTacToe\State;

class Engine
{
    
    /**
     * Board with state
     *
     * @var Board
     */
    private $board;
    
    /**
     * @var Player
     */
    public  $humanPlayer;
    
    /**
     * @var Player
     */
    public  $computerPlayer;
    
    /**
     * @var Printer
     */
    private $printer;
    
    /**
     * @var Validator
     */
    private $validator;
    
    /**
     * determines if the human player is to start the round
     *
     * @var boolean
     */
    private $isplayerStarting;
    
    /**
     * detrmines if the user wishes to play again
     *
     * @var [type]
     */
    private $isUserWantingToPlayAgain;

    /**
     * Constructs the engine
     */
    public function __construct()
    {
        $this->board = new Board();
        $this->printer = new Printer();
        $this->validator = new Validator();
        $this->isplayerStarting = false;
        $this->isUserWantingToPlayAgain = true;
    }

    /**
     * initializes the game and set up the players
     *
     * @return void
     */
    public function initializeGame()
    {
        $this->printer->printInstructions();

        $playerName = null;
        while (!$playerName) {
            $this->printer->printUserNameQuestion();
            $playerName = trim(fgets(STDIN));
        }
        $this->humanPlayer = new Player($playerName);
        $this->humanPlayer->sign = 'X';
        $this->computerPlayer = new Player('Computer');
        $this->computerPlayer->sign = 'O';
        $this->printer->printWelcomeReplyToUser($this->humanPlayer);
    }

    /**
     * the actual implementation of a single round of the game.
     *
     * @return void
     */
    public function startRound()
    {
        $this->printer->printQuestionToPlayFirst();
        $this->board->state = new State();
        $isplayerStarting = trim(fgets(STDIN));
        if ($this->validator->isAnswerYes($isplayerStarting)) {
            $this->isplayerStarting = true;
        }
        $this->redrawScreen();
        if ($this->isplayerStarting) {
            $playerNextMove = $this->askUserForNextMove();
            $this->board->state->setMove($playerNextMove, $this->humanPlayer->sign);
            $this->redrawScreen();
        }
        while (!$this->board->state->isStateComplete()) {
            $this->printer->printLine('Computer is thinking');
            $computerNextMove = $this->getComputerNextMove();

            $this->board->state->setMove($computerNextMove, $this->computerPlayer->sign);
            $this->redrawScreen();
            if ($this->hasComputerWon()) {
                return;
            }
            $playerNextMove = $this->askUserForNextMove();

            $this->board->state->setMove($playerNextMove, $this->humanPlayer->sign);
            $this->redrawScreen();
            if ($this->hasHumanWon()) {
                return;
            }
        }
        $this->printer->printLine($this->printer->setRedColor('Game is Draw!'));
        $this->askPlayerToPlayAgain();
    }

    /**
     * clears the console screen and sets up the design to be displayed
     *
     * @return void
     */
    protected function redrawScreen()
    {
        $this->printer->clearScreen();
        $this->printer->printInstructions();
        $this->printer->printScore($this->humanPlayer, $this->computerPlayer);
        $this->printer->printLine($this->printer->setCyanColor('CURRENT GAME:'));
        $this->printer->printBoard($this->board);
        $this->printer->printLine('');
    }

    /**
     * checks if the computer has one the round
     *
     * @return boolean
     */
    protected function hasComputerWon()
    {
        if ($this->board->state->evaluate($this->computerPlayer->sign)) {
            $this->computerPlayer->increaseScore();
            $this->printer->printComputerWinsMessage();
            $this->askPlayerToPlayAgain();
            return true;
        }
        return false;
    }

    /**
     * checks if the human has one the round
     *
     * @return boolean
     */
    protected function hasHumanWon()
    {
        if ($this->board->state->evaluate($this->humanPlayer->sign)) {
            $this->humanPlayer->increaseScore();
            $this->printer->printPlayerWinsMessage($this->humanPlayer);
            $this->askPlayerToPlayAgain();
            return true;
        }
        return false;
    }

    /**
     * show a player a prompt to play again
     *
     */
    protected function askPlayerToPlayAgain()
    {
        $this->printer->printPlayAgainMessage();
        $playAgain = trim(fgets(STDIN));
        if ($this->validator->isAnswerYes($playAgain)) {
            $this->isUserWantingToPlayAgain = true;
        } else {
            $this->isUserWantingToPlayAgain = false;
        }
    }

    /**
     * take and process the useers next move
     *
     * @return void
     */
    protected function askUserForNextMove()
    {
        $nextMove = null;
        while (!$nextMove) {
            if ($this->board->state->isStateComplete()) {
                return true;
            }
            $this->printer->printQuestionForNextMove($this->humanPlayer);
            $nextMove = trim(fgets(STDIN));
            if ($this->validator->isValidCellInput($nextMove, $this->board)) {
                return $nextMove;
            } else {
                $nextMove = null;
                $this->printer->printInvalidInputMessage();
            }
        }
    }

    /**
     * determines if the player hasn't changed his mind about playing
     *
     * @return void
     */
    public function keepPlaying()
    {
        return $this->isUserWantingToPlayAgain;
    }

    /**
     * runs the minimax algorithm to find the best move to make for the computer
     *
     * @return string
     */
    protected function getComputerNextMove()
    {
        $availableMoves = $this->board->state->getAvailableMoves();
        $temporayState = new State;
        $temporayState->copyState($this->board->state);
        $bestValue = -1000;
        $bestMove = '';
        foreach ($availableMoves as $move) {
            $temporayState->setMove($move, $this->computerPlayer->sign);
            $Movevalue = $this->minimax($temporayState, 0, false);
            $temporayState->unsetMove($move);
            if ($Movevalue > $bestValue) {
                $bestValue = $Movevalue;
                $bestMove = $move;
            }
        }
        return $bestMove;
    }

    /**
     * the actual implemetaion of ai minimax algorithm
     *
     * @param State $state
     * @param integer $depth
     * @param bool $isMaximizer
     * @return integer
     */
    protected function minimax($state, $depth, $isMaximizer)
    {
        if ($state->evaluate($this->computerPlayer->sign)) {
            return 10;
        } else if ($state->evaluate($this->humanPlayer->sign)) {
            return -10;
        } else if ($state->isStateComplete()) {
            return 0;
        }

        if ($isMaximizer) {
            $bestValue = -1000;
            $availableMoves = $state->getAvailableMoves();
            foreach ($availableMoves as $move) {
                $state->setMove($move, $this->computerPlayer->sign);
                $bestValue = max($bestValue, $this->minimax($state, $depth + 1, !$isMaximizer));
                $state->unsetMove($move);
            }
            return $bestValue;
        } else {
            $bestValue = 1000;
            $availableMoves = $state->getAvailableMoves();
            foreach ($availableMoves as $move) {
                $state->setMove($move, $this->humanPlayer->sign);
                $bestValue = min($bestValue, $this->minimax($state, $depth + 1, !$isMaximizer));
                $state->unsetMove($move);
            }
            return $bestValue;
        }
    }
}
