<?php
function createSocket($socket_path) {
    $socket = @socket_create(AF_UNIX, SOCK_STREAM, 0);
    if ($socket === false) {
        throw new Exception("Erro ao criar socket: " . socket_strerror(socket_last_error()));
    }

    if (@socket_bind($socket, $socket_path) === false) {
        throw new Exception("Erro ao vincular socket: " . socket_strerror(socket_last_error($socket)));
    }

    return $socket;
}

try {
    $socket_path = '/tmp/mysocket';
    $server = createSocket($socket_path);

    if (socket_listen($server, 5) === false) {
        throw new Exception("Erro ao escutar no socket: " . socket_strerror(socket_last_error($server)));
    }

    echo "Servidor Unix Socket iniciado e escutando em $socket_path\n";

    while (true) {
        $client = socket_accept($server);
        if ($client === false) {
            throw new Exception("Erro ao aceitar conexão: " . socket_strerror(socket_last_error($server)));
        }

        $msg = socket_read($client, 1024);
        if ($msg === false) {
            throw new Exception("Erro ao ler mensagem: " . socket_strerror(socket_last_error($client)));
        }

        echo "Recebido: $msg\n";
        socket_write($client, $msg, strlen($msg));
        socket_close($client);
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} finally {
    socket_close($server);
}