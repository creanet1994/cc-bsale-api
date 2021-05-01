<?php
class Database{
  
    // Credenciales de la BDD
    private $host = "mdb-test.c6vunyturrl6.us-west-1.rds.amazonaws.com";
    private $db_name = "bsale_test";
    private $username = "bsale_test";
    private $password = "bsale_test";
    public $conn;
  
    // Se levanta la conexión a la base de datos
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>