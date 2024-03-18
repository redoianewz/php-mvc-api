<?php

namespace Database;

class DatabaseAdapter
{

    private $dbConnection;

    public function __construct($driver, $hostname, $username, $password, $database, $port)
    {
        $class = '\Database\DB\\' . $driver;

        if (class_exists($class)) {
            $this->dbConnection = new $class($hostname, $username, $password, $database, $port);
        } else {
            exit('Error: Could not load database driver ' . $driver . '!');
        }
    }

    /**
     * Execute a query on the database.
     *
     * @param string $sql The SQL query to execute.
     * @return mixed The result of the query.
     */
    public function query($sql)
    {
        return $this->dbConnection->query($sql);
    }

    /**
     * Escape a string to be used in a SQL query to prevent SQL injection attacks.
     *
     * @param string $value The string to escape.
     * @return string The escaped string.
     */
    public function escape($value)
    {
        return $this->dbConnection->escape($value);
    }

    /**
     * Get the last inserted ID from the database.
     *
     * @return int The last inserted ID.
     */
    public function getLastId()
    {
        return $this->dbConnection->getLastId();
    }

    /**
     * Prepare a SQL statement for execution.
     *
     * @param string $sql The SQL query to prepare.
     * @return mixed The prepared statement.
     */
    public function prepare($sql)
    {
        return $this->dbConnection->prepare($sql);
    }

    /**
     * Insert data into a table.
     *
     * @param string $table The name of the table.
     * @param array $data An associative array of column names and values to insert.
     * @return int The last inserted ID.
     */
    public function insert($table, $data)
    {
        return $this->dbConnection->insert($table, $data);
    }

    /**
     * Update data in a table based on specified conditions.
     *
     * @param string $table The name of the table.
     * @param array $data An associative array of column names and values to update.
     * @param array $conditions An associative array of column names and values representing the conditions.
     * @return int The number of affected rows.
     */
    public function update($table, $data, $conditions)
    {
        return $this->dbConnection->update($table, $data, $conditions);
    }

    /**
     * Delete data from a table based on specified conditions.
     *
     * @param string $table The name of the table.
     * @param array $conditions An associative array of column names and values representing the conditions.
     * @return int The number of affected rows.
     */
    public function delete($table, $conditions)
    {
        return $this->dbConnection->delete($table, $conditions);
    }

    /**
     * Select data from a table based on specified conditions.
     *
     * @param string $table The name of the table.
     * @param array $conditions An associative array of column names and values representing the conditions.
     * @return array An array of rows selected from the table.
     */
    public function select($table, $conditions)
    {
        return $this->dbConnection->select($table, $conditions);
    }

    /**
     * Begin a transaction.
     */
    public function beginTransaction()
    {
        $this->dbConnection->beginTransaction();
    }

    /**
     * Commit a transaction.
     */
    public function commit()
    {
        $this->dbConnection->commit();
    }

    /**
     * Roll back a transaction.
     */
    public function rollBack()
    {
        $this->dbConnection->rollBack();
    }

    /**
     * Close the database connection.
     */
    public function close()
    {
        $this->dbConnection->close();
    }
}
