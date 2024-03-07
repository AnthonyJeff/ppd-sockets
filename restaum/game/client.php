<?php

require_once 'resta_um.php';

// Definindo o endereço IP e a porta do servidor
$ip = "127.0.0.1";
$port = 8080;

// Criando um socket TCP/IP
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Tentando se conectar ao servidor
$result = socket_connect($socket, $ip, $port);

if ($result === false) {
    echo "Erro ao conectar ao servidor.\n";
    exit;
}

echo "Conexão estabelecida.\n";

// Recebendo a mensagem do servidor
$response = socket_read($socket, 1024);
echo "Servidor: " . $response . "\n";

// Loop principal para enviar e receber dados do servidor
while (true) {
    // Recebendo entrada do usuário
    echo "Faça seu movimento: ";
    $move = readline();

    // Enviando o movimento para o servidor
    socket_write($socket, $move, strlen($move));

    // Recebendo a resposta do servidor
    $response = socket_read($socket, 1024);
    echo "Servidor: " . $response . "\n";
}

// Fechando o socket
socket_close($socket);

?>
