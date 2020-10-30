<?php

/**
 * Not found exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\NotFoundException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class NotFoundException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Page Not found';

    /**
     * Code.
     * @var int
     */
    protected $code = 404;

    /**
     * Status.
     * @var string
     */
    protected $status = 'error';

    public function __construct(string $message = 'Page Not found', $data = null)
    {
        $this->message = $message;
        $this->data = $data;

        parent::__construct($this->message, $this->code, $this->data);
    }
}
