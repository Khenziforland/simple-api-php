<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

class Database {
    // Database parameters
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        // Set database parameters from environment variables
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->db_name = $_ENV['DB_NAME'] ?? 'simple_api_php';
        $this->username = $_ENV['DB_USERNAME'] ?? 'reyhan';
        $this->password = $_ENV['DB_PASSWORD'] ?? 'reyhan';
    }

    // Database connection
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
