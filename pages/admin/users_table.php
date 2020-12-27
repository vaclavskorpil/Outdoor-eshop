<link rel="stylesheet" href="css/basic_table.css">
<link rel="stylesheet" href="css/order_form.css">
<?php use services\AuthController;

if (AuthController::isAdmin()): ?>
    <?php
    $users = UserRepository::getAll();


    if (isset($_GET["action"]) && $_GET["action"] == "delete") {
        UserRepository::deleteUser($_POST["id"]);
        unset($_POST["id"]);
        header("Location: ?page=" . ADMIN_CONTROLER);
    }

    ?>

    <div class="main">
        <table>
            <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th></th>
                <th></th>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>

                    <td><? echo $user["email"] ?></td>
                    <td><? echo $user["role"] ?></td>
                    <td>
                        <form action="?page=<? echo PROFILE ?>&action=update" method="post">
                            <input type="hidden" name="id" value=<? echo $user["id"] ?>>
                            <input type="submit" value="Edituj">
                        </form>
                    </td>

                    <td>
                        <form action="?page=<? echo ADMIN_CONTROLER ?>&action=delete" method="post">
                            <input type="hidden" name="id" value=<? echo $user["id"] ?>>
                            <input type="submit" value="Smaž">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
    </div>
<?php endif; ?>