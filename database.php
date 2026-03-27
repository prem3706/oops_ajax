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
    private $show = array();
    public $deleteNo = null;
    public $addNo = null;



    public function __construct()
    {
        if (!$this->conn) {
            $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            $this->conn = true;
            if ($this->mysqli->connect_error) {
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    public function insert($table, $params = array())
    {
        // if (empty($params)) {
        //     foreach($params as $key => $value){

        //     }
        // }
        if ($this->tableExist($table)) {

            $table_columns = implode(', ', array_keys($params));
            $table_values = implode("','", array_values($params));
            $this->addNo = null;

            $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";

            if ($this->mysqli->query($sql)) {
                $this->addNo = $this->mysqli->insert_id;
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }
    public function getResult()
    {
        $val = $this->show;
        $this->show = array();
        return $val;
    }

    public function select($table, $rows = "*", $join = null, $where = null, $order = null, $limit = null)
    {
        if ($this->tableExist($table)) {
            $sql = "SELECT $rows FROM $table";

            if ($join != null) {
                $sql .= " JOIN $join;";
            }

            if ($where != null) {
                $sql .= " WHERE $where;";
            }
            if ($order != null) {
                $sql .= " ORDER BY $order;";
            }
            if ($limit != null) {
                $sql .= " LIMIT 0,$limit";
            }
            $query = $this->mysqli->query($sql);

            if ($query) {
                $this->show = $query->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                $this->result = $query->error;
                return false;
            }
        } else {
            return false;
        }
    }
    public function delete($table, $where = null)
    {
        if ($this->tableExist($table)) {
            $this->deleteNo = null;
            $sql = "DELETE FROM $table";

            if ($where != null) {
                $sql .= " WHERE $where;";
            }

            if ($this->mysqli->query($sql)) {
                $this->deleteNo = $this->mysqli->affected_rows;
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }
    public function update($table, $params = array(), $where = null)
    {
        if ($this->tableExist($table)) {
            $args = array();
            foreach ($params as $key => $value) {
                $args[] = "$key = '$value'";
            }

            $sql = "UPDATE $table SET " . implode(', ', $args);

            if ($where != null) {
                $sql .= " WHERE $where;";
            }

            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }


    private function tableExist($table)
    {
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableIndb = $this->mysqli->query($sql);
        if ($tableIndb) {
            if ($tableIndb->num_rows == 1) {
                return true;
            } else {
                array_push($this->result, $table . "does not exist!");
                return false;
            }
        }
    }


    public function __destruct()
    {
        if ($this->conn) {
            $this->mysqli->close();
            $this->conn = false;
            return true;
        } else {
            return false;
        }
    }
}
