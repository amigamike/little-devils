<?php

/**
 * Rooms controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\RoomsController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Exceptions\RoomException;
use MikeWelsh\LittleDevils\Models\Room;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class RoomsController
{
    public static function list()
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new Room())->all();

        return new JsonResponse(
            'Rooms list',
            $data
        );
    }
}
