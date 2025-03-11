<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $price;
    public $stock;
    public $category_id;
    public $category_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT p.id, p.name, p.price, p.stock, p.category_id, c.name as category_name 
                  FROM " . $this->table_name . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=:name, price=:price, stock=:stock";
        
        if(!empty($this->category_id)) {
            $query .= ", category_id=:category_id";
        }
        
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":stock", $this->stock);
        
        if(!empty($this->category_id)) {
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $stmt->bindParam(":category_id", $this->category_id);
        }
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    public function readOne() {
        $query = "SELECT p.id, p.name, p.price, p.stock, p.category_id, c.name as category_name 
                  FROM " . $this->table_name . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->name = $row['name'];
            $this->price = $row['price'];
            $this->stock = $row['stock'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
            return true;
        }
        
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                    name = :name,
                    price = :price,
                    stock = :stock";
        
        if(!empty($this->category_id)) {
            $query .= ", category_id = :category_id";
        } else {
            $query .= ", category_id = NULL";
        }
        
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":id", $this->id);
        
        if(!empty($this->category_id)) {
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $stmt->bindParam(":category_id", $this->category_id);
        }
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>