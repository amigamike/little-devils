<?php

/**
 * Api key model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Model
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Controllers\DatabaseController;

class Model
{
    /**
     * The primary key.
     * @var string $primary
     */
    protected $primary = 'id';

    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = '';

    /**
     * The created at date.
     * @var DateTime $created_at
     */
    public $created_at = null;

    /**
     * The updated at date.
     * @var DateTime $updated_at
     */
    public $updated_at = null;

    /**
     * The deleted at date.
     * @var DateTime $deleted_at
     */
    public $deleted_at = null;

    /**
     * Return the primary key.
     *
     * @return string
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * Save the data into the database.
     *
     * @return int
     */
    public function save()
    {
        /*
         * Define the db controller.
         */
        $db = new DatabaseController();

        /*
         * Set the created at date.
         */
        $this->created_at = date('Y-m-d H:i:s');

        /*
         * Insert the data into the table in the db,
         * and return the inserted ID.
         */
        return $db->insert($this->table, $this);
    }
}
