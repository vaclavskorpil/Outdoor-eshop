<?php if (AuthControler::isAdmin()): ?>
    <?php
    $users = UserControler::getAll();


    if(isset($_GET["action"]) && $_GET["action"] == "delete"){
        UserControler::deleteUser($_POST["email"]);
        header( "Location: ?page=".ADMIN_CONTROLER);
    }
    ?>


    <table width="100%">
    <thead>
    <tr>
        <th>Jméno</th>
        <th>Přijmení</th>
        <th>Email</th>
        <th>Ulice</th>
        <th>Město</th>
        <th>PSČ</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $row): array_map('htmlentities', $row); ?>
        <tr>

            <td><? echo $row["jmeno"] ?></td>
            <td><? echo $row["prijmeni"] ?></td>
            <td><? echo $row["email"] ?></td>
            <td><? echo $row["ulice"] ?></td>
            <td><? echo $row["mesto"] ?></td>
            <td><? echo $row["psc"] ?></td>
            <td>
                <form action="?page=<? echo PROFILE ?>&action=update" method="post">
                    <input type="hidden" name="email" value=<? echo $row["email"] ?>>
                    <input type="submit" value="Edituj">
                </form>
            </td>

            <td>
                <form action="?page=<? echo ADMIN_CONTROLER ?>&action=delete" method="post">
                    <input type="hidden" name="email" value=<? echo $row["email"] ?>>
                    <input type="submit" value="Smaž">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
<?php endif; ?>