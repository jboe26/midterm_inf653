<?php
class Author {
    private $conn;
    private $table_name = "authors";

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all authors
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get a single author by ID
    public function read_single() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Create an author
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (author) VALUES (:author)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":author", $this->author);
        return $stmt->execute();
    }

    // Update an author
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET author = :author WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":author", $this->author);
        return $stmt->execute();
    }

    // Delete an author
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>
