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
use services\AuthController;


if(isset($_GET["page"]) && $_GET["page"] == LOGOUT){
    include "elements/logout.php";
}

if (AuthController::isAdmin()) {
    include "pages/admin/admin_menu.php";

    if (isset($_GET["page"])) {
        switch ($_GET["page"]) {
            case "user_control":
                include "pages/admin/users_table.php";
                break;
            case "order_control":
                include "pages/admin/order_table.php";
                break;
        }
    }
} else {
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
            case "my_orders":
                include "pages/my_orders.php";
                break;
            case "order_detail":
                include "pages/order_detail.php";
                break;

            default:
                include "pages/shop.php";
        }
    }
}
?>

</body>
</html>