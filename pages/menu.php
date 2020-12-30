<nav id="hamnav">
    <label for="hamburger">&#9776;</label>
    <input type="checkbox" id="hamburger"/>

    <div id="hamitems">
        <a href="?page=<? echo SHOP ?>">Obchod</a>
        <a href="?page=<? echo REGISTER ?>">Registrovat</a>
        <?

        use services\AuthController;

        if (AuthController::isLoggedIn()) {

            echo "<a href='?page=profile'>Profil</a>";
            echo "<<a href='?page=logout' onclick=''>Odhlásit</a>";

        } else {
            echo "<a href='?page=login' >Přihlásit</a>";
        } ?>
        <a href="?page=cart">Košík</a>
    </div>
</nav>
