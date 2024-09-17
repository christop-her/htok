<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
use MyApp\Message;
// use MyApp\MessageSeen;
// use MyApp\Immconnect;
// use MyApp\Nounread;
// use MyApp\BackRead;
// use MyApp\DeleteNoUnread;
use React\EventLoop\Factory;
use React\Socket\Server as ReactServer;

require dirname(__DIR__) . '/vendor/autoload.php';

// Create event loop
$loop = Factory::create();

// Setup the Chat server
$chatWebSocket = new WsServer(new Chat());
$chatServer = new IoServer(
    new HttpServer($chatWebSocket),
    new ReactServer('0.0.0.0:8080', $loop),
    $loop
);

// Setup the Follow server
$messageWebSocket = new WsServer(new Message());
$messageServer = new IoServer(
    new HttpServer($messageWebSocket),
    new ReactServer('0.0.0.0:8081', $loop),
    $loop
);

// $MessageSeenWebSocket = new WsServer(new MessageSeen());
// $MessageSeenServer = new IoServer(
//     new HttpServer($MessageSeenWebSocket),
//     new ReactServer('0.0.0.0:8082', $loop),
//     $loop
// );

// $ImmconnectWebSocket = new WsServer(new Immconnect());
// $ImmconnectServer = new IoServer(
//     new HttpServer($ImmconnectWebSocket),
//     new ReactServer('0.0.0.0:8083', $loop),
//     $loop
// );

// $NounreadWebSocket = new WsServer(new Nounread());
// $NounreadServer = new IoServer(
//     new HttpServer($NounreadWebSocket),
//     new ReactServer('0.0.0.0:8084', $loop),
//     $loop
// );

// $BackReadWebSocket = new WsServer(new BackRead());
// $BackReadServer = new IoServer(
//     new HttpServer($BackReadWebSocket),
//     new ReactServer('0.0.0.0:8085', $loop),
//     $loop
// );

// $DeleteNoUnreadWebSocket = new WsServer(new DeleteNoUnread());
// $DeleteNoUnreadServer = new IoServer(
//     new HttpServer($DeleteNoUnreadWebSocket),
//     new ReactServer('0.0.0.0:8086', $loop),
//     $loop
// );

// Run the event loop
echo "WebSocket servers are running\n";
$loop->run();
