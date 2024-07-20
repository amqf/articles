<?php

$host = '127.0.0.1';
$port = 8080;
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

socket_bind($socket, $host, $port);

while (true) {
    $buf = '';
    $from = '';
    $port = 0;

    socket_recvfrom($socket, $buf, 1024, 0, $from, $port);
    echo "Recebido de $from:$port - $buf\n";
    socket_sendto($socket, "Mensagem recebida", strlen("Mensagem recebida"), 0, $from, $port);
}

socket_close($socket);