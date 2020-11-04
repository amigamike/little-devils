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
use PDO;

class DatabaseController
{
    private $connection = null;

    private $filters = [];
    private $filtersBetween = [];

    public function __construct()
    {
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

    public function select(string $class, string $query, array $params = [])
    {
        /*
         * Trigger the query execution.
         */
        $sql = $this->trigger($query, $params);

        return $sql->fetchObject($class);
    }

    public function selectArray(string $class, string $query, array $params = [])
    {
        /*
         * Trigger the query execution.
         */
        $sql = $this->trigger($query, $params);

        return $sql->fetchAll(PDO::FETCH_CLASS, $class);
    }

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
