<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db.php';
include_once 'readProduct.php';

// Se inicializa la Clase
$database = new Database();
$db = $database->getConnection();

// Se inicializa el objeto
$product = new Product($db);

if (isset($_GET['search'])) {

    $keyword = $_GET['search'];
    $page = $_GET['page'];

    $stmt = $product->readProductsSearch($keyword, $page);
    $num = $stmt->rowCount();

    // readProductsTotal();
    if($num>0){
        $products_arr=array();
        $products_arr["data"]=array();
        $products_arr["pagination"]=array();
        $page = $product->readProductsTotal($keyword, 2);

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
            array_push($products_arr["data"], $product_item);
        }

        $row = $page->fetch();
        extract($row);
        $product_page=array("pages" => ceil($row["count"]/8), "actualPage" =>  intval($_GET['page']) );
        array_push($products_arr["pagination"], $product_page);
        http_response_code(200);
        echo json_encode($products_arr);
    }else{

        http_response_code(404);
        echo json_encode(
            array("message" => "No hay productos que coincidan con la busqueda")
        );
    }
}else if(isset($_GET['category'])){

    $category = $_GET['category'];
    $page = $_GET['page'];


    $stmt = $product->readProducts($category,$page);
    $num = $stmt->rowCount();

    // Validamos si existe un dato
    if($num>0){
        $products_arr=array();
        $products_arr["data"]=array();
        $products_arr["pagination"]=array();
        $page = $product->readProductsTotal($category, 1);

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
            array_push($products_arr["data"], $product_item);
        }

        $row = $page->fetch();
        extract($row);
        $product_page=array("pages" => ceil($row["count"]/8), "actualPage" =>  intval($_GET['page']) );
        array_push($products_arr["pagination"], $product_page);
        http_response_code(200);
        echo json_encode($products_arr);
    }else{

        http_response_code(404);
        echo json_encode(
            array("message" => "No hay productos en la categoría seleccionada")
        );
    }
}else{
    http_response_code(404);
}
