<?php
class Product{

    private $conn;

    // Obtener productos por categoría
    function readProducts($category){
        $query = "SELECT * FROM product where category = :category ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Obtener productos por nombre
    function readProductsSearch($keyword ){
        $query = "SELECT * FROM product where name LIKE '%' :keyword '%' ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    // Obtener todos los productos
    function readAll(){
        $query = "SELECT * FROM product";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function __construct($db){
        $this->conn = $db;
    }
}
?>