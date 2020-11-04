<?php

/**
 * Invoices controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\InvoicesController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Exceptions\InvoiceException;
use MikeWelsh\LittleDevils\Models\Invoice;
use MikeWelsh\LittleDevils\Models\User;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class InvoicesController
{
    public static function add($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = new Invoice();

        self::required($params);

        $data = self::set($params, $data);

        $data->save();

        $data->user = (new User())->getById($data->user_id);

        return new JsonResponse(
            'Invoice added',
            $data
        );
    }

    public static function delete($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new Invoice())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Invoice not found');
        }

        $data->delete();

        return new JsonResponse(
            'Invoice deleted',
            $data
        );
    }

    public static function list($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $model = new Invoice();

        if (!empty($params['person'])) {
            $model->filter('person_id', $params['person']);
        }

        $data = $model->all();

        return new JsonResponse(
            'Invoices list',
            $data
        );
    }

    private static function required($params)
    {
        $required = [
            "person_id",
            "type",
            "amount"
        ];

        $missing = [];
        foreach ($required as $key) {
            if (empty($params[$key])) {
                $missing[] = $key;
            }
        }

        if ($missing) {
            throw new InvoiceException('Missing required data', $missing);
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
