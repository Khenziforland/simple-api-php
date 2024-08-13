<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/ProductCategory.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product category object
$product_category = new ProductCategory($db);

// Product category query
$result = $product_category->read();
// Get row count
$num = $result->rowCount();

// Check if any product categories
if ($num > 0) {
    // Category array
    $product_categories_arr = array();
    $product_categories_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_category_item = array(
            'id' => $id,
            'name' => $name,
            'created_at' => $created_at
        );

        // Push to "data"
        array_push($product_categories_arr['data'], $product_category_item);
    }

    // Turn to JSON & output
    echo json_encode($product_categories_arr);
} else {
    // No Categories
    echo json_encode(
        array('message' => 'No Product Categories Found')
    );
}
