<?php

/**
 * Revenue controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\RevenueController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Exceptions\RevenueException;
use MikeWelsh\LittleDevils\Models\Revenue;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class RevenueController
{
    public static function add($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = new Revenue();

        self::required($params);

        $data = self::set($params, $data);

        $data->save();

        return new JsonResponse(
            'Revenue added',
            $data
        );
    }

    public static function delete($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new Revenue())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Revenue not found');
        }

        $data->delete();

        return new JsonResponse(
            'Revenue deleted',
            $data
        );
    }

    public static function list($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $model = new Revenue();

        if (!empty($params['year'])) {
            $model->filterBetween(
                'period',
                $params['year'] . '-01-01',
                $params['year'] . '-12-31'
            );
        }

        if (!empty($params['room'])) {
            $model->filter(
                'room_id',
                $params['room']
            );
        }

        $model->order('period');

        $data = $model->all();

        return new JsonResponse(
            'Revenue list',
            $data
        );
    }

    private static function required($params)
    {
        $required = [
            "room_id",
            "period",
            "room_fee",
            "funding",
            "total"
        ];

        $missing = [];
        foreach ($required as $key) {
            if (empty($params[$key])) {
                $missing[] = $key;
            }
        }

        if ($missing) {
            throw new RevenueException('Missing required data', $missing);
        }
    }

    private static function set($params, $data)
    {
        foreach ($data as $key => $value) {
            if (isset($params[$key])) {
                $data->$key = $params[$key];
            }
        }
        return $data;
    }
}
