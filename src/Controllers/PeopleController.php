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
use MikeWelsh\LittleDevils\Models\Parents;
use MikeWelsh\LittleDevils\Models\People;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class PeopleController
{
    public static function add($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = new People();

        self::required($params);

        $data = self::set($params, $data);

        $data->save();

        self::setParent($params, $data);

        return new JsonResponse(
            'Person added',
            $data
        );
    }

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

    private static function required($params)
    {
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
    }

    public static function save($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new People())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Person not found');
        }

        self::required($params);

        $data = self::set($params, $data);

        $data->update();

        self::setParent($params, $data);

        return new JsonResponse(
            'Person updated',
            $data
        );
    }

    private static function set($params, $data)
    {
        foreach ($data as $key => $value) {
            if (isset($params[$key])) {
                $data->$key = $params[$key];
            }
        }

        if ($data->dob) {
            $data->dob = date('Y-m-d', strtotime($data->dob));
        }

        return $data;
    }

    private static function setParent($params, $data)
    {
        if ($data->type == 'parent' && !empty($params['child_id'])) {
            $parent = (new Parents())->getByIds($data->id, $params['child_id']);
            if (empty($parent)) {
                $parent = new Parents();
                $parent->parent_id = $data->id;
                $parent->child_id = $params['child_id'];
                $parent->save();
            } else {
                $parent->deleted_at = null;
                $parent->update();
            }
        }
    }
}
