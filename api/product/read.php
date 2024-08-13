<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/Product.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product object
$product = new Product($db);

// Product query
$result = $product->read();
// Get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // Post array
    $products_arr = array();
    $products_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = array(
            'id' => $id,
            'product_category_id' => $product_category_id,
            'product_category_name' => $product_category_name,
            'name' => $name,
            'description' => html_entity_decode($description),
            'price' => $price,
            'file' => $file
        );

        // Push to "data"
        array_push($products_arr['data'], $product_item);
    }

    // Turn to JSON & output
    echo json_encode($products_arr);
} else {
    // No Posts
    echo json_encode(
        array('message' => 'No Products Found')
    );
}
