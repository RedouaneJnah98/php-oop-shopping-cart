<?php
$product_id = $_GET['id'] ?? 1;
$quantity = $_GET['quantity'] ?? '';

// make quantity minimum to 1
$quantity = $quantity <=0 ? 1 : $quantity;

// connect to database
include 'config/database.php';

// include object
include_once "objects/CartItem.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);

// set cart item values
$cart_item->user_id=1; // we default to '1' because we do not have logged-in user
$cart_item->product_id=$product_id;
$cart_item->quantity=$quantity;

// add to cart
if($cart_item->update()){
    // redirect to product list and tell the user it was added to cart
    header("Location: cart.php?action=updated");
}else{
    header("Location: cart.php?action=unable_to_update");
}