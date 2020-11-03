<?php

/**
 * Log model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Log
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class Log extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'logs';

    public $id = 0;
    public $user_id = 0;
    public $person_id = 0;
    public $type = 'Accident';
    public $info = '';
}
