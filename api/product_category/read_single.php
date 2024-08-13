<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/ProductCategory.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product category object
$product_category = new ProductCategory($db);

// Get ID
$product_category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get product category
$product_category->read_single();

// Create array
$product_category_arr = array(
    'id' => $product_category->id,
    'name' => $product_category->name,
    'created_at' => $product_category->created_at
);

// Make JSON
print_r(json_encode($product_category_arr));

