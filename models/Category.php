<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all categories
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get a single category by ID
    public function read_single() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Create a category
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (category) VALUES (:category)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category", $this->category);
        return $stmt->execute();
    }

    // Update a category
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET category = :category WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":category", $this->category);
        return $stmt->execute();
    }

    // Delete a category
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>
