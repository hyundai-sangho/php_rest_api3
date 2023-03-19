<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/restApi3/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restApi3/models/Post.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$post = new Post($db);

// Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$post->read_single();

// Create array
$post_arr = array(
  'id' => $post->id,
  'title' => $post->title,
  'body' => $post->body,
  'author' => $post->author,
  'category_id' => $post->categoryId,
  'category_name' => $post->categoryName
);

// Make JSON
print_r(json_encode($post_arr));
