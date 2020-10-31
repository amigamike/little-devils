<?php

/**
 * Security helper.
 *
 * @package     MikeWelsh\LittleDevils\Helpers\SecurityHelper
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Helpers;

use MikeWelsh\LittleDevils\Controllers\SessionController;

class SecurityHelper
{
    /**
     * Encrypt some data.
     *
     * @return string
     */
    public static function encrypt($data): string
    {
        /*
         * Hash the data.
         */
        return hash('sha256', $data);
    }

    /**
     * Get and return the cross site scripting key from the session.
     *
     * @return string
     */
    public static function cssKey(): string
    {
        $key = (new SessionController())->get('css_key');

        if (empty($key)) {
            $key = (new StringHelper())->random(32);
            (new SessionController())->set('css_key', $key);
        }

        return $key;
    }

    /**
     * Check to make sure the css key is valid.
     *
     * @param string $check
     * @return bool
     */
    public static function cssKeyValid(string $check): bool
    {
        $key = (new SessionController())->get('css_key');
        
        if ($key == $check) {
            return true;
        }

        return false;
    }
}
