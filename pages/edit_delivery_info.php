<?php

use services\AuthController;
use services\DeliveryRepository;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["email"])) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $homeNumber = $_POST["home_number"];
    $zip = $_POST["zip"];
    $phoneNumber = $_POST["phone_number"];

    DeliveryRepository::updateDeliveryInfo($name
        , $surname, $email, $phoneNumber,
        $city, $street, $homeNumber, $zip, $_SESSION["editDeliveryId"]);
    $_SESSION["editDeliveryId"];

    if (AuthController::isAdmin()) {
        header("Location:?page=user_control");
    } else {
        header("Location:?page=profile");
    }
}

?>
<?php if (isset($_SESSION["editDeliveryId"])):
    $info = DeliveryRepository::getById($_SESSION["editDeliveryId"]);
    ?>
    <link rel="stylesheet" href="css/order_form.css">
    <section class="main">
        <h3 class="formTitle">Editace </h3>

        <form method="post">

            <div class="input-group">
                <label>Jméno </label>
                <input name="name" type="text" value=<? echo $info["name"] ?> required/>
            </div>

            <div class="input-group">
                <label>Přijmení </label>
                <input name="surname" type="text" value=<? echo $info["surname"] ?> required/>
            </div>

            <div class="input-group">
                <label>Email </label>
                <input name="email" type="email" value=<? echo $info["email"] ?> required/>
            </div>
            <div class="input-group">
                <label>Město </label>
                <input name="city" type="text" value=<? echo $info["city"] ?> required/>
            </div>
            <div class="input-group">
                <label>Ulice </label>
                <input name="street" type="text" value=<? echo $info["street"] ?> required/>
            </div>

            <div class="input-group">
                <label>Číslo popisné </label>
                <input name="home_number" type="number" value=<? echo $info["home_number"] ?> required/>
            </div>
            <div class="input-group">
                <label>PSČ </label>
                <input name="zip" type="number" value=<? echo $info["zip"] ?> required/>
            </div>

            <div class="input-group">
                <label>Telefonní číslo </label>
                <input name="phone_number" type="number" value=<? echo $info["phone_number"] ?> required/>
            </div>

            <div class="row">
                <input class="button"
                       type="submit"
                       value="Změnit údaje"
                >
            </div>
        </form>
    </section>
<?php endif; ?>