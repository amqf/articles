<?php

$host = '127.0.0.1';
$port = 8080;
$message = "Olá, servidor!";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if ($socket === false) {
    echo "Erro ao criar socket: " . socket_strerror(socket_last_error()) . "\n";
    exit;
}

$result = socket_connect($socket, $host, $port);

if ($result === false) {
    echo "Erro ao conectar: " . socket_strerror(socket_last_error($socket)) . "\n";
    exit;
}

socket_write($socket, $message, strlen($message));

$response = socket_read($socket, 1024);

echo "Resposta do servidor: $response\n";
socket_close($socket);