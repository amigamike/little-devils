<?php

/**
 * Contact model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Contact
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class Contact extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'contacts';

    public $id = 0;
    public $child_id = 0;
    public $person_id = 0;
}
