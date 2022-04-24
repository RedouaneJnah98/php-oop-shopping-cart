<?php
// include classes
include_once "config/Database.php";
include_once "objects/CartItem.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);

// remove all cart item by user, from database
$cart_item->user_id = 1; // we default to '1' because we do not have logged-in user
$cart_item->deleteByUser();

// set page title
$page_title = "Thank You!";

// include page header HTML
include_once 'layout_head.php';

// tell the user order has been placed
echo "<div class='col-md-12'>
    <div class='alert alert-success'>
        <strong>Your order has been placed!</strong> Thank you very much!
    </div>
</div>";

// include page footer HTML
include_once 'layout_footer.php';