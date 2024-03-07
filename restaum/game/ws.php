<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resta Um - Cliente</title>
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
            cursor: pointer; /* Adiciona cursor de clique */
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
    </style>
</head>
<body>
    <div class="board" id="board">
        <!-- Conteúdo do tabuleiro será gerado pelo PHP -->
    </div>

    <script>
        // Função para enviar o movimento para o servidor
        function sendMove(fromRow, fromCol, toRow, toCol) {
            var move = fromRow + "," + fromCol + "," + toRow + "," + toCol;
            var socket = new WebSocket("ws://127.0.0.1:12345"); // Alterar o endereço do servidor se necessário
            socket.onopen = function(event) {
                socket.send(move);
            };
        }

        // Adiciona um evento de clique a cada célula do tabuleiro
        var cells = document.querySelectorAll('.cell');
        cells.forEach(function(cell) {
            cell.addEventListener('click', function() {
                // Obtém as coordenadas da célula clicada
                var fromRow = Math.floor(Array.from(cell.parentElement.children).indexOf(cell) / 7);
                var fromCol = Array.from(cell.parentElement.children).indexOf(cell) % 7;
                // Envia o movimento para o servidor
                sendMove(fromRow, fromCol, 0, 0); // Aqui, o toRow e toCol podem ser ajustados conforme necessário
            });
        });
    </script>
</body>
</html>
