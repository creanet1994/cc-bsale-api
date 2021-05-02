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
    function readProducts($category, $page){
        $limit = 8;
        $page = ($page-1)*8;
        $query = "SELECT * FROM product where category = :category LIMIT :limit OFFSET :page";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':page', $page, PDO::PARAM_INT);
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

    function readProductsTotal($value, $type){
        // Tipo 1 productos por categoria
        if($type == 1){
            $query = "SELECT count(id) as 'count' FROM product where category = :value";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':value', $value, PDO::PARAM_INT);

        }else{ // Tipo productos por busqueda
            $query = "SELECT count(id) as 'count' FROM product where name LIKE '%' :value '%'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        }
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