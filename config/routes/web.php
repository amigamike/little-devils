<?php

/**
 * Web routes.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 * @link        https://amigamike.com
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\PeopleController;
use MikeWelsh\LittleDevils\Controllers\ViewController;
use MikeWelsh\LittleDevils\Exceptions\PersonException;
use MikeWelsh\LittleDevils\Helpers\PathHelper;

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

$router->get('/children/{id}', function ($params) {
    return (new ViewController('children/edit', $params))->render();
});

$router->post('/children/{id}', function ($params) {
    try {
        if (PeopleController::update($params)) {
            return ViewController::redirect(PathHelper::getFullPath());
        } else {
            return (new ViewController('children/edit', $params))->render();
        }
    } catch (PersonException $err) {
        $params['error'] = $err;
        return (new ViewController('children/edit', $params))->render();
    }
});

$router->get('/parents', function () {
    return (new ViewController('parents/index'))->render();
});

$router->get('/rooms', function () {
    return (new ViewController('rooms/index'))->render();
});
