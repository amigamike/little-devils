<?php

/**
 * People controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\PeopleController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Models\People;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class PeopleController
{
    public function list()
    {
        $data = (new People())->all();

        return new JsonResponse(
            'People list',
            $data
        );
    }
}
