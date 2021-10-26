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
}
