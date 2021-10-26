<?php

namespace TicTacToe;

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
    public function renderBoard(Board $board)
    {
        $this->printLine('  1 2 3');
        for ($row = 1; $row <= 3; $row++) {
            $buffer = $row . '';
            for ($col = 1; $col <= 3; $col++) {
                $buffer = $board->state->getCellValue($row, $col) . '';
                if ($col < 3) { // only print seperators and not outlines
                    $buffer .= '|';
                }
            }
            $this->printLine($buffer);
        }
    }
}
