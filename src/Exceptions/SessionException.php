<?php

/**
 * Session exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\SessionException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class SessionException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Session exception';

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

    public function __construct(string $message = 'Session exception')
    {
        $this->message = $message;

        parent::__construct($this->message, $this->code);
    }
}