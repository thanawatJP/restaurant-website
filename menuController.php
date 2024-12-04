<?php
    class MenuControll{
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $database = "kruagame";
        private $conn;

        function __construct(){
            $this->conn = $this->connectDB();
        }

        function connectDB(){
            $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database); //เข้าถึงDB
            return $conn;
        }

        function runQuery($query){
            $result = mysqli_query($this->conn, $query);

            while($row = mysqli_fetch_assoc($result)){
                $resultset[]=$row;
            }
            if(!empty($resultset)){
                return $resultset;
            }
        }

        function numRows($query){
            $result = mysqli_query($this->conn, $query);
            $rowcount = mysqli_num_rows($result);
            return $rowcount;
        }

        function insertData($table, $data){
            $columns = implode(", ", array_keys($data));
            $values = implode("', '", array_values($data));
            $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
            
            mysqli_query($this->conn, $sql);
            
            if(mysqli_error($this->conn)) {
                return false;
            } else {
                return true;
            }
        }
        
    }

?>