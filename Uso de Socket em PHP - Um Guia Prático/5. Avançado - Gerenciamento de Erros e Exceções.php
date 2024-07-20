<?php

use Socket;

/**
 * Cria 
 */
function createSocket(string $host, string $port) : Socket
{
    $socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        throw new Exception("Erro ao criar socket: " . socket_strerror(socket_last_error()));
    }
    $result = @socket_bind($socket, $host, $port);
    if ($result === false) {
        throw new Exception("Erro ao ligar socket: " . socket_strerror(socket_last_error($socket)));
    }
    return $socket;
}

try {
    /** @var Socket $socket */
    $socket = createSocket('127.0.0.1', 8081);
    socket_listen($socket);
    echo "Servidor pronto.\n";

    // Implemente a lógica do servidor aqui
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} finally {
    // Garanta a liberação do recurso aqui encerrando a conexão
    socket_close($socket);
}