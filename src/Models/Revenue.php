<?php

/**
 * Revenue model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Revenue
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Controllers\DatabaseController;
use MikeWelsh\LittleDevils\Models\Model;

class Revenue extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'revenue';

    public $id = 0;
    public $room_id = 0;
    public $period = '';
    public $room_fee = 0.00;
    public $funding = 0.00;
    public $total = 0.00;

    /**
     * Return all the entries.
     *
     * @return array $return
     */
    public function all(): array
    {
        /*
         * Define the db controller and trigger the select.
         */
        return (new DatabaseController())
            ->filters($this->filters)
            ->filtersBetween($this->filtersBetween)
            ->order($this->order)
            ->selectArray(
                get_class($this),
                'SELECT rev.*, rooms.name AS room_name FROM ' . $this->table . ' rev ' .
                'JOIN rooms ON rooms.id = rev.room_id AND rooms.deleted_at IS NULL ' .
                'WHERE rev.deleted_at IS NULL'
            );
    }
}
