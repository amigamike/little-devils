<?php

/**
 * Template exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\TemplateException
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Exceptions\Exception;

class TemplateException extends Exception
{
    /**
     * Message.
     * @var string
     */
    public $message = 'Template exception';

    /**
     * Code.
     * @var int
     */
    public $code = 400;

    /**
     * Status.
     * @var string
     */
    public $status = 'error';

    public function __construct(string $message = 'Template exception')
    {
        parent::__construct($message, $this->code);
    }
}
