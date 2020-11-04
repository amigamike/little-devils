<?php

/**
 * Invoice exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\InvoiceException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class InvoiceException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Invoice exception';

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

    public function __construct(string $message = 'Invoice exception')
    {
        parent::__construct($message, $this->code);
    }
}
