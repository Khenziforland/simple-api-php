<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/ProductCategory.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product category object
$product_category = new ProductCategory($db);

// Get ID
$product_category->id = $_GET['id'] ?? die();

// Get posted data
$product_category->name = $_POST['name'] ?? '';

// Update product category
if ($product_category->update()) {
    // Get Data
    $product_category->read_single();

    // Create Array
    $product_category_arr = array(
        'id' => $product_category->id,
        'name' => $product_category->name,
        'created_at' => $product_category->created_at
    );

    // Display Data
    echo json_encode(
        array(
            'message' => 'Product Category Updated',
            'data' => $product_category_arr
        )
    );
} else {
    echo json_encode(
        array('message' => 'Product Category Not Updated')
    );
}
