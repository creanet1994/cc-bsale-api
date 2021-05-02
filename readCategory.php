<?php
class Category{

    private $conn;
    // public $id;
    // public $name;

    // Obtener todas las categorías
    function read(){
        $query = "SELECT * FROM category";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function __construct($db){
        $this->conn = $db;
    }
}
?>