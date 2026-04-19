<?php
class Product {
    private $conn;
    private $table = "products";

    public $id;
    public $product;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $this->product = $row['product'];
            $this->price = $row['price'];
        }
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (product, price)
                  VALUES (:product, :price)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':product', $this->product);
        $stmt->bindParam(':price', $this->price);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET product = :product, price = :price
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':product', $this->product);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
?>