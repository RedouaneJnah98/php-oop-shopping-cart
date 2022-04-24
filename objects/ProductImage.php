<?php

class ProductImage
{
    // database connection
    private $conn;
    private string $table_name = 'product_images';

    // properties
    public $id;
    public  $product_id;
    public  string $name;
    public  $timestamp;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function readFirst()
    {
        // select query
        $query = "SELECT id, product_id, name
            FROM " . $this->table_name . "
            WHERE product_id = ?
            ORDER BY name DESC
            LIMIT 0, 1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind product id variable
        $stmt->bindParam(1, $this->product_id);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    public function readByProductId()
    {
        // select query
        $query = "SELECT id, product_id, name
            FROM " . $this->table_name . "
            WHERE product_id = ?
            ORDER BY name ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        // bind product id variable
        $stmt->bindParam(1, $this->product_id);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }
}