Para lidar com várias conexões simultâneas, podemos usar `socket_select`, permitindo que o servidor gerencie múltiplos clientes de maneira eficiente.

```php
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

$clients = [$server];

while (true) {
    $read = $clients;
    $write = null;
    $except = null;

    socket_select($read, $write, $except, null);

    foreach ($read as $client) {
        if ($client === $server) {
            $new_client = socket_accept($server);
            $clients[] = $new_client;
            echo "Novo cliente conectado.\n";
        } else {
            $data = socket_read($client, 1024);
            if ($data === false) {
                $key = array_search($client, $clients);
                unset($clients[$key]);
                socket_close($client);
                echo "Cliente desconectado.\n";
            } else {
                echo "Recebido: $data\n";
                socket_write($client, "Mensagem recebida!", 16);
            }
        }
    }
}

socket_close($server);