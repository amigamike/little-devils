<?php

/**
 * Router controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\RouterController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Exceptions\MethodNotAllowedException;
use MikeWelsh\LittleDevils\Helpers\PathHelper;

class RouterController
{
    /**
     * Valid methods.
     * @var array
     */
    private $methods = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE'
    ];

    /**
     * Indicate whether the route is found or not.
     */
    private $found = false;

    /**
     * Determine the route.
     *
     * @return null
     */
    public function __call($method, $arguments)
    {
        /*
         * If the route is already found, just return null.
         */
        if ($this->found) {
            return null;
        }

        /*
         * Split the arguments up.
         */
        list($route, $func) = $arguments;

        /*
         * Check to see that the request method is supported.
         */
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (!in_array($requestMethod, $this->methods)) {
            throw new MethodNotAllowed('Request method is not supported');
        }

        /*
         * Check to see that the route method is supported.
         */
        $method = strtoupper($method);
        if (!in_array($method, $this->methods)) {
            throw new MethodNotAllowed('Route method is not supported');
        }

        /*
         * Check to see if the route matches the requested URI.
         */
        if (rtrim($route, '/') == PathHelper::getPath()) {
            $this->found = true;
            call_user_func_array($func, []);
        }
        
        return null;
    }

    /**
     * If the route is not found, through a page not found error.
     *
     * @return null
     */
    public function notFound()
    {
        /*
         * If the page is not found, throw the page not found error.
         */
        if (!$this->found) {
            header("404 Page Not Found", true, 404);
            echo 'Page not found';
        }

        return null;
    }
}
