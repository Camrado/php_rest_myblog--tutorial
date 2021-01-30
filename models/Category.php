<?php

class Category {
  // DB Stuff
  private $conn;
  private $table = "categories";

  // Properties
  public $id;
  public $name;
  public $created_at;

  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  // Get Categories
  public function read() {
    // Create query
    $query = "SELECT * FROM $this->table";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single Category
  public function read_single() {
    // Create query
    $query = "SELECT * FROM $this->table WHERE id = :id";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(":id", $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->name = $row["name"];
    $this->created_at = $row["created_at"];
  }

  // Create Category
  public function create() {
    // Create query
    $query = "INSERT INTO $this->table 
                (name, created_at)
                VALUES (:name, :created_at)";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    // Bind data
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":created_at", $this->created_at);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Update Category
  public function update() {
    // Create query
    $query = "UPDATE $this->table 
                SET name = :name, created_at = :created_at
                WHERE id = :id";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    // Bind data
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":created_at", $this->created_at);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete Category 
  public function delete() {
    // Create query
    $query = "DELETE FROM $this->table WHERE id = :id";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(":id", $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }
}
