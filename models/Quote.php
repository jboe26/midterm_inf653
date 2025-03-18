<?php
class Quote {
    private $conn;
    private $table_name = "quotes";

    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all quotes
    public function read() {
        $query = "SELECT q.id, q.quote, a.author, c.category 
                  FROM " . $this->table_name . " q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get a single quote by ID
    public function read_single() {
        $query = "SELECT q.id, q.quote, a.author, c.category 
                  FROM " . $this->table_name . " q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Create a new quote
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (quote, author_id, category_id) 
                  VALUES (:quote, :author_id, :category_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quote", $this->quote);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":category_id", $this->category_id);
        return $stmt->execute();
    }

    // Update a quote
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET quote = :quote, author_id = :author_id, category_id = :category_id 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":quote", $this->quote);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":category_id", $this->category_id);
        return $stmt->execute();
    }

    // Delete a quote
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>
