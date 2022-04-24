<?php
/* @includes */
// for database connection
include "config/Database.php";
// include Classes
include_once "objects/Product.php";
include_once "objects/CartItem.php";
include_once "objects/ProductImage.php";

/* @database_connection */
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);

/*
 * action for custom messages
 */
$action = $_GET['action'] ?? '';

// for pagination purposes
$page = $_GET['page'] ?? 1; // page is the current page, if there's nothing set, default is 1
$records_per_page = 6; // rows of data per page
$from_record_num = ($records_per_page * $page)- $records_per_page; // calculate for the query LIMIT clause

/*
 * Read all the products in the Database
 */
$stmt = $product->read($from_record_num, $records_per_page);

// count number of retrieved products
$num = $stmt->rowCount();

// set page title
$page_title= 'Products';

//page header html
include "layout_head.php";

// contents will be here
// if products were more than zero
if ($num > 0) {
    // needed for paging
    $page_url = 'products.php?';
    $total_rows = $product->count();

    // show products
    include "read_products_template.php";
} else {
    echo "<div class='col-md-12'>
    <div class='alert alert-danger'>No products found.</div>
</div>";
}

// layout footer code
include "layout_footer.php";