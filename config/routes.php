<?php

/**
 * Little Devil's Nursery Management System.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 * @link        https://amigamike.com
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\RouterController;
use MikeWelsh\LittleDevils\Controllers\ViewController;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

try {
    $router = new RouterController();

    include('routes/api.php');
    include('routes/web.php');
    
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
