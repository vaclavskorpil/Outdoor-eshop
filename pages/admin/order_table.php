<?php use services\AuthController;

if (AuthController::isAdmin()): ?>
    <?php
    $users = UserRepository::getAll();


    if(isset($_GET["action"]) && $_GET["action"] == "delete"){
        UserRepository::deleteUser($_POST["id"]);
        unset($_POST["id"]);
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
    <?php foreach ($users as $user): ?>
        <tr>

            <td><? echo $user->getName() ?></td>
            <td><? echo $user->getSurname() ?></td>
            <td><? echo $user->getEmail() ?></td>
            <td><? echo $user->getStreet() ?></td>
            <td><? echo $user->getCity() ?></td>
            <td><? echo $user->getZip() ?></td>
            <td>
                <form action="?page=<? echo PROFILE ?>&action=update" method="post">
                    <input type="hidden" name="id" value=<? echo $user->getId() ?>>
                    <input type="submit" value="Edituj">
                </form>
            </td>

            <td>
                <form action="?page=<? echo ADMIN_CONTROLER ?>&action=delete" method="post">
                    <input type="hidden" name="id" value=<? echo $user->getId() ?>>
                    <input type="submit" value="Smaž">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
<?php endif; ?>