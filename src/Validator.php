<?php 

namespace TicTacToe;

class Validator {

    public function isValidCellInput($input) {
        if (in_array($input , ['11','12','13','21','22','23','31','32','33'])) {
            return true;
        }
        return false;
    }

    public function isAnswerYes($input) {
        if (in_array(strtolower($input) , ['y', 'yes'])) {
            return true;
        }
        return false;
    }
}