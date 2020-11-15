<link rel="stylesheet" href="css/form.css">
<?php

use services\AuthController;

if (AuthController::isLoggedIn()):

    $id = $_SESSION[USER_ID];
    $destination = PROFILE;

    if (isset($_GET["action"])) {
        $destination = ADMIN_CONTROLER;

        $id = $_POST["id"];
    }
    if (isset($_POST["name"])) {
        UserController::updateUserById($id, $_POST["name"], $_POST["surname"], $_POST["phone_number"], $_POST["city"], $_POST["street"], $_POST["home_number"], $_POST["zip"]);
        header("Location: ?page=$destination");
    }
    $user = UserController::getById($id);
    ?>


    <section class="centeredContentWrapper">
        <h3 class="formTitle">Profil
            uživatele <? echo $user->getDeliveryInfo()->getName() . " " . $user->getDeliveryInfo()->getSurname() ?></h3>
        <form method="post">
            <div class="input-group">
                <input name="name" type='text' required value=<? echo $user->getDeliveryInfo()->getName() ?> required/>
                <label>Jméno </label>
            </div>
            <div class="input-group">
                <input name="id" type='hidden' required value=<? echo $user->getId() ?>>
            </div>

            <div class="input-group">
                <input name="surname" type="text" value=<? echo $user->getDeliveryInfo()->getSurname() ?> required/>

                <label>Přijmení </label>
            </div>
            <div class="input-group">
                <input name="city" type="text" value=<? echo $user->getDeliveryInfo()->getCity() ?> required/>
                <label>Město </label>
            </div>
            <div class='input-group'>
                <input name='street' type='text' value=<? echo $user->getDeliveryInfo()->getStreet() ?> required/>
                <label>street </label>
            </div>

            <div class='input-group'>
                <input name='home_number' type='number'
                       value=<? echo $user->getDeliveryInfo()->getHomeNumber() ?> required/>
                <label>Číslo popisné </label>
            </div>

            <div class='input-group'>
                <input name='zip' type='number' value=<? echo $user->getDeliveryInfo()->getZip() ?> required/>
                <label>PSČ </label>
            </div>


            <div class='input-group'>
                <input name='phone_number' type='number' value=<? echo $user->getPhoneNumber() ?> required/>
                <label>Telefonní číslo </label>
            </div>


            <div class='row'>
                <input class='button'
                       type='submit'
                       value='Změmit údaje'
                >
            </div>

        </form>
    </section>
<?php endif; ?>

