<?php

/**
 * Authentication exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\AuthenticationException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class AuthenticationException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Access denied';

    /**
     * Code.
     * @var int
     */
    protected $code = 401;

    /**
     * Status.
     * @var string
     */
    protected $status = 'error';

    public function __construct(string $message = 'Access denied')
    {
        $this->message = $message;

        parent::__construct($this->message, $this->code);
    }
}
