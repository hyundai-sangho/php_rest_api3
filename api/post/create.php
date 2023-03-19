<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-width');

require_once $_SERVER['DOCUMENT_ROOT'] . '/restApi3/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restApi3/models/Post.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->categoryId = $data->category_id;

// Create post
if ($post->create()) {
  echo json_encode(
    array('메시지' => '포스트 생성됨')
  );
} else {
  echo json_encode(
    array('메시지' => '포스트 생성 안 됨')
  );
}
