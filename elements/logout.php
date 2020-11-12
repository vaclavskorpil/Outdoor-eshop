<?php

if($_SESSION[LOGGED_USER_EMAIL]){
    unset($_SESSION[LOGGED_USER_EMAIL]);
    header("Location: ?page=login");
    header("Refresh:0");
}