<?php

/**
 * Person exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\PersonException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class PersonException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Person exception';

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

    public function __construct(string $message = 'Person exception', $data = [])
    {
        parent::__construct($message, $this->code, $data);
    }
}
