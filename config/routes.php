<?php

/**
 * Little Devil's Nursery Management System.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

use MikeWelsh\LittleDevils\Controllers\RouterController;
use MikeWelsh\LittleDevils\Controllers\ViewController;

try {
    $router = new RouterController();

    $router->get('/', function () {
        return (new ViewController('index'))->render();
    });

    $router->get('/login', function () {
        return (new ViewController('login'))->render();
    });

    $router->notFound();
} catch (\Exception $err) {
    echo $err->getMessage();
}
