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
    function readProducts($category){
        $query = "SELECT * FROM product where category = :category";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function readProductsSearch($keyword , $page){
        $limit = 8;
        $page = ($page-1)*8;
        $query = "SELECT * FROM product where name LIKE '%' :keyword '%'  LIMIT :limit OFFSET :page";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':page', $page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

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