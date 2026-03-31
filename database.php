<?php

class database
{
    private $db_host = "localhost";
    private $db_user = "root";
    private $db_pass = "password";
    private $db_name = "oops_crud";

    private $conn = false;
    private $mysqli = null;
    private $result = array();
    private $error = "";
    public $deleteNo = null;
    public $addNo = null;

    // database connection

    public function __construct()
    {
        if (!$this->conn) {
            $this->mysqli = @new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            
            if ($this->mysqli->connect_error) {
                $this->error = $this->mysqli->connect_error;
                return false;
            }
            $this->conn = true;
        }
        return true;
    }

    //insert student data

    public function insert($table, $params = array())
    {
        if ($this->tableExist($table)) {
            $table_columns = implode(', ', array_keys($params));
            $table_values = implode("','", array_values($params));
            $this->addNo = null;

            $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";

            if ($this->mysqli->query($sql)) {
                $this->addNo = $this->mysqli->insert_id;
                return true;
            } else {
                $this->error = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    //show result of student data

    public function getResult()
    {
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    // get error of all methods

    public function getError()
    {
        return $this->error;
    }

    // fetch student data

    public function select($table, $rows = "*", $join = null, $where = null, $order = null, $limit = null)
    {
        if ($this->tableExist($table)) {
            $sql = "SELECT $rows FROM $table";
            if ($join != null) $sql .= " JOIN $join";
            if ($where != null) $sql .= " WHERE $where";
            if ($order != null) $sql .= " ORDER BY $order";
            if ($limit != null) $sql .= " LIMIT 0,$limit";

            $query = $this->mysqli->query($sql);

            if ($query) {
                $this->result = $query->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                $this->error = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    // delete student data

    public function delete($table, $where = null)
    {
        if ($this->tableExist($table)) {
            $this->deleteNo = null;
            $sql = "DELETE FROM $table";
            if ($where != null) $sql .= " WHERE $where";

            if ($this->mysqli->query($sql)) {
                $this->deleteNo = $this->mysqli->affected_rows;
                return true;
            } else {
                $this->error = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    // update student data

    public function update($table, $params = array(), $where = null)
    {
        if ($this->tableExist($table)) {
            $args = array();
            foreach ($params as $key => $value) {
                $args[] = "$key = '$value'";
            }

            $sql = "UPDATE $table SET " . implode(', ', $args);
            if ($where != null) $sql .= " WHERE $where";

            if ($this->mysqli->query($sql)) {
                return true;
            } else {
                $this->error = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    //check table exist or not

    private function tableExist($table)
    {
        if (!$this->conn) {
            return false;
        }

        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableIndb = $this->mysqli->query($sql);
        if ($tableIndb && $tableIndb->num_rows == 1) {
            return true;
        } else {
            $this->error = $this->mysqli->error ? $this->mysqli->error : "Table '$table' does not exist!";
            return false;
        }
    }

    // close connection of database

    public function __destruct()
    {
        if ($this->conn) {
            $this->mysqli->close();
            $this->conn = false;
        }
    }
}
