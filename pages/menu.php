<nav id="hamnav">
    <!-- [THE HAMBURGER] -->
    <label for="hamburger">&#9776;</label>
    <input type="checkbox" id="hamburger"/>

    <!-- [MENU ITEMS] -->
    <div id="hamitems">
        <a href="?page=<? echo SHOP ?>">Obchod</a>
        <a href="?page=<? echo REGISTER ?>">Registrovat</a>


        <?

        use services\AuthController;

        if (AuthController::isLoggedIn()) {

            echo "<a href='?page=profile'>Profil</a>";
            echo "<<a href='?page=logout' onclick=''>Odhlásit</a>";

            if (AuthController::isAdmin()) {
                echo "<a href='?page=adminControler'>Správa uživatelů</a>";
            }
        } else {
            echo "<a href='?page=login' >Přihlásit</a>";
        } ?>

    </div>

</nav>
