<?php

/**
 * Request helper.
 *
 * @package     MikeWelsh\LittleDevils\Helpers\RequestHelper
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Helpers;

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;

class RequestHelper
{
    /**
     * Get the request data.
     */
    public static function get()
    {
        return $_REQUEST;
    }
}
