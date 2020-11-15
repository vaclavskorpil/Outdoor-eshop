<?php

if($_SESSION[USER_ID]){
    unset($_SESSION[USER_ID]);
    header("Location: ?page=login");
    header("Refresh:0");
}