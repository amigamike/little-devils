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
    public $site_id = 0;
    public $capacity = 0;
    public $name = '';
    public $status = '';

    /**
     * Return all the entries.
     *
     * @return array $return
     */
    public function all(string $query = ''): array
    {
        return parent::all(
            'SELECT
                (SELECT count(id) FROM people WHERE room_id = r.id AND `type`="child" AND people.deleted_at IS NULL) AS children,
                (SELECT count(id) FROM users WHERE room_id = r.id AND users.deleted_at IS NULL) AS staff,
                r.*
            FROM ' . $this->table . ' r ' .
            'WHERE r.deleted_at IS NULL'
        );
    }
}
