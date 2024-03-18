<?php

/**
 *
 * This file is part of mvc-rest-api for PHP.
 *
 */
namespace Database\DB;

/**
 *  Global Class PDO
 */
final class PDO {

    /**
     * @var
     */
    private $pdo = null;

    /**
     * @var
     */
    private $statement = null;

    /**
     *  Construct, create opject of PDO class
     */
    public function __construct($hostname, $username, $password, $database, $port) {
        try {
            $this->pdo = new \PDO("mysql:host=" . $hostname . ";port=" . $port . ";dbname=" . $database, $username, $password, array(\PDO::ATTR_PERSISTENT => true));
        } catch(\PDOException $e) {
            trigger_error('Error: Could not make a database link ( ' . $e->getMessage() . '). Error Code : ' . $e->getCode() . ' <br />');
            exit();
        }

        // set default setting database
        $this->pdo->exec("SET NAMES 'utf8'");
        $this->pdo->exec("SET CHARACTER SET utf8");
        $this->pdo->exec("SET CHARACTER_SET_CONNECTION=utf8");
        $this->pdo->exec("SET SQL_MODE = ''");

    }
    
    /**
     * exec query statement
     */
    public function query($sql) {
        $this->statement = $this->pdo->prepare($sql);
        $result = false;    

        try {
            if ($this->statement && $this->statement->execute()) {
                $data = array();

                while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

                // create std class
                $result = new \stdClass();
                // $result->row = (isset($data[0]) ? $data[0] : array());
                $result = $data;
                // $result->num_rows = $this->statement->rowCount();               
            }
        } catch (\PDOException $e) {
            trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
            exit();
        }

        if ($result) {
            return $result;            
        } else {
            $result = new \stdClass();
            $result->row = array();
            $result->rows = array();
            $result->num_rows = 0;
            return $result;
        }

        
    }

    /**
     *  claen data
     */
    public function escape($value) {
        $search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"');
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"');
        return str_replace($search, $replace, $value);
    }

    /**
     *  return last id insert
     */
    public function getLastId() {
        return $this->pdo->lastInsertId();
    }
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
    public function insert($table, $data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $values = array_values($data);

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($values);

        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $conditions)
    {
        $setClause = '';
        $values = [];

        foreach ($data as $field => $value) {
            $setClause .= "$field = ?, ";
            $values[] = $value;
        }

        $setClause = rtrim($setClause, ', ');

        $whereClause = '';
        foreach ($conditions as $field => $value) {
            $whereClause .= "$field = ? AND ";
            $values[] = $value;
        }

        $whereClause = rtrim($whereClause, ' AND ');

        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($values);

        return $statement->rowCount();
    }

    public function delete($table, $conditions)
    {
        $whereClause = '';
        $values = [];

        foreach ($conditions as $field => $value) {
            $whereClause .= "$field = ? AND ";
            $values[] = $value;
        }

        $whereClause = rtrim($whereClause, ' AND ');

        $sql = "DELETE FROM $table WHERE $whereClause";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($values);

        return $statement->rowCount();
    }

    public function select($table, $conditions)
    {
        $whereClause = '';
        $values = [];
        foreach ($conditions as $field => $value) {
            $whereClause .= "$field = ? AND ";
            $values[] = $value;
        }

        $whereClause = rtrim($whereClause, ' AND ');

        $sql = "SELECT * FROM $table WHERE $whereClause";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($values);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollBack()
    {
        $this->pdo->rollBack();
    }

    public function close()
    {
        $this->pdo = null;
    }


    public function __destruct() {
        $this->pdo = null;
    }
}
