<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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

// Get posted data
$product->product_category_id = $_POST['product_category_id'] ?? '';
$product->name = $_POST['name'] ?? '';
$product->description = $_POST['description'] ?? '';
$product->price = $_POST['price'] ?? '';

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileName  =  $_FILES['file']['name'];
    $tempPath  =  $_FILES['file']['tmp_name'];
    $fileSize  =  $_FILES['file']['size'];
    $fileError =  $_FILES['file']['error'];

    // Handle file upload
    $fileName = str_replace(' ', '_', $fileName);
    $date = date('Ymd_His');
    $uniqueFileName = $date . '_' . uniqid() . '_' . basename($fileName);

    $uploadDir = '../../assets/image/';
    $uploadFile = $uploadDir . $uniqueFileName;

    // Check file type
    $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png');

    if (in_array($fileType, $allowedTypes)) {
        if ($fileError === UPLOAD_ERR_OK) {
            // Delete old image if exists
            if ($product->file !== $uploadDir . "default.png" && file_exists($product->file)) {
                unlink($product->file);
            }

            if (move_uploaded_file($tempPath, $uploadFile)) {
                $product->file = $uploadFile;
            } else {
                echo json_encode(
                    array('message' => 'File Upload Failed')
                );
                exit();
            }
        } else {
            echo json_encode(
                array('message' => 'File Upload Error')
            );
            exit();
        }
    } else {
        echo json_encode(
            array('message' => 'Invalid File Type')
        );
        exit();
    }
}

// Update post
if ($product->update()) {
    // Get Data
    $product->read_single();

    // Create Array
    $product_arr = array(
        'id' => $product->id,
        'product_category_id' => $product->product_category_id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'file' => $product->file
    );

    // Display Data
    echo json_encode(
        array(
            'message' => 'Product Updated',
            'data' => $product_arr
        )
    );
} else {
    echo json_encode(
        array('message' => 'Product Not Updated')
    );
}
