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
use MikeWelsh\LittleDevils\Exceptions\NotFoundException;
use MikeWelsh\LittleDevils\Exceptions\PersonException;
use MikeWelsh\LittleDevils\Helpers\RequestHelper;
use MikeWelsh\LittleDevils\Models\Contact;
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

    public static function list($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $model = new People();

        if (!empty($params['type'])) {
            $model->filter('type', $params['type']);
        }

        if (!empty($params['sort'])) {
            $direction = 'ASC';
            if (!empty($params['sd'])) {
                $direction = strtoupper($params['sd']);
            }
            $model->order($params['sort'], $direction);
        }

        if (!empty($params['query'])) {
            $model->likeOr(
                [
                    'first_name',
                    'last_name'
                ],
                $params['query']
            );
        }

        $data = $model
            ->paginate(
                (!empty($params['page']) ? intval($params['page']) : 1),
                (!empty($params['per_page']) ? intval($params['per_page']) : 25)
            )
            ->all();

        return new JsonResponse(
            'People list',
            $data,
            'success',
            200,
            $model->pagination
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

            $contact = (new Contact())->getByIds($data->id, $params['child_id']);
            if (empty($contact)) {
                $contact = new Contact();
                $contact->person_id = $data->id;
                $contact->child_id = $params['child_id'];
                $contact->save();
            } else {
                $contact->deleted_at = null;
                $contact->update();
            }
        }
    }
}
