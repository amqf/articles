<?php

$host = '127.0.0.1';
$port = 8080;

// Criação do socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if ($socket === false) {
    echo "Erro ao criar socket: " . socket_strerror(socket_last_error()) . "\n";
    exit;
}

// Ligação ao host e porta
$result = socket_bind($socket, $host, $port);

if ($result === false) {
    echo "Erro ao ligar socket: " . socket_strerror(socket_last_error($socket)) . "\n";
    socket_close($socket);
    exit;
}

// Escuta por conexões

$result = socket_listen($socket, 5);

if ($result === false) {
    echo "Erro ao escutar: " . socket_strerror(socket_last_error($socket)) . "\n";
    socket_close($socket);
    exit;
}

echo "Servidor pronto e escutando em $host:$port\n";

// Aceita uma conexão
$client = socket_accept($socket);

if ($client === false) {
    echo "Erro ao aceitar conexão: " . socket_strerror(socket_last_error($socket)) . "\n";
    socket_close($socket);
    exit;
}

// Recebe dados
$data = socket_read($client, 1024);

echo "Recebido: $data\n";

// Envia resposta
socket_write($client, "Mensagem recebida!\n");

// Fecha conexões
socket_close($client);
socket_close($socket);