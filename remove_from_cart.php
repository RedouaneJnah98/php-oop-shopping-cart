<?php
// get product ID
$product_id = $_GET['id'] ?? '';

// connect to database
include 'config/Database.php';

// include object
include_once "objects/CartItem.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);

// remove cart item from database
$cart_item->user_id=1; // we default to '1' because we do not have logged-in user
$cart_item->product_id=$product_id;
$cart_item->delete();

// redirect to product list and tell the user it was added to cart
header('Location: cart.php?action=removed&id=' . $id);