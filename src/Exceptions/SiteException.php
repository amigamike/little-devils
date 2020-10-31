<?php

/**
 * Site exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\SiteException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class SiteException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Site exception';

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

    public function __construct(string $message = 'Site exception')
    {
        $this->message = $message;

        parent::__construct($this->message, $this->code);
    }
}