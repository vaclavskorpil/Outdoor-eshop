<link rel="stylesheet" href="css/form.css">
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
<section class="centeredContentWrapper">
    <h3 class="formTitle">Registrace</h3>

    <?php
    if (isset($_SESSION[MESSAGE])) {
        echo "<p class='errMessage'>{$_SESSION[MESSAGE]}</p>";
        unset($_SESSION[MESSAGE]);
    }
    ?>

    <form action="?page=<?php echo REGISTER ?>" method="post">


        <div class="input-group">
            <input name="name" type="text" required/>

            <label>Jméno </label>
        </div>

        <div class="input-group">
            <input name="surname" type="text" required/>

            <label>Přijmení </label>
        </div>
        <div class="input-group">
            <input name="email" type="email" required/>
            <label>Email </label>

        </div>
        <div class="input-group">
            <input name="password" type="password" required/>
            <label>Heslo </label>
        </div>
        <div class="input-group">
            <input name="city" type="text" required/>
            <label>Město </label>
        </div>
        <div class="input-group">
            <input name="street" type="text" required/>
            <label>Ulice </label>
        </div>
        <div class="input-group">
            <input name="home_number" type="number" required/>
            <label>Číslo popisné </label>
        </div>
        <div class="input-group">
            <input name="zip" type="number" required/>
            <label>PSČ </label>
        </div>
        <div class="input-group">
            <input name="phone_number" type="number" required/>
            <label>PSČ </label>
        </div>


        <div class="row">
            <input class="button"
                   type="submit"
                   value="Registrovat"
            >
        </div>

    </form>
</section>
