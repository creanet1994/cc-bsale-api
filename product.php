<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db.php';
include_once 'read.php';

// Se inicializa la Clase
$database = new Database();
$db = $database->getConnection();
// Se inicializa el objeto
$product = new Product($db);

if(isset($_GET['category'])){

    $category = $_GET['category'];
    $stmt = $product->read($category);
    $num = $stmt->rowCount();

    // Validamos si existe un dato
    if($num>0){
        $products_arr=array();
        $products_arr["records"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $product_item=array(
                "id" => $id,
                "name" => $name,
                "url_image" => html_entity_decode($url_image),
                "price" => $price,
                "discount" => $discount,
                "category" => $category
            );
            array_push($products_arr["records"], $product_item);
        }
        http_response_code(200);
        echo json_encode($products_arr);
    }else{

        http_response_code(404);
        echo json_encode(
            array("message" => "No products found.")
        );
    }
}