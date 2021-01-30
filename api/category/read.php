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

// Blog category query
$result = $category->read();
// Get row count 
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
  // Category array
  $categories_arr = array();
  $categories_arr["data"] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row); //? Now I can just write $title, $body instead of $row->title, $row->body

    $category_item = array(
      "id" => $id,
      "name" => $name,
      "created_at" => $created_at
    );

    // Push to 'data'
    array_push($categories_arr["data"], $category_item);
  }

  // Turn to JSON & output
  echo json_encode($categories_arr);
} else {
  // No categories
  echo json_encode(
    array("message" => "No Categories Found")
  );
}
