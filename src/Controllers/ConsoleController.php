<?php

/**
 * Console controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\ConsoleController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

class ConsoleController
{
    public function __construct()
    {
        //
    }

    public function done(string $message)
    {
        echo "\e[0;34;40m" . $message . "\e[0m\n";
    }

    public function error(string $message)
    {
        echo "\e[1;37;41m" . $message . "\e[0m\n";
    }

    public function info(string $message)
    {
        echo "\e[1;32;40m" . $message . "\e[0m\n";
    }

    public function input(string $message)
    {
        echo "\e[1;36;40m" . $message . "\e[0m\n";
    }

    public function output(string $message)
    {
        echo "\e[1;37;40m" . $message . "\e[0m\n";
    }

    public function title(string $message)
    {
        echo "\e[1;33;40m" . $message . "\e[0m\n";
    }
}
