<?php

/**
 * Rooms controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\RoomsController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

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

        $model = new Room();

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
            'Rooms list',
            $data,
            'success',
            200,
            $model->pagination
        );
    }

    /**
     * Get the room stats
     *
     * @param array $params
     * @return JsonResponse
     */
    public static function stats(array $params)
    {
        $model = (new Room())
            ->order('name', 'ASC');

        $query = 'SELECT 
        rooms.*,
        (
            SELECT 
                count(id) 
            FROM 
                people 
            WHERE 
                `type`="child" AND
                `room_id`=rooms.id
        ) AS `children`,
        (
            SELECT 
                count(id) 
            FROM 
                users 
            WHERE 
                `room_id`=rooms.id
        ) AS `staff`
        FROM rooms WHERE rooms.deleted_at IS NULL AND rooms.site_id=' . $params['site']->id;

        $stats = $model->selectArray($query);
    
        return new JsonResponse(
            'Room stats',
            $stats
        );
    }
}
