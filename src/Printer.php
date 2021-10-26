<?php

namespace TicTacToe;

use TicTacToe\Board;

class Printer
{

    /**
     * returns text wrapped in php asci code to printed with color red to the console
     *
     * @param string $string
     * @return string
     */
    public function setRedColor($string)
    {
        return "\033[31m" . $string . "\033[0m";
    }

    /**
     * returns text wrapped in php asci code to printed with color cyan to the console
     *
     * @param string $string
     * @return string
     */
    public function setCyanColor($string)
    {
        return "\033[36m" . $string . "\033[0m";
    }

    /**
     * returns text wrapped in php asci code to printed with color green to the console
     *
     * @param string $string
     * @return string
     */
    public function setGreenColor($string)
    {
        return "\033[32m" . $string . "\033[0m";
    }

    /**
     * outputs line to php
     *
     * @param [type] $string
     * @return void
     */
    public function printLine($string)
    {
        echo $string . PHP_EOL;
    }

    /**
     * prints the game board to the console
     *
     * @param Board $board
     * @return void
     */
    public function printBoard(Board $board)
    {
        $this->printLine('');
        $this->printLine($this->setCyanColor('CURRENT GAME:'));
        $this->printLine('  1 2 3');
        for ($row = 1; $row <= 3; $row++) {
            $buffer = $row . ' ';
            for ($col = 1; $col <= 3; $col++) {
                $buffer .= $board->state->getCellValue($row, $col) . '';
                if ($col < 3) { // only print seperators and not outlines
                    $buffer .= '|';
                }
            }
            $this->printLine($buffer);
        }
    }

    /**
     * prints the instructions on how to use the app to play the game
     *
     * @return void
     */
    public function printInstructions() {
        $this->printLine($this->setCyanColor('Welcome to Tic-Tac-Toe'));
        $this->printLine($this->setCyanColor(''));
        $this->printLine($this->setCyanColor('INSTRUCTIONS:'));
        $this->printLine($this->printBoard(new Board));
        $this->printLine($this->setCyanColor('when your turn comes, you have to enter the cell refrence you want to play in,'));
        $this->printLine($this->setCyanColor('e.g. 11 where 11 is the cell at row 1 and coulmn 1 etc'));
        $this->printLine($this->setCyanColor('e.g. 21 where 21 is the cell at row 2 and coulmn 1 etc.'));
    }

    /**
     * prints the current score
     *
     * @param Player $one
     * @param Player $two
     * @return void
     */
    public function printScore(Player $one, Player $two) {
        $this->printLine('');
        $this->printLine('Current Score');
        $this->printLine($one->name .': ' . $one->score);
        $this->printLine($two->name .': ' . $two->score);
    }

    /**
     * clears the command line window
     *
     * @return void
     */
    public function clearScreen() {
        echo "\e[H\e[J";
    }

    /**
     * prints message to ask user to enter their name
     *
     * @return void
     */
    public function printUserNameQuestion() {
        $this->printLine('Please enter your name: ');
    }

    /**
     * prints message to welcome user to the game
     *
     * @param [type] $name
     * @return void
     */
    public function printWelcomeReplyToUser($name) {
        $this->printLine('welcome ' . $name . '! Do you want to start the game? press y/yes or any key for no');
    }

    /**
     * prints message to ask user for their next move
     *
     * @param Player $player
     * @return void
     */
    public function printQuestionForNextMove(Player $player) {
        $this->printLine($player->name . "'s turn, what's your next move?");
    }

    /**
     * prints message when user wins the game
     *
     * @param Player $player
     * @return void
     */
    public function printPlayerWinsMessage(Player $player) {
        $this->printLine($this->setGreenColor($player->name . " Wins!"));
    }

    /**
     * prints message when computer wins the game
     *
     * @return void
     */
    public function printComputerWinsMessage() {
        $this->printLine($this->setRedColor('Computer Wins!'));
    }

    /**
     * prints message when game result is draw
     *
     * @return void
     */
    public function printDrawMessage() {
        $this->printLine($this->setCyanColor('Game Drawn!'));
    }

    /**
     * prints message indicating user's invalid input
     *
     * @return void
     */
    public function printInvalidInputMessage() {
        $this->printLine($this->setRedColor('Invalid input!!! Please, read instructions above.'));
    }

    /**
     * Prints messgae to ask user if he wants to play again
     *
     * @return void
     */
    public function printPlayAgainMessage() {
        $this->printLine('Do you want to play again? press y/yes or any other key to dismiss.');
    }
}
