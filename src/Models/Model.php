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
     * Filter the results.
     */
    public $filters = [];

    /**
     * Filter the results.
     */
    public $filtersBetween = [];

    /**
     * Order the results.
     */
    public $order = [];

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
                'SELECT * FROM ' . $this->table . ' WHERE deleted_at IS NULL'
            );
    }

    public function delete()
    {
        /*
         * Define the db controller.
         */
        $db = new DatabaseController();

        /*
         * Set the deleted at date.
         */
        $this->deleted_at = date('Y-m-d H:i:s');

        /*
         * Update the data into the table in the db.
         */
        return $db->update($this);
    }

    /**
     * Set a filter for filtering the results.
     *
     * @param string $column
     * @param mixed $value
     * @return mixed $this
     */
    public function filter(string $column, $value)
    {
        $this->filters[$column] = $value;
        return $this;
    }

    /**
     * Set a filter between for filtering the results.
     *
     * @param string $column
     * @param string $start
     * @param string $end
     * @return mixed $this
     */
    public function filterBetween(string $column, string $start, string $end)
    {
        $this->filtersBetween[$column] = [];
        $this->filtersBetween[$column][] = $start;
        $this->filtersBetween[$column][] = $end;
        return $this;
    }

    public function getById(int $id)
    {
        return $this->select(
            'SELECT * FROM ' . $this->table . ' WHERE id=:id',
            [
                ':id' => $id
            ]
        );
    }

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
     * Return the table.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set a order for ordering the results.
     *
     * @param string $column
     * @param string $direction
     * @return mixed $this
     */
    public function order(string $column, string $direction = 'ASC')
    {
        $this->order[$column] = $direction;
        return $this;
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
         * and set the id.
         */
        $this->id = $db->insert($this);

        /*
         * Return the inserted ID.
         */
        return $this->id;
    }

    /**
     * Trigger a select from the db.
     *
     * @param string $query
     */
    public function select(string $query, array $params)
    {
        /*
         * Define the db controller and trigger the select.
         */
        return (new DatabaseController())->select(
            get_class($this),
            $query,
            $params
        );
    }

    /**
     * Return all the entries.
     *
     * @param string $query
     * @return array $return
     */
    public function selectArray(string $query, array $params = []): array
    {
        /*
         * Define the db controller and trigger the select.
         */
        return (new DatabaseController())->selectArray(
            get_class($this),
            $query,
            $params
        );
    }

    /**
     * Update the data in the database.
     *
     * @return int
     */
    public function update()
    {
        /*
         * Define the db controller.
         */
        $db = new DatabaseController();

        /*
         * Set the updated at date.
         */
        $this->updated_at = date('Y-m-d H:i:s');

        /*
         * Update the data into the table in the db.
         */
        return $db->update($this);
    }
}
