<?php

class MySQL{

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
    
    // generate a table
    
    function table(string $query){

        $result = mysqli_query($this->db, $query);
        
             echo "<table class='customTable'>";
             echo "<thead>";
             echo "<tr>";
             echo "<th>ID</th>";
             echo "<th>Name</th>";
             echo "<th>Surname</th>";
             echo "<th>From</th>";
             echo "<th>To</th>";
             echo "</tr>";
            echo "<thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $field => $value) {
                   echo "<td>" . $value ."</td>"; 
                }
                echo  "</tr>";
            }
            echo "<tbody>";
            echo "</table>";

    }
}


