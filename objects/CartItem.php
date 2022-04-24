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
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

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

    public function create(): bool
    {
        // to get timestamp for created field
        $this->created = date('Y-m-d H:i:s');

        // insert query
        $query = "INSERT INTO " . $this->table_name . " SET product_id = :product_id, quantity = :quantity, user_id = :user_id, created = :created";
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // bind values
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":created", $this->created);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read()
    {
        $query="SELECT p.id, p.name, p.price, ci.quantity, ci.quantity * p.price AS subtotal
            FROM " . $this->table_name . " ci
                LEFT JOIN products p
                    ON ci.product_id = p.id
            WHERE ci.user_id=:user_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind value
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    public function update(): bool
    {
        // query to insert cart item record
        $query = "UPDATE " . $this->table_name . "
            SET quantity = :quantity
            WHERE product_id = :product_id AND user_id = :user_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind values
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function delete(): bool
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE product_id = :product_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind ids
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function deleteByUser(): bool
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id=:user_id";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind id
        $stmt->bindParam(":user_id", $this->user_id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}