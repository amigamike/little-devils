<?php

/**
 * Standard exception.
 *
 * @package     MikeWelsh\LittleDevils\Exceptions\Exception
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Exceptions;

use MikeWelsh\LittleDevils\Helpers\HTTPStatusCodeHelper;

class Exception extends \Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Bad Request';

    /**
     * Code.
     * @var int
     */
    protected $code = 405;

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

    public function __construct(string $message = 'Bad Request', int $code = 405, $data = null)
    {
        /*
         * Set the message.
         */
        $this->message = $message;

        /*
         * Set the data.
         */
        $this->data = $data;

        /*
         * Construct the header.
         */
        if (php_sapi_name() != 'cli') {
            header($this->getStatusCode(), true, $this->code);
        }

        /*
         * Trigger the parent exception build.
         */
        parent::__construct($this->message, $this->code);
    }

    /**
     * Get the data of the exception.
     *
     * @return mixed $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the HTTP status code of the exception.
     *
     * @return string
     */
    public function getStatusCode()
    {
        return HTTPStatusCodeHelper::get($this->code);
    }
}
