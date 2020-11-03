<?php

/**
 * Room exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\RoomException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class RoomException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Room exception';

    /**
     * Code.
     * @var int
     */
    protected $code = 400;

    /**
     * Status.
     * @var string
     */
    protected $status = 'error';

    public function __construct(string $message = 'Room exception')
    {
        parent::__construct($message, $this->code);
    }
}
