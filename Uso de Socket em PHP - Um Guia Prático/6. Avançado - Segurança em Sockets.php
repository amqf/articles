<?php

/** @var resource — A stream context resource */
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true,
        'allow_self_signed' => false,
    ],
]);

/** @var resource|false — The created stream, or false on error */
$socket = stream_socket_server("tls://$host:$port", $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $context);

if (!$socket) {
    echo "Erro ao criar socket: $errstr ($errno)\n";
    exit;
}