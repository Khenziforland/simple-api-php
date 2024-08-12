<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$post = new Post($db);

// Get ID
$post->id = $_GET['id'] ?? die();

// Get posted data
$post->title = $_POST['title'] ?? '';
$post->body = $_POST['body'] ?? '';
$post->author = $_POST['author'] ?? '';
$post->category_id = $_POST['category_id'] ?? '';

// Update post
if ($post->update()) {
    // Get Data
    $post->read_single();

    // Create Array
    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    // Display Data
    echo json_encode(
        array(
            'message' => 'Post Updated',
            'data' => $post_arr
        )
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}






