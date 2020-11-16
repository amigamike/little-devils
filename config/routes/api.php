<?php

/**
 * Api routes.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 * @link        https://amigamike.com
 */

$router->get(
    '/api/rooms',
    'MikeWelsh\LittleDevils\Controllers\RoomsController::list'
);

$router->get(
    '/api/stats/rooms',
    'MikeWelsh\LittleDevils\Controllers\RoomsController::stats'
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

$router->patch(
    '/api/invoices/{id}',
    'MikeWelsh\LittleDevils\Controllers\InvoicesController::paid'
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

$router->get(
    '/api/stats/people',
    'MikeWelsh\LittleDevils\Controllers\PeopleController::stats'
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
