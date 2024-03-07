<?php

// Função para verificar se há movimentos possíveis
function hasMoves($board) {
    $size = count($board);
    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            if ($board[$i][$j] == 1) {
                // Verifica se pode mover para cima
                if ($i >= 2 && $board[$i - 1][$j] == 1 && $board[$i - 2][$j] == 0) {
                    return true;
                }
                // Verifica se pode mover para baixo
                if ($i <= $size - 3 && $board[$i + 1][$j] == 1 && $board[$i + 2][$j] == 0) {
                    return true;
                }
                // Verifica se pode mover para esquerda
                if ($j >= 2 && $board[$i][$j - 1] == 1 && $board[$i][$j - 2] == 0) {
                    return true;
                }
                // Verifica se pode mover para direita
                if ($j <= $size - 3 && $board[$i][$j + 1] == 1 && $board[$i][$j + 2] == 0) {
                    return true;
                }
            }
        }
    }
    return false;
}

// Função para fazer um movimento
function makeMove($board, $row, $col) {
    if ($row < 0 || $row >= count($board) || $col < 0 || $col >= count($board)) {
        return ['success' => false, 'message' => 'Coordenadas inválidas. Tente novamente.'];
    } elseif ($board[$row][$col] != 1) {
        return ['success' => false, 'message' => 'Posição inválida. Tente novamente.'];
    } elseif ($row >= 2 && $board[$row - 1][$col] == 1 && $board[$row - 2][$col] == 0) {
        $board[$row][$col] = 0;
        $board[$row - 1][$col] = 0;
        $board[$row - 2][$col] = 1;
    } elseif ($row <= count($board) - 3 && $board[$row + 1][$col] == 1 && $board[$row + 2][$col] == 0) {
        $board[$row][$col] = 0;
        $board[$row + 1][$col] = 0;
        $board[$row + 2][$col] = 1;
    } elseif ($col >= 2 && $board[$row][$col - 1] == 1 && $board[$row][$col - 2] == 0) {
        $board[$row][$col] = 0;
        $board[$row][$col - 1] = 0;
        $board[$row][$col - 2] = 1;
    } elseif ($col <= count($board) - 3 && $board[$row][$col + 1] == 1 && $board[$row][$col + 2] == 0) {
        $board[$row][$col] = 0;
        $board[$row][$col + 1] = 0;
        $board[$row][$col + 2] = 1;
    } else {
        return ['success' => false, 'message' => 'Movimento inválido. Tente novamente.'];
    }
    return ['success' => true, 'board' => $board];
}

// Inicialização do tabuleiro de jogo
$board = array(
    array(0, 0, 1, 1, 1, 0, 0),
    array(0, 0, 1, 1, 1, 0, 0),
    array(1, 1, 1, 1, 1, 1, 1),
    array(1, 1, 1, 1, 1, 1, 1),
    array(1, 1, 1, 1, 1, 1, 1),
    array(0, 0, 1, 1, 1, 0, 0),
    array(0, 0, 1, 1, 1, 0, 0)
);

// Verifica se foi feito um movimento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $row = $data['row'];
    $col = $data['col'];
    $response = makeMove($board, $row, $col);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Retorna o tabuleiro no início do jogo
    header('Content-Type: application/json');
    echo json_encode(['board' => $board]);
}
