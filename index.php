<!DOCTYPE html>
<html lang="en">
<?php

function write_log($log_msg)
{
    $log_filename = "logs";
    if (!file_exists($log_filename)) {
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename . '/debug.log';
    file_put_contents($log_file_data, time() . "  " . $log_msg . "\n", FILE_APPEND);

}

write_log("new start =====================================");
include "head.php";
session_start();
include_once "Constants.php";
include_once "services/AuthControler.php";
include_once "services/Connection.php";
include_once "services/UserControler.php";
?>
<body>
<?php
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
    }
}
?>

</body>
</html>