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
use MikeWelsh\LittleDevils\Models\Site;

class User extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'users';

    public $id = 0;
    public $site_id = 0;
    public $group_id = 0;
    public $room_id = 0;
    public $api_key = '';
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $status = 'active';

    public function getByApiKey($key)
    {
        return $this->select(
            'SELECT * FROM ' . $this->table . ' WHERE api_key=:api_key',
            [
                ':api_key' => $key
            ]
        );
    }

    public function getById($id)
    {
        return $this->select(
            'SELECT
                u.*,
                groups.name AS group_name 
            FROM ' . $this->table . ' as u 
            JOIN groups ON groups.id = u.group_id AND groups.deleted_at IS NULL 
            WHERE u.id=:id',
            [
                ':id' => $id
            ]
        );
    }

    public function login(Site $site, string $email, string $password)
    {
        return $this->select(
            'SELECT * FROM ' . $this->table . ' 
            WHERE 
                email = :email AND
                password = :password AND
                site_id = :site_id',
            [
                ':email' => $email,
                ':password' => $password,
                ':site_id' => $site->id
            ]
        );
    }
}
