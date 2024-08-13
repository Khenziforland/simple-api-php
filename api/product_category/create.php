<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/ProductCategory.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product category object
$product_category = new ProductCategory($db);

// Get posted data
$product_category->name = $_POST['name'] ?? '';

// Create post
if ($product_category->create()) {
    // Get ID
    $new_product_category_id = $db->lastInsertId();

    // Get Data
    $product_category->id = $new_product_category_id;
    $product_category->read_single();

    // Create Array
    $product_category_arr = array(
        'id' => $product_category->id,
        'name' => $product_category->name,
    );

    // Display Data
    echo json_encode(
        array(
            'message' => 'Product Category Created',
            'data' => $product_category_arr
        )
    );
} else {
    echo json_encode(
        array('message' => 'Product Category Not Created')
    );
}
