<?php

/**
 * Api controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\ApiController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Helpers\StringHelper;
use MikeWelsh\LittleDevils\Models\ApiKey;

class ApiController
{
    public function __construct()
    {
        //
    }

    /**
     * Create an Api key.
     * @return void
     */
    public function createKey()
    {
        /*
         * Define the console conntroller.
         */
        $console = new ConsoleController();

        /*
         * Inform the user of the creation.
         */
        $console->output('Creating an API key');

        /*
         * Define the Api key model.
         */
        $apiKey = new ApiKey();

        /*
         * Generate a random key.
         */
        $apiKey->key = StringHelper::random();

        /*
         * Save the key to the db.
         */
        $apiKey->save();

        /*
         * Output the key to the console for the user.
         */
        $console->output('Key: ' . $apiKey->key);
    }
}
