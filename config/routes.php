<?php

/**
 * Little Devil's Nursery Management System.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\RouterController;
use MikeWelsh\LittleDevils\Controllers\ViewController;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

try {
    $router = new RouterController();

    $router->get(
        '/api/rooms',
        'MikeWelsh\LittleDevils\Controllers\RoomsController::list'
    );

    $router->post(
        '/api/logs/add',
        'MikeWelsh\LittleDevils\Controllers\LogsController::add'
    );

    $router->delete(
        '/api/logs/{id}',
        'MikeWelsh\LittleDevils\Controllers\LogsController::delete'
    );

    $router->get(
        '/api/logs',
        'MikeWelsh\LittleDevils\Controllers\LogsController::list'
    );

    $router->post(
        '/api/invoices/add',
        'MikeWelsh\LittleDevils\Controllers\InvoicesController::add'
    );

    $router->delete(
        '/api/invoices/{id}',
        'MikeWelsh\LittleDevils\Controllers\InvoicesController::delete'
    );

    $router->get(
        '/api/invoices',
        'MikeWelsh\LittleDevils\Controllers\InvoicesController::list'
    );

    $router->get(
        '/api/revenue',
        'MikeWelsh\LittleDevils\Controllers\RevenueController::list'
    );

    $router->get(
        '/api/people',
        'MikeWelsh\LittleDevils\Controllers\PeopleController::list'
    );

    $router->get(
        '/api/people/{id}',
        'MikeWelsh\LittleDevils\Controllers\PeopleController::get'
    );

    $router->post(
        '/api/people/add',
        'MikeWelsh\LittleDevils\Controllers\PeopleController::add'
    );

    $router->post(
        '/api/people/{id}',
        'MikeWelsh\LittleDevils\Controllers\PeopleController::save'
    );

    $router->post(
        '/api/contacts/{id}',
        'MikeWelsh\LittleDevils\Controllers\ContactsController::save'
    );

    $router->delete(
        '/api/contacts/{id}',
        'MikeWelsh\LittleDevils\Controllers\ContactsController::delete'
    );

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
        /*
         * Define the view controller.
         */
        $view = new ViewController();

        /*
         * Get the error number to use as the template.
         */
        $template = $err->getCode();

        /*
         * Double check the template exists.
         */
        if (!$view->templateExists($template)) {
            /*
            * Default error template.
            */
            $tempate = 500;
        }

        /*
         * Render the error template.
         */
        $view->render($template, $err);
    }
}
