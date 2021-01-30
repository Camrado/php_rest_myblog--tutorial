<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../../config/Database.php";
require_once "../../models/Category.php";


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog category object
$category = new Category($db);

// Get ID
$category->id = isset($_GET["id"]) ? $_GET["id"] : die();

// Get Category
$category->read_single();

// Create array
$categories_arr = array(
  "id" => $category->id,
  "name" => $category->name,
  "created_at" => $category->created_at
);

// Make JSON
echo (json_encode($categories_arr));
