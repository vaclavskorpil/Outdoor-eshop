<!DOCTYPE html>
<html lang="en">
<?php
include_once "includes.php";
session_start();
?>
<body>
<?php

use entities\user;
include "pages/menu.php";

if (isset($_GET["page"])) {
    switch ($_GET["page"]) {
        case REGISTER:
            include "pages/registerForm.php";
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
            include "pages/usersTable.php";
            break;
        case SHOP:
            include "pages/shop.php";
            break;
        default:
            include "pages/shop.php";
    }
}
?>

</body>
</html>