<?php

/**
 * Method not allowed exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\MethodNotAllowedException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class MethodNotAllowedException extends Exception
{
    /**
     * Message.
     * @var string
     */
    public $message = 'Unsupported method';

    /**
     * Code.
     * @var int
     */
    public $code = 405;

    /**
     * Status.
     * @var string
     */
    public $status = 'error';

    public function __construct(string $message = 'Unsupported method')
    {
        header("405 Method Not Allowed", true, $this->code);

        parent::__construct($message, $this->code);
    }
}
