<?php
class Product
{
    // Database connection
    private $conn;
    private $table = 'products';

    // Product properties
    public $id;
    public $product_category_id;
    public $product_category_name;
    public $name;
    public $description;
    public $price;
    public $file;
    public $created_at;

    // Constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Read products
    public function read()
    {
        // Select all query
        $query = "SELECT 
        p.id, 
        c.name as product_category_name, 
        p.product_category_id, 
        p.name, 
        p.description, 
        p.price, 
        p.file, 
        p.created_at 
        FROM 
            " . $this->table . " p 
        LEFT JOIN 
            product_categories c ON p.product_category_id = c.id 
        ORDER BY 
            p.created_at DESC";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Product
    public function read_single()
    {
        // Read Single Product query
        $query = 'SELECT 
        p.id, 
        c.name as product_category_name, 
        p.product_category_id, 
        p.name, 
        p.description, 
        p.price, 
        p.file, 
        p.created_at 
        FROM 
            ' . $this->table . ' p
        LEFT JOIN
            product_categories c ON p.product_category_id = c.id
        WHERE
            p.id = :id
        LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if ($row) {
            // If data is found
            $this->name = $row['name'];
            $this->description = $row['description'];

            $this->price = $row['price'];

            $this->product_category_id = $row['product_category_id'];
            $this->product_category_name = $row['product_category_name'];
            $this->file = $row['file'];
        }
    }

    // Create Product
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' 
        SET 
            product_category_id = :product_category_id, 
            name = :name, 
            description = :description, 
            price = :price,
            file = :file';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->product_category_id = htmlspecialchars(strip_tags($this->product_category_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->file = htmlspecialchars(strip_tags($this->file));

        // Bind data
        $stmt->bindParam(':product_category_id', $this->product_category_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':file', $this->file);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update Product
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
        SET 
            product_category_id = :product_category_id,
            name = :name,
            description = :description,
            price = :price';

        // Check if file is uploaded
        if (!empty($this->file)) {
            $query .= ', file = :file';
        }

        $query .= ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->product_category_id = htmlspecialchars(strip_tags($this->product_category_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->file = htmlspecialchars(strip_tags($this->file));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':product_category_id', $this->product_category_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':file', $this->file);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Product
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
