<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db.php';
include_once 'readCategory.php';

// Se inicializa la Clase
$database = new Database();
$db = $database->getConnection();

// Se inicializa el objeto
$category = new Category($db);

$stmt = $category->read();
$num = $stmt->rowCount();

if($num>0){
    $category_arr=array();
    $category_arr["data"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_item=array(
            "id" => $id,
            "name" => $name
        );
        array_push($category_arr["data"], $category_item);
    }
    http_response_code(200);
    echo json_encode($category_arr);
}else{

    http_response_code(404);
    echo json_encode(
        array("message" => "No hay categorías")
    );
}