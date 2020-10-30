<?php

/**
 * Database exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\DatabaseException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class DatabaseException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Database error';

    /**
     * Code.
     * @var int
     */
    protected $code = 500;

    /**
     * Data.
     * @var mixed
     */
    protected $data = null;

    /**
     * Status.
     * @var string
     */
    protected $status = 'error';

    public function __construct(string $message = 'Database error', $data = null)
    {
        $this->message = $message;
        $this->data = $data;

        parent::__construct($this->message, $this->code, $this->data);
    }
}