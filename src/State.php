<?php

namespace TicTacToe;

class State
{

    /**
     * Board State Cells
     *
     * @var Array
     */
    public $cells;

    /**
     * initalize an empty board state
     *
     * @param $state
     */
    public function __construct()
    {
        $this->cells = [
            ['_', '_', '_'],
            ['_', '_', '_'],
            ['_', '_', '_'],
        ];
    }
    
    /**
     * create a new state from an existing state
     *
     * @param State $state
     * @return void
     */
    public function copyState(State $state) {
        $this->cells = $state->getCurrentValues();
    }

    /**
     * Apply move to state with respictive sign either X or O
     *
     * @param String $position
     * @param Char $sign
     * @return void
     */
    public function setMove($position, $sign)
    {
        switch ($position) {
            case '11':
                $this->cells[0][0] = $sign;
                break;
            case '12':
                $this->cells[0][1] = $sign;
                break;
            case '13':
                $this->cells[0][2] = $sign;
                break;
            case '21':
                $this->cells[1][0] = $sign;
                break;
            case '22':
                $this->cells[1][1] = $sign;
                break;
            case '23':
                $this->cells[1][2] = $sign;
                break;
            case '31':
                $this->cells[2][0] = $sign;
                break;
            case '32':
                $this->cells[2][1] = $sign;
                break;
            case '33':
                $this->cells[2][2] = $sign;
                break;
        }
    }

    /**
     * return current state values
     *
     * @return Array
     */
    public function getCurrentValues()
    {
        return $this->cells;
    }

    /**
     * return respective cell value
     *
     * @param int $row
     * @param int $col
     * @return char
     */
    public function getCellValue($row, $col)
    {
        return $this->cells[$row - 1][$col - 1];
    }

    /**
     * return all available moves in the correct input format
     *
     * @return void
     */
    public function getAvailableMoves () {
        $availableMoves = [];
        for ($row=1; $row <= 3; $row++) { 
            for ($col=1; $col <= 3; $col++) { 
                if($this->getCellValue($row, $col) == '_') {
                    $availableMoves[] = (string) $row . (string) $col;
                }
            }
        }
        return $availableMoves;
    }

    /**
     * evalute all state rows for a wining situation
     *
     * @return boolean
     */
    private function evaluateRows()
    {
        for ($row = 1; $row <= 3; $row++) {
            if (($this->getCellValue($row, 1) == $this->getCellValue($row, 2)) and ($this->getCellValue($row, 2) == $this->getCellValue($row, 3))) {
                return true;
            }
        }
        return false;
    }

    /**
     * evalute all state columns for a wining situation
     *
     * @return boolean
     */
    private function evaluateColumns()
    {
        for ($col = 1; $col <= 3; $col++) {
            if (($this->getCellValue(1, $col) == $this->getCellValue(2, $col)) and ($this->getCellValue(2, $col) == $this->getCellValue(3, $col))) {
                return true;
            }
        }
        return false;
    }

    /**
     * evalute both state diagonals for a wining situation
     *
     * @return boolean
     */
    private function evaluateDiagonals()
    {
        if (($this->getCellValue(1, 1) == $this->getCellValue(2, 2)) and ($this->getCellValue(2, 2) == $this->getCellValue(3, 3))) {
            return true;
        } else if (($this->getCellValue(1, 3) == $this->getCellValue(2, 2)) and ($this->getCellValue(2, 2) == $this->getCellValue(3, 1))) {
            return true;
        }
        return false;
    }

    /**
     * evaluate state for any wining situation
     *
     * @return void
     */
    public function evaluate()
    {
        if ($this->evaluateRows() or $this->evaluateColumns() || $this->evaluateDiagonals()) {
            return true;
        }
        return false;
    }
}
