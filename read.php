<?php
class Product{

    private $conn;
    public $id;
    public $name;
    public $url_image;
    public $price;
    public $discount;
    public $category;
    
    // Obtener productos por categoría
    function read($category){
        $query = "SELECT * FROM product where category = :category";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function __construct($db){
        $this->conn = $db;
    }
}
?>