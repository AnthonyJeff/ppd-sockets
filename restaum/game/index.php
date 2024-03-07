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

// Processa o movimento do jogador
$game = new RestaUm();
$invalidMove = false;
$gameOver = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$game->isGameOver()) {
    $fromRow = $_POST["fromRow"];
    $fromCol = $_POST["fromCol"];
    $toRow = $_POST["toRow"];
    $toCol = $_POST["toCol"];
    if (!$game->makeMove($fromRow, $fromCol, $toRow, $toCol)) {
        $invalidMove = true;
    }
    if ($game->isGameOver()) {
        $gameOver = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resta Um</title>
    <style>
        .board {
            display: grid;
            grid-template-columns: repeat(7, 50px);
            grid-template-rows: repeat(7, 50px);
            gap: 1px;
            background-color: #333;
        }
        .cell {
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
        .piece1 {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #333;
        }
        .piece2 {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ccc;
        }
        form {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="board" id="board">
        <?php
        $boardState = $game->getBoardState();
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                echo '<div class="cell">';
                if ($boardState[$i][$j] == 1) {
                    echo '<div class="piece1"></div>';
                } else if ($boardState[$i][$j] == 2) {
                    echo '<div class="piece2"></div>';
                }
                echo '</div>';
            }
        }
        ?>
    </div>

    <?php if ($invalidMove): ?>
    <script>
        alert("Movimento inválido. Tente novamente.");
    </script>
    <?php endif; ?>

    <?php if ($gameOver): ?>
    <script>
        alert("Fim de jogo! O jogador <?php echo $game->getCurrentPlayer(); ?> venceu!");
    </script>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Da Linha: <input type="number" name="fromRow" min="0" max="6"><br>
        Da Coluna: <input type="number" name="fromCol" min="0" max="6"><br>
        Para Lnha: <input type="number" name="toRow" min="0" max="6"><br>
        Para a Coluna: <input type="number" name="toCol" min="0" max="6"><br>
        <input type="hidden" name="currentPlayer" value="<?php echo $game->getCurrentPlayer(); ?>">
        <input type="submit" value="Player <?php echo $game->getCurrentPlayer(); ?> é a sua vez">
    </form>
</body>
</html>

