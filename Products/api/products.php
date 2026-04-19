<?php
header("Content-Type: application/json");

include_once('../config/database.php');
include_once('../models/Product.php');

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$method = $_SERVER['REQUEST_METHOD'];

// GET
if ($method == 'GET') {
    if(isset($_GET['id'])) {
        $product->id = $_GET['id'];
        $product->read_single();

        echo json_encode([
            "id" => $product->id,
            "product" => $product->product,
            "price" => $product->price
        ]);
    } else {
        $result = $product->read();
        $products = [];

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }

        echo json_encode($products);
    }
}

// POST
if ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->product) && !empty($data->price)) {
        $product->product = $data->product;
        $product->price = $data->price;

        if($product->create()) {
            echo json_encode(["message" => "Product Created"]);
        } else {
            echo json_encode(["message" => "Failed"]);
        }
    } else {
        echo json_encode(["message" => "Incomplete data"]);
    }
}

// PUT
if ($method == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));

    $product->id = $data->id;
    $product->product = $data->product;
    $product->price = $data->price;

    if($product->update()) {
        echo json_encode(["message" => "Product Updated"]);
    } else {
        echo json_encode(["message" => "Failed"]);
    }
}

// DELETE
if ($method == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));

    $product->id = $data->id;

    if($product->delete()) {
        echo json_encode(["message" => "Product Deleted"]);
    } else {
        echo json_encode(["message" => "Failed"]);
    }
}
?>