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

        $path = PathHelper::getPath();

        $routeArguments = [];

        /*
         * Check to see if the route has any parameters.
         */
        if (strpos($route, '{') !== false) {
            $routeArguments = $this->routeArguments($route, $path);
            $route = $routeArguments[0];
            $routeArguments = $routeArguments[1];
        }

        /*
         * Check to see if the route matches the requested URI.
         */
        if (rtrim($route, '/') == $path) {
            $this->found = true;
            call_user_func_array($func, [$routeArguments]);
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

    /**
     * Clean the route and replace the arguments with that of those in the path.
     *
     * @param string $route
     * @param string $path
     * @return array
     */
    private function routeArguments(string $route, string $path)
    {
        /*
         * Define the arguments.
         */
        $arguments = [];

        /*
         * Get the arguements of the route.
         */
        preg_match_all('/{(.*?)}/', $route, $matched);

        /*
         * If there are arguments, process them.
         */
        if (!empty($matched[1])) {
            /*
             * Strip the non arguments part from the path.
             */
            $stripped = str_replace(
                rtrim(str_replace(implode('/', $matched[0]), '', $route), '/'),
                '',
                $path
            );

            /*
             * Get the values for the arguments.
             */
            if ($replacements = explode('/', ltrim($stripped, '/'))) {
                /*
                 * Loop through the replacement values and replace the
                 * argument in the route string with the correct value.
                 */
                foreach ($replacements as $key => $value) {
                    /*
                     * If there is an actual argument that matches the replacement.
                     */
                    if (!empty($matched[1][$key])) {
                        $arguments[$matched[1][$key]] = $value;
                        $route = preg_replace('/' . $matched[0][$key] . '/', $value, $route);
                    }
                }
            }
        }

        /*
         * Return the data.
         */
        return [$route, $arguments];
    }
}
