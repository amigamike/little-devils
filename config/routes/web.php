<?php

/**
 * Web routes.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 * @link        https://amigamike.com
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\ViewController;

$router->get('/', function () {
    return (new ViewController('index'))->render();
});

$router->get('/login', function () {
    return (new ViewController('login'))->render();
});

$router->post('/login', function () {
    (new AuthenticationController())->login($_POST);
});

$router->get('/logout', function () {
    (new AuthenticationController())->logout();
});

$router->get('/children', function () {
    return (new ViewController('children/index'))->render();
});
