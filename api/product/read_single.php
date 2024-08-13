<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product object
$product = new Product($db);

// Get ID
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get product
$product->read_single();

// Check if product exists
if ($product->name != null) {
    // Create array
    $product_arr = array(
        'id' => $product->id,
        'product_category_id' => $product->product_category_id,
        'product_category_name' => $product->product_category_name,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'file' => $product->file,
    );

    // Turn to JSON & output
    echo json_encode($product_arr);
} else {
    // No product found
    echo json_encode(
        array('message' => 'Product Not Found')
    );
}
