<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Delete product category
if ($product_category->delete()) {
    echo json_encode(
        array('message' => 'Product Category Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Product Category Not Deleted')
    );
}
