<!DOCTYPE html>
<html lang="en">
<?php
include_once "includes.php";

session_start();
?>
<body>
<?php

use entities\Product;
use entities\user;

include "pages/menu.php";


if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if (isset($_GET["page"])) {
    switch ($_GET["page"]) {
        case REGISTER:
            include "pages/register_form.php";
            break;
        case LOGIN:
            include "pages/login.php";
            break;
        case PROFILE:
            include "pages/profile.php";
            break;
        case LOGOUT:
            include "elements/logout.php";
            break;
        case ADMIN_CONTROLER:
            include "pages/users_table.php";
            break;
        case "cart":
            include "pages/cart.php";
            break;
        case SHOP:
            include "pages/shop.php";
            break;
        case "order_info":
            include "pages/order_info.php";
            break;
        case "recapitulation":
            include "pages/order_recap.php";
            break;
        default:
            include "pages/shop.php";
    }
}
?>

</body>
</html>