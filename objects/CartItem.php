<?php

class CartItem
{
    // database connection and table name
    private $conn;
    private string $table_name = "cart_items";

    // object properties
    public int $id;
    public int $product_id;
    public int $quantity;
    public int $user_id;
    public string $created;
    public string $modified;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function exists(): bool
    {
        // query to count existing cart item
        $query = "SELECT count(*) FROM " . $this->table_name . " WHERE product_id=:product_id AND user_id=:user_id";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind category id variable
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);

        // execute query
        $stmt->execute();

        // get row value
        $rows = $stmt->fetch(PDO::FETCH_NUM);

        // return
        if($rows[0]>0){
            return true;
        }

        return false;
    }

    public function count()
    {
        // query to count existing cart item
        $query = 'SELECT count(*) FROM ' . $this->table_name . ' WHERE user_id = :user_id';
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // bind user id variable
        $stmt->bindParam(':user_id', $this->user_id);
        // execute query
        $stmt->execute();
        // get row value
        $rows = $stmt->fetch(PDO::FETCH_NUM);

        // return rows array
        return $rows[0];
    }
}