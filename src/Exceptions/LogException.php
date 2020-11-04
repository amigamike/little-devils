<?php

/**
 * Log exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\LogException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class LogException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Log exception';

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

    public function __construct(string $message = 'Log exception')
    {
        parent::__construct($message, $this->code);
    }
}
