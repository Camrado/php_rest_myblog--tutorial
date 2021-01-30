<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");

require_once "../../config/Database.php";
require_once "../../models/Category.php";


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog category object
$category = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;

// Delete category 
if ($category->delete()) {
  echo json_encode(
    array("message" => "Category Deleted")
  );
} else {
  echo json_encode(
    array("message" => "Category Not Deleted")
  );
}
