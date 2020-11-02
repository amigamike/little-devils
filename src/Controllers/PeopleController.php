<?php

/**
 * People controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\PeopleController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Models\People;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class PeopleController
{
    public static function get($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new People())->getById($params['id']);

        return new JsonResponse(
            'Found the person',
            $data
        );
    }

    public static function list()
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new People())->all();

        return new JsonResponse(
            'People list',
            $data
        );
    }
}
