<?php

/**
 * Contacts controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\ContactsController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Exceptions\NotFoundException;
use MikeWelsh\LittleDevils\Exceptions\PersonException;
use MikeWelsh\LittleDevils\Models\Contact;
use MikeWelsh\LittleDevils\Models\People;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class ContactsController
{
    public static function delete($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new Contact())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Contact not found');
        }

        $data->delete();

        return new JsonResponse(
            'Contact deleted',
            $data
        );
    }

    public static function save($params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $child = (new People())->getById($params['id']);

        if (empty($child)) {
            throw new NotFoundException('Person not found');
        }

        $required = [
            "title",
            "first_name",
            "last_name",
            "phone_no",
            "relationship"
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

        $data = new People();
        $data->type = 'contact';

        foreach ($data as $key => $value) {
            if (isset($params[$key])) {
                $data->$key = $params[$key];
            }
        }

        $data->save();

        $data->full_name = $data->first_name . ' ' . $data->last_name;

        $contact = new Contact();
        $contact->child_id = $child->id;
        $contact->person_id = $data->id;
        $contact->save();

        return new JsonResponse(
            'Person updated',
            $data
        );
    }
}
