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
use MikeWelsh\LittleDevils\Models\Pagination;

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
     * @var array $filters
     */
    protected $filters = [];

    /**
     * Filter the results.
     * @var array $filtersBetween
     */
    protected $filtersBetween = [];

    /**
     * Order the results.
     * @var array $order
     */
    protected $order = [];

    /**
     * Like ors array.
     * @var array $orLikes
     */
    protected $orLikes = [];

    /**
     * Pagination object.
     * @var Pagination $pagination
     */
    public Pagination $pagination;

    /**
     * The current page.
     * @var int $current_page
     */
    protected int $current_page = 1;

    /**
     * The per page.
     * @var int $per_page
     */
    protected int $per_page = 25;

    /**
     * Return all the entries.
     *
     * @return array $return
     */
    public function all(string $query = ''): array
    {
        if (!$this->current_page) {
            $this->current_page = 1;
        }

        if (empty($query)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE deleted_at IS NULL';
        }

        /*
         * Define the db controller and trigger the select.
         */
        $db = new DatabaseController();
        $results = $db
            ->filters($this->filters)
            ->filtersBetween($this->filtersBetween)
            ->order($this->order)
            ->paginate($this->current_page, $this->per_page)
            ->likeOr($this->orLikes)
            ->selectArray(
                get_class($this),
                $query
            );
        
        $this->pagination = $db->pagination;

        return $results;
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

    public function get()
    {
        return $this->select(
            'SELECT 
                *
            FROM ' . $this->table
        );
    }

    /**
     * Get the result by its primary id
     */
    public function getById(int $id)
    {
        return $this->select(
            'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primary . '=:id',
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
     * Set the like ors.
     *
     * @param mixed $fields
     * @param string $query
     */
    public function likeOr($fields, string $query)
    {
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $this->orLikes[$field] = $query;
            }
        } else {
            $this->orLikes[$fields] = $query;
        }

        return $this;
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
     * Paginate the results.
     *
     * @param int $page
     * @param int $per_page
     */
    public function paginate(int $page = 1, int $per_page = 25)
    {
        $this->current_page = $page;
        $this->per_page = $per_page;
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
    public function select(string $query, array $params = [])
    {
        /*
         * Define the db controller and trigger the select.
         */
        return (new DatabaseController())
            ->filters($this->filters)
            ->filtersBetween($this->filtersBetween)
            ->order($this->order)
            ->likeOr($this->orLikes)
            ->select(
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
        return (new DatabaseController())
            ->filters($this->filters)
            ->filtersBetween($this->filtersBetween)
            ->order($this->order)
            ->paginate($this->current_page, $this->per_page)
            ->likeOr($this->orLikes)
            ->selectArray(
                get_class($this),
                $query,
                $params
            );
    }

    /**
     * Convert the model to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $reflect = new \ReflectionClass($this);
        $vars = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

        $array = [];
        foreach ($vars as $key => $var) {
            $name = $var->name;
            if ($name != 'pagination') {
                $array[$name] = $this->$name;
            }
        }

        return $array;
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
