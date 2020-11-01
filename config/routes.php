<?php

/**
 * Little Devil's Nursery Management System.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\RouterController;
use MikeWelsh\LittleDevils\Controllers\PeopleController;
use MikeWelsh\LittleDevils\Controllers\ViewController;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

try {
    $router = new RouterController();

    $router->get('/', function () {
        return (new ViewController('index'))->render();
    });

    $router->get('/api/people/list', function () {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        /*
         * Get the people response.
         */
        return (new PeopleController())->list();
    });

    $router->get('/login', function () {
        return (new ViewController('login'))->render();
    });

    $router->get('/logout', function () {
        (new AuthenticationController())->logout();
    });

    $router->notFound();
} catch (\Exception $err) {
    if (!empty($_REQUEST['api'])) {
        return new JsonResponse(
            $err->getMessage(),
            $err->getData(),
            'error',
            $err->getCode()
        );
    } else {
        echo $err->getMessage();
    }
}
