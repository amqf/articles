<?php
$socket_path = '/tmp/mysocket';

try {
    $server = socket_create(AF_UNIX, SOCK_STREAM, 0);
    if ($server === false) {
        throw new Exception("Erro ao criar socket: " . socket_strerror(socket_last_error()));
    }

    if (socket_bind($server, $socket_path) === false) {
        throw new Exception("Erro ao vincular socket: " . socket_strerror(socket_last_error($server)));
    }

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
        socket_write($client, "Mensagem recebida!", 16);
        socket_close($client);
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} finally {
    if (isset($server)) {
        socket_close($server);
    }
}

