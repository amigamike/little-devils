<?php

/**
 * Database controller.
 *
 *
 * @package     MikeWelsh\LittleDevils\Controllers\DatabaseController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Exceptions\DatabaseException;
use MikeWelsh\LittleDevils\Models\Pagination;
use PDO;

class DatabaseController
{
    /**
     * Database connection.
     * @var $connection
     */
    private $connection = null;

    /**
     * Current page for pagination.
     * @var int $current_page
     */
    private int $current_page = 1;

    /**
     * Filters array.
     * @var array $filters
     */
    private array $filters = [];

    /**
     * Filters array for building between query.
     * @var array $filtersBetween
     */
    private array $filtersBetween = [];

    /**
     * Array for building likes with an or condition in the query.
     * @var array $orLikes
     */
    private array $orLikes = [];

    /**
     * Pagination object.
     * @var Pagination $pagination
     */
    public Pagination $pagination;

    /**
     * Per page used for the pagination.
     * @var int $per_page
     */
    private int $per_page = 25;

    public function __construct()
    {
        $this->pagination = new Pagination();

        $vars = [
            'DB_DRIVER',
            'DB_DATABASE',
            'DB_HOST',
            'DB_PORT',
            'DB_USERNAME',
            'DB_PASSWORD'
        ];

        /*
         * Check that the db config is there.
         */
        foreach ($vars as $var) {
            if (getenv($var) === false) {
                throw new DatabaseException('Database configuration not found, missing "' . $var . '"');
            }
        }

        /*
         * Create the DSN.
         */
        $dsn = getenv('DB_DRIVER') .
            ':dbname=' . getenv('DB_DATABASE') .
            ';host=' . getenv('DB_HOST') .
            ';port=' . getenv('DB_PORT');
        
        /*
         * Create the connection.
         */
        $this->connection = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    }

    /**
     * Set the filters for filtering the results.
     *
     * @param array $filters
     * @return $this
     */
    public function filters(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Set the filters between for filtering the results.
     *
     * @param array $filters
     * @return $this
     */
    public function filtersBetween(array $filters)
    {
        $this->filtersBetween = $filters;
        return $this;
    }

    /**
     * Set the or likes.
     *
     * @param array $likes
     * @return $this
     */
    public function likeOr(array $likes)
    {
        $this->orLikes = $likes;
        return $this;
    }

    /**
     * Set the order for ordering the results.
     *
     * @param array $order
     * @return $this
     */
    public function order(array $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Set the values for the pagination object.
     *
     * @param int $current_page
     * @param int $per_page
     * @return $this
     */
    public function paginate(int $current_page, int $per_page)
    {
        $this->current_page = $current_page;
        $this->per_page = $per_page;
        return $this;
    }

    /**
     * Insert into the database.
     *
     * @param mixed $model
     * @return int $lastInsertId
     */
    public function insert($model)
    {
        /*
         * Get the model's public vars.
         */
        $vars = get_class_vars(get_class($model));

        /*
         * Drop the primary key.
         */
        unset($vars[$model->getPrimary()]);

        /*
         * Kick the query off.
         */
        $query = 'INSERT INTO ' . $model->getTable() . ' (';

        /*
         * Define the data arrays.
         */
        $sqlValues = '';
        $sqlVars = '';
        $params = [];

        /*
         * Loop through the model's vars,
         * build the vars for the query and its params.
         */
        foreach ($vars as $var => $value) {
            $sqlVars .= "`" . $var . "`,";
            $sqlValues .= ":" . $var . ",";
            $params[':' . $var] = $model->$var;
        }

        /*
         * Finish building the query.
         */
        $query .= trim($sqlVars, ',');
        $query .= ') VALUES (';
        $query .= trim($sqlValues, ',');
        $query .= ')';

        /*
         * Trigger the query execution.
         */
        $sql = $this->trigger($query, $params);

        /*
         * Return the inserted Id.
         */
        return $this->connection->lastInsertId();
    }

    /**
     * Trigger a select and return the result as an object.
     *
     * @param string $class
     * @param string $query
     * @param array $params
     * @return $result
     */
    public function select(string $class, string $query, array $params = [])
    {
        /*
         * Trigger the query execution.
         */
        $sql = $this->trigger($query, $params);

        $result = $sql->fetchObject($class);

        if ($this->current_page && $this->per_page) {
            $this->pagination = new Pagination($this->current_page, $this->per_page);
            $this->pagination->total = $result->total;
            unset($result->total);

            $this->pagination->update();
        }

        return $result;
    }

    /**
     * Trigger a select and return results as array.
     *
     * @param string $class
     * @param string $query
     * @param array $params
     * @return $result
     */
    public function selectArray(string $class, string $query, array $params = [])
    {
        /*
         * Trigger the query execution.
         */
        $sql = $this->trigger($query, $params);

        $results = $sql->fetchAll(PDO::FETCH_CLASS, $class);

        if ($this->current_page && $this->per_page) {
            $this->pagination = new Pagination($this->current_page, $this->per_page);

            foreach ($results as $key => $result) {
                if (empty($this->pagination->total)) {
                    $this->pagination->total = $result->total;
                }
                unset($result->total);
            }

            $this->pagination->update();
        }

        return $results;
    }

    /**
     * Trigger the query with params.
     *
     * @param string $query
     * @param array $params
     * @return $sql
     */
    private function trigger(string $query, array $params = [])
    {
        /*
         * If there are filter, use them.
         */
        if (!empty($this->filters)) {
            foreach ($this->filters as $col => $value) {
                $query .= ' AND ' . $col . '=:' . $col;
                $params[':' . $col] = $value;
            }
        }

        /*
         * If there are filters for between, use them.
         */
        if (!empty($this->filtersBetween)) {
            $iLoop = 0;
            foreach ($this->filtersBetween as $col => $filters) {
                $query .= ' AND (' . $col . ' BETWEEN ';
                foreach ($filters as $filter) {
                    $query .= ':' . $col . '_filter_' . $iLoop;
                    $params[':' . $col . '_filter_' . $iLoop] = $filter;
                    $iLoop++;
                    $query .= ' AND ';
                }
                $query = rtrim($query, ' AND ') . ')';
            }
        }

        /*
         * If there are or likes, use them.
         */
        if (!empty($this->orLikes)) {
            $query .= ' AND (';
            foreach ($this->orLikes as $col => $value) {
                $query .= $col . '=:' . $col . ' OR ';
                $params[':' . $col] = $value;
            }
            $query = rtrim($query, ' OR ');
            $query .= ' )';
        }

        if ($this->current_page && $this->per_page) {
            $start = substr(
                $query,
                0,
                strrpos(strtoupper($query), ' FROM ')
            );
        
            $end = substr(
                $query,
                strrpos(strtoupper($query), ' FROM '),
                strlen($query) - strrpos(strtoupper($query), ' FROM ')
            );

            $countQuery = '(SELECT count(*) ' . substr(
                $query,
                strrpos(strtoupper($query), ' FROM '),
                strlen($query) - strrpos(strtoupper($query), ' FROM ')
            ) . ') AS total ';

            $query = $start . ', ' . $countQuery . ' ' . $end;
        
            $offset = (($this->current_page - 1) * $this->per_page);
            $query .= ' LIMIT ' . $this->per_page . ($offset ? ' OFFSET ' . $offset : '');
        }

        /*
         * If there are orders, use them.
         */
        if (!empty($this->order)) {
            $query .= ' ORDER BY ';
            foreach ($this->order as $col => $direction) {
                $query .= $col . ' ' . $direction . ', ';
            }
            $query = rtrim($query, ', ');
        }

        /*
         * Prepare the SQL statement.
         */
        $sql = $this->connection->prepare($query);

        /*
         * Execute the statement with any params that have been passed.
         */
        if (!$sql->execute($params)) {
            $err = new \stdClass();
            $err->error = $sql->errorInfo();
            $err->query = $query;
            $err->params = $params;
            $msg = 'Database error';
            throw new DatabaseException($msg, $err);
        }

        return $sql;
    }

    /**
     * Update in the database.
     *
     * @param mixed $model
     */
    public function update($model)
    {
        /*
         * Get the model's public vars.
         */
        $vars = get_class_vars(get_class($model));

        /*
         * Drop the primary key.
         */
        unset($vars[$model->getPrimary()]);

        /*
         * Kick the query off.
         */
        $query = 'UPDATE ' . $model->getTable() . ' SET ';

        /*
         * Define the data arrays.
         */
        $params = [];

        /*
         * Loop through the model's vars,
         * build the vars for the query and its params.
         */
        foreach ($vars as $var => $value) {
            $query .= "`" . $var . "`=:" . $var . ",";
            $params[':' . $var] = $model->$var;
        }

        /*
         * Finish building the query.
         */
        $query = trim($query, ',');

        $primary = $model->getPrimary();
        $query .= ' WHERE `' . $primary . '`=:id';
        $params[':id'] = $model->$primary;

        /*
         * Trigger the query execution.
         */
        $sql = $this->trigger($query, $params);
    }
}
