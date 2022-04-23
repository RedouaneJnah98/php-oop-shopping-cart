<?php

// for database connection
include "config/Database.php";

// include Classes
include_once "objects/Product.php";
include_once "objects/CartItem.php";
include_once "objects/ProductImage.php";

// set page title
$page_title= 'Products';

//page header html
include "layout_head.php";

// contents will be here

// layout footer code
include "layout_footer.php";