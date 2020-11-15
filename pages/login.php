<link rel="stylesheet" href="css/form.css">
<link rel="stylesheet" href="css/message.css">
<?php

use services\AuthController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST["email"];
    $password = $_POST["heslo"];

    $success = AuthController::login($email, $password);
    if (!$success) {
        $_SESSION[MESSAGE] = "Chybné jméno nebo heslo.";
    } else {
        $_SESSION[MESSAGE] = "Jste přihlášen.";
        $_GET["page"] = "main";
        header("Refresh:0");
    }
}
?>
<section class="centeredContentWrapper">
    <h3 class="formTitle">Přihlášení</h3>

    <?php
    if (isset($_SESSION[MESSAGE])) {
        echo "<p class='errMessage'>{$_SESSION[MESSAGE]}</p>";
        unset($_SESSION[MESSAGE]);
    }
    ?>
    <form action="?page=<?php echo LOGIN ?>" method="post">

        <div class="input-group">
            <input name="email" type="email" required/>
            <label>Email </label>

        </div>
        <div class="input-group">
            <input name="heslo" type="password" required/>
            <label>Heslo </label>
        </div>


        <div class="row">
            <input class="button"
                   type="submit"
                   value="Přihlásit se."
            >
        </div>

    </form>
</section>


