<?php

/**
 * Logs controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\LogsController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Exceptions\LogException;
use MikeWelsh\LittleDevils\Models\Log;
use MikeWelsh\LittleDevils\Models\User;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class LogsController
{
    public static function add($params)
    {
        /*
         * Validate the api key.
         */
        if ($params['api']) {
            (new AuthenticationController())->validApi();
        }

        $data = new Log();

        if ($params['api']) {
            self::required($params);
        }

        $data = self::set($params, $data);

        $data->save();

        $user = (new User())->getById($data->user_id);

        $data->group_name = $user->group_name;

        if ($params['api']) {
            return new JsonResponse(
                'Person added',
                $data
            );
        } else {
            return true;
        }
    }

    public static function delete($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new Log())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Log not found');
        }

        $data->delete();

        return new JsonResponse(
            'Log deleted',
            $data
        );
    }

    public static function list($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $model = new Log();

        if (!empty($params['person'])) {
            $model->filter('person_id', $params['person']);
        }

        $data = $model->all();

        return new JsonResponse(
            'Logs list',
            $data
        );
    }

    private static function required($params)
    {
        $required = [
            "person_id",
            "type",
            "info"
        ];

        $missing = [];
        foreach ($required as $key) {
            if (empty($params[$key])) {
                $missing[] = $key;
            }
        }

        if ($missing) {
            throw new LogException('Missing required data', $missing);
        }
    }

    private static function set($params, $data)
    {
        foreach ($data as $key => $value) {
            if (isset($params[$key])) {
                $data->$key = $params[$key];
            }
        }

        $data->user_id = $_REQUEST[AuthenticationController::SESSION_NAME]->id;

        return $data;
    }
}
