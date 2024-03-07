<?php

class RestaUm {
    private $board;
    private $currentPlayer;

    public function __construct() {
        // Inicializa o tabuleiro com valores padrão
        $this->board = [
            [0, 0, 1, 1, 1, 0, 0],
            [0, 0, 1, 1, 1, 0, 0],
            [1, 1, 1, 1, 1, 1, 1],
            [1, 1, 1, 0, 1, 1, 1],
            [1, 1, 1, 1, 1, 1, 1],
            [0, 0, 1, 1, 1, 0, 0],
            [0, 0, 1, 1, 1, 0, 0]
        ];
        $this->currentPlayer = 1; // Começa com o jogador 1
    }

    public function switchPlayer() {
        // Alterna entre os jogadores
        $this->currentPlayer = 3 - $this->currentPlayer;
    }

    public function getCurrentPlayer() {
        return $this->currentPlayer;
    }

    public function isValidMove($fromRow, $fromCol, $toRow, $toCol) {
        // Verifica se o movimento é válido
        if ($this->board[$fromRow][$fromCol] == $this->currentPlayer &&
            $this->board[$toRow][$toCol] == 0 &&
            abs($fromRow - $toRow) + abs($fromCol - $toCol) == 2 &&
            ($fromRow == $toRow || $fromCol == $toCol)) {
            return true;
        }
        return false;
    }

    public function makeMove($fromRow, $fromCol, $toRow, $toCol) {
        // Executa o movimento
        if ($this->isValidMove($fromRow, $fromCol, $toRow, $toCol)) {
            $this->board[$fromRow][$fromCol] = 0;
            $this->board[($fromRow + $toRow) / 2][($fromCol + $toCol) / 2] = 0;
            $this->board[$toRow][$toCol] = $this->currentPlayer;
            $this->switchPlayer();
            return true;
        }
        return false;
    }

    public function isGameOver() {
        // Verifica se o jogo acabou
        $count = 0;
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                if ($cell != 0) {
                    $count++;
                }
            }
        }
        return $count <= 1;
    }

    public function getBoardState() {
        return $this->board;
    }
}

?>
