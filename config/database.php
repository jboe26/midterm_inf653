<?php
class Database {
    private $host = "dpg-cv6e76ij1k6c73e4km90-a.virginia-postgres.render.com"; // Render's PostgreSQL host
    private $port = "5432"; // Default PostgreSQL port
    private $db_name = "quotesdb_mmyy"; // Your database name
    private $username = "quotesdb_mmyy_user"; // Your database username
    private $password = "hVUxet00tR8teAmPEPq4KcD2dHksICDy"; // Your database password
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // PostgreSQL DSN
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            
            // Create PDO connection
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);

        } catch (PDOException $exception) {
            // Display error if connection fails
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
