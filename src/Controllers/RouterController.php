<?php

/**
 * Router controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\RouterController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\SiteController;
use MikeWelsh\LittleDevils\Exceptions\MethodNotAllowedException;
use MikeWelsh\LittleDevils\Helpers\PathHelper;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

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

    private $requestMethods = [
        'POST',
        'PUT',
        'PATCH'
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
         * Get the path.
         */
        $path = PathHelper::getPath();

        /*
         * Define the route parameters.
         */
        $routeParams = [];

        /*
         * Save the request data if any to the route params.
         */
        if (!empty($_REQUEST)) {
            $routeParams = array_merge($routeParams, $_REQUEST);
        }

        /*
         * Get the current site.
         */
        $routeParams['site'] = (new SiteController())->getSite();

        /*
         * Check to see if the route has any parameters.
         */
        if (strpos($route, '{') !== false) {
            $routeParams = $this->routeArguments($route, $path);
            $route = $routeParams[0];
            $routeParams = $routeParams[1];
        }

        /*
         * Json content so get what is passed over in the request.
         */
        if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
            $request = file_get_contents("php://input");
            
            if ($request) {
                $request = json_decode($request);
                if (is_object($request)) {
                    $request = (array) $request;
                }
                if ($request) {
                    $routeParams = array_merge($routeParams, $request);
                }
            }
        }

        /*
         * Check to see if its an api call.
         */
        if (strpos($path, '/api') !== false) {
            $_REQUEST['api'] = true;
            $routeParams['api'] = true;
        }

        /*
         * Save the request data if any to the route params.
         */
        if (!empty($_REQUEST)) {
            $routeParams = array_merge($routeParams, $_REQUEST);
        }

        /*
         * Check to see if the route matches the requested URI.
         */
        if (rtrim($route, '/') == $path && $requestMethod == $method) {
            $this->found = true;
            call_user_func_array($func, [$routeParams]);
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
            if (isset($_REQUEST['api'])) {
                return new JsonResponse(
                    'Endpoint not found',
                    null,
                    'error',
                    404
                );
            }

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
