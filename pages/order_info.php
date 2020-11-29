<?php ?>
<link rel="stylesheet" href="css/order_info.css">
<link rel="stylesheet" href="css/order_form.css">

<section class="main">
    <?


    use services\AuthController;
    use services\DeliveryRepository;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["useMyProfile"])) {
            $_SESSION["useMyProfile"] = true;

        } elseif (isset($_POST["name"])) {

            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $city = $_POST["city"];
            $street = $_POST["street"];
            $homeNumber = $_POST["home_number"];
            $zip = $_POST["zip"];
            $phoneNumber = $_POST["phone_number"];

            $deliveryId = DeliveryRepository::create($name, $surname, $email, $phoneNumber, $city, $street, $homeNumber, $zip);
            $_SESSION["deliveryInfo"] = $deliveryId;
        }
        header("Location: ?page=recapitulation");
    }
    ?>

    <!--
        <h3>
            Způsob dodání
        </h3>

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


    <?

    if (AuthController::isLoggedIn()):
        ?>
        <form method="post">
            <h2>
                Osobní ůdaje
            </h2>

            <div>
                <input type="hidden" name="useMyProfile" value="true">
                <input class="button"
                       type="submit"
                       value="Použij ůdaje z mého profilu"
                >
            </div>
        </form>
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