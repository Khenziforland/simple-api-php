<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product object
$product = new Product($db);

// Get ID
$product->id = $_GET['id'] ?? die();

// Get product details to retrieve image path
$product->read_single();

// Delete product
if ($product->delete()) {
    // Delete image file
    if ($product->file !== "../../assets/image/default.png" && file_exists($product->file)) {
        unlink($product->file);
    }
    echo json_encode(
        array('message' => 'Product Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Product Not Deleted')
    );
}
