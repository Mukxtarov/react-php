<?php
require __DIR__."/vendor/autoload.php";

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Message\Response;
use React\Http\Server;
use React\Socket\Server as SocketServer;
use React\Stream\ReadableResourceStream;

$loop = Factory::create();


$server = new Server($loop, function (ServerRequestInterface $request) use ($loop) {
    $file = "video.mp4";

    $video = new ReadableResourceStream(fopen($file, 'r'), $loop);
    return new Response(200, ['Content-type' => "video/mp4"], $video);
});


$socket = new SocketServer("91.127.173.111:8080", $loop);
$server->listen($socket);

print_r("Server run ".str_replace('tcp:', 'http:', $socket->getAddress())."\n");

$loop->run();