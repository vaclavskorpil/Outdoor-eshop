<nav id="hamnav">
    <!-- [THE HAMBURGER] -->
    <label for="hamburger">&#9776;</label>
    <input type="checkbox" id="hamburger"/>

    <!-- [MENU ITEMS] -->
    <div id="hamitems">
        <a href="?page=<? echo REGISTER ?>">Registrovat</a>


        <?
        if (AuthControler::isLoggedIn()) {

            echo "<a href='?page=profile'>Profil</a>";
            echo "<<a href='?page=logout' onclick=''>Odhlásit</a>";

            if (AuthControler::isAdmin()) {
                echo "<a href='?page=adminControler'>Správa uživatelů</a>";
            }
        } else {
            echo "<a href='?page=login' >Přihlásit</a>";
        } ?>

    </div>

</nav>
