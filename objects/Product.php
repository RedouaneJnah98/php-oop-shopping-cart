<?php

class Product
{
    // database connection
    private $conn;
    private string $table_name = 'products';

    // properties
    public int $id;
    public string $name;
    public float $price;
    public string $description;
    public int $category_id;
    public string $category_name;
    public string $timestamp;

    //constructor
    public function __construct( $db)
    {
    $this->conn = $db;
    }

    public function read($from_record_num, $records_per_page)
    {
        $query = 'SELECT id, name, description, price FROM ' . $this->table_name . ' ORDER BY created DESC LIMIT ?, ?';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind limit clause variables
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    public function count()
    {
        // query to count all product records
        $query = 'SELECT count(*) FROM ' . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get row value
        $rows = $stmt->fetch(PDO::FETCH_NUM);

        /* @return */
        return $rows[0];
    }
}