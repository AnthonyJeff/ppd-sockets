<?php

require_once 'resta_um.php';

// Definindo o endereço IP e a porta do servidor
$ip = "127.0.0.1";
$port = 8080;

// Criando um socket TCP/IP
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Associando o socket ao endereço e à porta
socket_bind($socket, $ip, $port);

// Iniciando a escuta do socket
socket_listen($socket);

echo "Servidor iniciado. Aguardando conexões...\n";

// Aceitando uma conexão e criando um novo socket para comunicação com o cliente 1
$clientSocket1 = socket_accept($socket);

echo "Cliente 1 conectado.\n";

// Notificando o cliente 1 que ele é o jogador 1
socket_write($clientSocket1, "Você é o Jogador 1.\n");

// Aceitando uma conexão e criando um novo socket para comunicação com o cliente 2
$clientSocket2 = socket_accept($socket);

echo "Cliente 2 conectado.\n";

// Notificando o cliente 2 que ele é o jogador 2
socket_write($clientSocket2, "Você é o Jogador 2.\n");

// Inicializando o jogo
$game = new RestaUm();

// Loop principal para receber e enviar dados entre os jogadores
while (true) {
    // Recebendo dados do cliente 1
    $data1 = socket_read($clientSocket1, 1024);
    if ($data1 !== false && $data1 !== '') {
        echo "Cliente 1: " . $data1 . "\n";
        // Enviando dados do cliente 1 para o cliente 2
        socket_write($clientSocket2, $data1, strlen($data1));
    }

    // Recebendo dados do cliente 2
    $data2 = socket_read($clientSocket2, 1024);
    if ($data2 !== false && $data2 !== '') {
        echo "Cliente 2: " . $data2 . "\n";
        // Enviando dados do cliente 2 para o cliente 1
        socket_write($clientSocket1, $data2, strlen($data2));
    }
}

// Fechando os sockets
socket_close($clientSocket1);
socket_close($clientSocket2);
socket_close($socket);

?>
