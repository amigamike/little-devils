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
use MikeWelsh\LittleDevils\Exceptions\NotFoundException;
use MikeWelsh\LittleDevils\Exceptions\PersonException;
use MikeWelsh\LittleDevils\Helpers\RequestHelper;
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

        if (empty($data)) {
            throw new NotFoundException('Person not found');
        }

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

    public static function post($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new People())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Person not found');
        }

        $required = [
            "first_name",
            "last_name",
            "dob",
            "address_line_1",
            "city",
            "county",
            "postcode",
            "type"
        ];

        $missing = [];
        foreach ($required as $key) {
            if (empty($params[$key])) {
                $missing[] = $key;
            }
        }

        if ($missing) {
            throw new PersonException('Missing required data', $missing);
        }

        foreach ($data as $key => $value) {
            if (isset($params[$key])) {
                $data->$key = $params[$key];
            }
        }

        if ($data->dob) {
            $data->dob = date('Y-m-d', strtotime($data->dob));
        }

        $data->update();

        return new JsonResponse(
            'Person updated',
            $data
        );
    }
}
