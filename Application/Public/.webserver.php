<?php

require_once dirname(dirname(__DIR__)) .
             DIRECTORY_SEPARATOR . 'Data' .
             DIRECTORY_SEPARATOR . 'Core.link.php';

use Hoa\Router;
use Hoa\Dispatcher;
use Hoa\File;
use Hoa\Mime;

$router = new Router\Http();
$router
    ->any('a', '.*', function ( Dispatcher\Kit $_this ) {

        $uri  = $_this->router->getURI();
        $file = __DIR__ . DS . $uri;

        if(!empty($uri) && true === file_exists($file)) {

            $stream = new File\Read($file);
            $mime   = new Mime($stream);

            header('Content-Type: ' . $mime->getMime());
            echo $stream->readAll();

            return;
        }

        require 'index.php';
    });

$dispatcher = new Dispatcher\Basic();
$dispatcher->dispatch($router);
