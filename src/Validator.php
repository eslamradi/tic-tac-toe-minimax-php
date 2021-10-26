<?php

namespace TicTacToe;

use TicTacToe\Board;

class Validator
{

    public function isValidCellInput($input, Board $board)
    {
        if (in_array($input, ['11', '12', '13', '21', '22', '23', '31', '32', '33'])) {
            if ($board->state->getCellValue((int)$input[0], (int)$input[1]) === '_') {
                return true;
            }
        }
        return false;
    }

    public function isAnswerYes($input)
    {
        if (in_array(strtolower($input), ['y', 'yes'])) {
            return true;
        }
        return false;
    }
}
