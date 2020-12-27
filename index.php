<!DOCTYPE html>
<html lang="en">

<?php
include_once "head.php";
include_once "includes.php";

session_start();
?>
<body style="background: #757575">
<?php

use entities\Product;
use entities\user;
use services\AuthController;

if (!isset($_GET["page"])) {
    header("Location:?page=shop");
}

if (isset($_GET["page"]) && $_GET["page"] == LOGOUT) {
    include "elements/logout.php";
}
include "pages/menu.php";
if (AuthController::isAdmin()) {
    include "pages/admin/admin_menu.php";

    if (isset($_GET["page"])) {
        switch ($_GET["page"]) {
            case "user_control":
                include "pages/admin/users_table.php";
                break;
            case "order_control":
                include "pages/admin/orders_table.php";
                break;
            case "product_control":
                include "pages/admin/product_control.php";
                break;
            case "add_product":
                include "pages/admin/add_product.php";
                break;
        }
    }
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
        case "detail":
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
    }

}
?>

</body>
</html>