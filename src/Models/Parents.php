<?php

/**
 * Parents model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Parents
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class Parents extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'parents';

    public $id = 0;
    public $child_id = 0;
    public $parent_id = 0;

    public function getByIds($parent_id, $child_id)
    {
        return $this->select(
            'SELECT * FROM ' . $this->table . ' WHERE parent_id=:parent_id AND child_id=:child_id',
            [
                ':parent_id' => $parent_id,
                ':child_id' => $child_id
            ]
        );
    }
}
