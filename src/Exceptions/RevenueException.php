<?php

/**
 * Revenue exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\RevenueException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class RevenueException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Revenue exception';

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

    public function __construct(string $message = 'Revenue exception')
    {
        parent::__construct($message, $this->code);
    }
}
