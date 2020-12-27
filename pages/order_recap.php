<?php

use services\DeliveryRepository;
use services\OrderController;


if (isset($_SESSION["deliveryInfoId"])) {
    $deliveryInfo = DeliveryRepository::getById($_SESSION["deliveryInfoId"]);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    OrderController::createOrder();
    $POST["orderCreated"] = true;
}

?>
<link rel="stylesheet" href="css/order_form.css">
<link rel="stylesheet" href="css/order_recap.css">
<section class="main">
    <?php if (!isset($POST["orderCreated"])): ?>
        <?php if (isset($deliveryInfo)): ?>
            <h3>
                Dokončení objednávky.
            </h3>

            <div class="delivery-info">
                <div>
                    <? echo $deliveryInfo["name"] ?><? echo " " . $deliveryInfo["surname"] ?>
                </div>
                <div>
                    <? echo $deliveryInfo["street"] ?> <? echo $deliveryInfo["home_number"] ?>,
                </div>
                <div>
                    <? echo $deliveryInfo["city"] ?>, <? echo $deliveryInfo["zip"] ?>
                </div>
                <div>
                    tel.: <? echo $deliveryInfo["phone_number"] ?>
                </div>
            </div>

            <div id="cena">
                <div style="align-self: flex-end; padding-bottom: 2px">Cena:</div>
                <div class="cena-s-dph "><? echo OrderController::getTotalCost() ?> Kč</div>

            </div>

            <form method="post">
                <input type="hidden" name="order" value="true">
                <input type="submit" value="Objednej">
            </form>

        <? else: ?>
            <h3>
                Někde se objevila chyba. Zkuste znovu projít objednávku.
            </h3>
        <? endif; ?>


    <? else: ?>
        <h3>
            Objednávka úspěšně vytvořena.
        </h3>


        <form action="?page=shop" method="get">
            <input type="hidden" name="page" value="shop">
            <input type="submit" value="Zpět do obchodu">
        </form>
    <? endif; ?>

</section>