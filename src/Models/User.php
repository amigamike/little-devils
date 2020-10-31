<?php

/**
 * User model.
 *
 * @package     MikeWelsh\LittleDevils\Models\User
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class User extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'users';

    public $id = 0;
    public $site_id = 0;
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $status = 'active';

    public function getByApiKey($key)
    {
        //
    }
}
