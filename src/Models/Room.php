<?php

/**
 * Room model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Room
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class Room extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'rooms';

    public $id = 0;
    public $name = '';
}
