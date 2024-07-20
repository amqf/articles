<?php
$socket_path = '/tmp/mysocket';

$server = socket_create(AF_UNIX, SOCK_STREAM, 0);
if ($server === false) {
    echo "Erro ao criar socket: " . socket_strerror(socket_last_error()) . "\n";
    exit;
}

if (socket_bind($server, $socket_path) === false) {
    echo "Erro ao vincular socket: " . socket_strerror(socket_last_error($server)) . "\n";
    socket_close($server);
    exit;
}

if (socket_listen($server, 5) === false) {
    echo "Erro ao escutar no socket: " . socket_strerror(socket_last_error($server)) . "\n";
    socket_close($server);
    exit;
}

echo "Servidor Unix Socket iniciado e escutando em $socket_path\n";

while (true) {
    $client = socket_accept($server);
    if ($client === false) {
        echo "Erro ao aceitar conexão: " . socket_strerror(socket_last_error($server)) . "\n";
        continue;
    }

    $msg = socket_read($client, 1024);
    echo "Recebido: $msg\n";
    socket_write($client, "Mensagem recebida!", 16);

    socket_close($client);
}

socket_close($server);