<?php
$socket_path = '/tmp/mysocket';

$client = socket_create(AF_UNIX, SOCK_STREAM, 0);
if ($client === false) {
    echo "Erro ao criar socket: " . socket_strerror(socket_last_error()) . "\n";
    exit;
}

if (socket_connect($client, $socket_path) === false) {
    echo "Erro ao conectar ao servidor: " . socket_strerror(socket_last_error($client)) . "\n";
    socket_close($client);
    exit;
}

$message = "Olá, servidor!";
socket_write($client, $message, strlen($message));

$response = socket_read($client, 1024);
echo "Resposta do servidor: $response\n";

socket_close($client);