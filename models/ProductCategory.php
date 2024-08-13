<?php
class ProductCategory
{
    // Database connection
    private $conn;
    private $table = 'product_categories';

    // Product Category properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Read Product Categories
    public function read()
    {
        // Select all query
        $query = "SELECT 
            id, 
            name, 
            created_at 
        FROM 
            " . $this->table . " 
        ORDER BY 
            name ASC";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Category
    public function read_single()
    {
        // Create query
        $query = 'SELECT 
        id, 
            name, 
            created_at 
        FROM 
            ' . $this->table . '
        WHERE
            id = :id
        LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];
    }

    // Create Product Category
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' 
        SET 
            name = :name';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind data
        $stmt->bindParam(':name', $this->name);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update Product Category
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
        SET 
            name = :name
        WHERE
            id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Product Category
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
