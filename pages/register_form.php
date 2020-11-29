<link rel="stylesheet" href="css/order_form.css">
<link rel="stylesheet" href="css/message.css">
<?php

use services\AuthController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $homeNumber = $_POST["home_number"];
    $zip = $_POST["zip"];
    $phoneNumber = $_POST["phone_number"];

    $user = AuthController::register($password, $name
        , $surname, $email, $phoneNumber,
        $city, $street, $homeNumber, $zip);

    if ($user == null) {
        $_SESSION[MESSAGE] = "Uživatel s tímto emailem je již registrován.";
    }
}

?>
<section class="main">
    <h3 class="formTitle">Registrace</h3>

    <?php
    if (isset($_SESSION[MESSAGE])) {
        echo "<p class='errMessage'>{$_SESSION[MESSAGE]}</p>";
        unset($_SESSION[MESSAGE]);
    }
    ?>

    <form action="?page=<?php echo REGISTER ?>" method="post">


        <div class="input-group">
            <label>Jméno </label>
            <input name="name" type="text" required/>
        </div>

        <div class="input-group">
            <label>Přijmení </label>
            <input name="surname" type="text" required/>
        </div>

        <div class="input-group">
            <label>Email </label>
            <input name="email" type="email" required/>
        </div>
        <div class="input-group">
            <label>Heslo </label>
            <input name="password" type="password" required/>
        </div>
        <div class="input-group">
            <label>Město </label>
            <input name="city" type="text" required/>
        </div>
        <div class="input-group">
            <label>Ulice </label>
            <input name="street" type="text" required/>
        </div>

        <div class="input-group">
            <label>Číslo popisné </label>
            <input name="home_number" type="number" required/>
        </div>
        <div class="input-group">
            <label>PSČ </label>
            <input name="zip" type="number" required/>
        </div>

        <div class="input-group">
            <label>Telefonní číslo </label>
            <input name="phone_number" type="number" required/>
        </div>


        <div class="row">
            <input class="button"
                   type="submit"
                   value="Registrovat"
            >
        </div>

    </form>
</section>
