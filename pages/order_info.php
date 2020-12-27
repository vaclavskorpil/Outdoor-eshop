<?php ?>
<link rel="stylesheet" href="css/order_info.css">
<link rel="stylesheet" href="css/order_form.css">
<link rel="stylesheet" href="css/profile.css">

<section class="main">
    <?


    use services\AuthController;
    use services\DeliveryRepository;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["deliveryInfoId"])) {
            $_SESSION["deliveryInfoId"] = $_POST["deliveryInfoId"];

        } elseif (isset($_POST["name"])) {

            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $city = $_POST["city"];
            $street = $_POST["street"];
            $homeNumber = $_POST["home_number"];
            $zip = $_POST["zip"];
            $phoneNumber = $_POST["phone_number"];
            $userId = null;
            if (isset($_SESSION[USER_ID])) {
                $userId = $_SESSION[USER_ID];
            }
            $deliveryId = DeliveryRepository::create($name, $surname, $email, $phoneNumber, $city, $street, $homeNumber, $zip, $userId);
            $_SESSION["deliveryInfoId"] = $deliveryId;
        }
        header("Location: ?page=recapitulation");
    }
    ?>

    <!--


            <?php /*use services\OrderController;
        use services\AuthController;

        $methods = OrderController::getDeliveryMethods();
        foreach ($methods

                 as $method):
            */ ?>
            <input type="radio" id=<? /* echo $method["name"] */ ?> name="delivery" value=<? /* echo $method["id"] */ ?>>
            <div>
                <label for=<? /* echo $method["name"] */ ?>><? /* echo $method["name"] */ ?></label>
            </div><br>

        <? /* endforeach; */ ?>

        <h3>
            Typ platby
        </h3>
        <?php
    /*
            $methods = OrderController::getPaymentMethods();
            foreach ($methods as $method):*/ ?>

            <input type="radio" id=<? /* echo $method["name"] */ ?> name="payment" value=<? /* echo $method["id"] */ ?>>
            <label for=<? /* echo $method["name"] */ ?>><? /* echo $method["name"] */ ?></label><br>

        --><? /* endforeach; */ ?>

    <h2>
        Zadejte dodací ůdaje.
    </h2>
    <?

    if (AuthController::isLoggedIn()):
        ?>
        <h3>Vyberte si z údajů které máte na profilu.</h3>
        <? $deliveryInfo = UserRepository::getUsersDeliveryInfo($_SESSION[USER_ID]); ?>
        <div class="delivery-info-block">
        <? foreach ($deliveryInfo as $info): ?>
        <div class="delivery-info-card">
            <div>
                Jméno: <? echo $info["name"] ?>
            </div>
            <div>
                Příjmení: <? echo $info["surname"] ?>
            </div>

            <div>
                Kontaktní email: <? echo $info["email"] ?>
            </div>
            <div>
                Telefonní číslo: <? echo $info["phone_number"] ?>
            </div>

            <div>
                Adresa:
            </div>

            <div>
                <? echo $info["street"] . " " . $info["home_number"] ?>
            </div>
            <div>
                <? echo $info["zip"] . " " . $info["city"] ?>
            </div>
            <form method="post">
                <input type="hidden" name="deliveryInfoId" value=<? echo $info["id"] ?>>
                <input type="submit" value="Vyber">
            </form>
        </div>
        </div>
    <? endforeach; ?>
    <? endif; ?>
    <form action="" method="post">

        <div>
            <label>Jméno </label>
            <input name="name" type="text" required/>
        </div>

        <div>
            <label>Přijmení </label>
            <input name="surname" type="text" required/>
        </div>
        <div>
            <label>Email </label>
            <input name="email" type="email" required/>
        </div>
        <div>
            <label>Město </label>
            <input name="city" type="text" required/>
        </div>
        <div>
            <label>Ulice </label>
            <input name="street" type="text" required/>
        </div>
        <div>
            <label>Číslo popisné </label>
            <input name="home_number" type="number" required/>
        </div>
        <div>
            <label>PSČ </label>
            <input name="zip" type="number"/>
        </div>
        <div>
            <label>Telefonní číslo </label>
            <input name="phone_number" type="number" required/>
        </div>


        <div>
            <input class="button"
                   type="submit"
                   value="Pokračovat"
            >
        </div>


    </form>


</section>