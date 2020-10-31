<?php

/**
 * Session controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\SessionController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Helpers\StringHelper;
use MikeWelsh\LittleDevils\Models\ApiKey;

class SessionController
{
     /**
     * The name of the session.
     * @var string $name
     */
    protected $name = 'little_devils';

    /**
     * Clear the session.
     *
     * @return void
     */
    public function clear(string $var = '')
    {
        /*
         * If the var is passed, just clear that.
         */
        if ($var) {
            unset($_SESSION[$this->name][$var]);
            return;
        }

        /*
         * Kill the session.
         */
        session_destroy();
    }

    /**
     * Get the session data.
     *
     * @param string $var
     * @return mixed
     */
    public function get(string $var = '')
    {
        /*
         * If the variable is passed.
         */
        if (!empty($var)) {
            /*
             * If the session var is not found, throw an error.
             */
            if (empty($_SESSION[$this->name][$var])) {
                return null;
            }

            /*
             * Return the session var.
             */
            return $_SESSION[$this->name][$var];
        }

        /*
         * If there is no variable passed, just return the whole session.
         */
        return $_SESSION[$this->name];
    }

    /**
     * Init the session.
     *
     * @return void
     */
    public function init()
    {
        /*
         * Define the session.
         */

        session_start();
    }

    /**
     * Set session data.
     *
     * @param string $var
     * @param mixed $data
     * @return void
     */
    public function set(string $var, $data)
    {
        /*
         * Save to the session.
         */
        $_SESSION[$this->name][$var] = $data;
    }
}
