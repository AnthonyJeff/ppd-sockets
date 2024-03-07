<?php
// Definir host e porta
$host = '127.0.0.1';
$port = 8080;

// Crie um socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Vincular o socket ao endereço e porta
socket_bind($socket, $host, $port);

// Iniciar escuta por conexões
socket_listen($socket);

echo "Servidor de chat iniciado em $host:$port\n";

// Array para armazenar clientes
$clients = array();

// Loop para aceitar conexões
while (true) {
    // Aceitar uma nova conexão
    $new_socket = socket_accept($socket);

    // Ler a identificação do cliente
    $id = uniqid();
    $clients[$id] = $new_socket;

    // Mensagem de boas-vindas
    socket_write($new_socket, "Bem-vindo ao chat! Seu ID é $id\n");

    // Enviar mensagem de conexão para outros clientes
    foreach ($clients as $client) {
        if ($client !== $new_socket) {
            socket_write($client, "Novo cliente conectado\n");
        }
    }

    // Iniciar uma thread para lidar com as mensagens deste cliente
    new ClientThread($id, $new_socket, $clients);
}

// Classe para lidar com mensagens de clientes em threads separadas
class ClientThread extends Thread {
    private $id;
    private $socket;
    private $clients;

    public function __construct($id, $socket, &$clients) {
        $this->id = $id;
        $this->socket = $socket;
        $this->clients = &$clients;
        $this->start();
    }

    public function run() {
        while (true) {
            // Ler a mensagem do cliente
            $msg = socket_read($this->socket, 1024);
            if ($msg === false) {
                // Cliente desconectado
                socket_close($this->socket);
                unset($this->clients[$this->id]);
                foreach ($this->clients as $client) {
                    socket_write($client, "Cliente $this->id desconectado\n");
                }
                break;
            }

            // Enviar mensagem para todos os outros clientes
            foreach ($this->clients as $id => $client) {
                if ($id !== $this->id) {
                    socket_write($client, "Cliente $this->id: $msg");
                }
            }
        }
    }
}
