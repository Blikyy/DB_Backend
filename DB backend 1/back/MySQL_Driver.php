<?php

interface IDB
{
    /**
     * Connect to DB on DBMS
     *
     * @param string $host hostname
     * @param string $username username 
     * @param string $password password
     * @param string $database database name
     * @return static instance of DB on success
     */
    public function connect(
        string $host = "",
        string $username = "",
        string $password = "",
        string $database = ""
    ): ?static;

    /**
     * SELECT rows from table
     *
     * @param string $query SQL query SELECT string
     * @return array result as a associative array, key is attribute name, value is attribute array; empty on error
     */
    function select(string $query): array;

    /**
     * INSERT record to table
     *
     * @param string $table database table name
     * @param array $data data to insert, key is attribute name, value is attribute value
     * @return boolean true on success otherwise false
     */
    function insert(string $table, array $data): bool;

    /**
     * UPDATE record in table
     *
     * @param string $table database table name
     * @param integer $id primary key value for record to update
     * @param array $data data to update, key is attribute name, value is attribute value
     * @return boolean true on success otherwise false
     */
    function update(string $table, int $id, array $data): bool;

    /**
     * DELETE item from table
     *
     * @param string $table database table name
     * @param integer $id primary key value for record to delete
     * @return boolean true on success otherwise false 
     */
    function delete(string $table, int $id): bool;
    
}
    


class MySQL implements IDB{

    private $db;

    // connect
    public function connect(string $host = "", string $username = "",string $password = "",string $database = ""): ?static{
        
        $this->db = new mysqli($host, $username, $password, $database);
        return null;
    }

    // select

    function select(string $query): array{

        $result = mysqli_query($this->db, $query);
        if (!$result) {
            return array();
        }
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
        
    // insert

    function insert(string $table, array $data): bool{

        $keys = array_keys($data);
        $values = array_map(function ($value) {
            return "'" . $this->db->real_escape_string($value) . "'";
        }, array_values($data));
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
        return mysqli_query($this->db, $sql);

    }   

    // update

    function update(string $table, int $id, array $data): bool{

        $set = array_map(function ($key, $value) {
            return "$key = '" . $this->db->real_escape_string($value) . "'";
        }, array_keys($data), array_values($data));
        $set = implode(',', $set);
        $sql = "UPDATE $table SET $set WHERE id = $id";
        return mysqli_query($this->db, $sql);

    }

    // delete

    function delete(string $table, int $id): bool{

        $sql = "DELETE FROM $table WHERE id=$id";
        return mysqli_query($this->db, $sql);

    }

    function table(string $query){

        $result = mysqli_query($this->db, $query);
        $html = "";
        $html .= "<table class='customTable'>\n";
        $html .= "<thead>\n";
        $html .= "<tr>\n";
        $html .= "<th>ID</th>\n";
        $html .= "<th>Name</th>\n";
        $html .= "<th>Surname</th>\n";
        $html .= "<th>From</th>\n";
        $html .= "<th>To</th>\n";
        $html .= "</tr>\n";
        $html .= "<thead>\n";
        $html .= "<tbody>\n";
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "<tr>\n";
            foreach ($row as $field => $value) {
                $html .= "<td>" . $value ."</td>\n"; 
            }
            $html .=  "</tr>\n";
        }
        $html .= "<tbody>\n";
        $html .= "</table>\n";
        return $html;

    }
}


