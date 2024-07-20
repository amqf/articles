<?php
$socket_path = '/tmp/mysocket';

try {
    $client = socket_create(AF_UNIX, SOCK_STREAM, 0);
    if ($client === false) {
        throw new Exception("Erro ao criar socket: " . socket_strerror(socket_last_error()));
    }

    if (socket_connect($client, $socket_path) === false) {
        throw new Exception("Erro ao conectar ao servidor: " . socket_strerror(socket_last_error($client)));
    }

    $message = "Olá, servidor!";
    socket_write($client, $message, strlen($message));

    $response = socket_read($client, 1024);
    if ($response === false) {
        throw new Exception("Erro ao ler resposta: " . socket_strerror(socket_last_error($client)));
    }

    echo "Resposta do servidor: $response\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} finally {
    if (isset($client)) {
        socket_close($client);
    }
}