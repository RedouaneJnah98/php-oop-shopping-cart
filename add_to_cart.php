<?php
// parameters
$product_id = $_GET['id'] ?? '';
$quantity = 1;

// connect to the database
include "config/Database.php";
// include objects
include "objects/CartItem.php";
// get the database connection
$database = new Database();
$db = $database->getConnection();

// initialize classes
$cart_item = new CartItem($db);
$cart_item->user_id = 1; // we set the default to 1 because we do not have logged-in user
$cart_item->product_id = $product_id;
$cart_item->quantity = $quantity;

// check if the product exists in the cart
if ($cart_item->exists()) {
    // redirect to product list and tell the user it was added to the cart
    header("Location: cart.php?action=exists");
} else {
  // add to cart
    if ($cart_item->create()) {
        // redirect to product list and tell the user it was added to the cart
        header("Location: cart.php?id={$product_id}&action=added");
    } else {
        header("Location: cart.php?id={$product_id}&action=unable_to_add");
    }
}