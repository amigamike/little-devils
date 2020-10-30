<?php

/**
 * Api key model.
 *
 * @package     MikeWelsh\LittleDevils\Models\ApiKey
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class ApiKey extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'api_keys';

    public $id = 0;
    public $key = '';
}
