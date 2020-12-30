<?php ?>

<link rel="stylesheet" href="css/order_form.css">
<link rel="stylesheet" href="css/order_recap.css">
<div class="main">

    <?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["continue"])) {
            header("Location:?page=order_info");
        } else {
            $_SESSION["paymentId"] = $_POST["id_payment_method"];
            $_SESSION["deliveryId"] = $_POST["id_delivery_method"];
            header("Location:?page=choose_delivery");
        }
    }
    ?>

    <form method="post">
        <h3>Výběr dopravy</h3>
        <select name="id_delivery_method">
            <?php

            use services\OrderController;

            $deliveryMethods = OrderController::getDeliveryMethods();
            foreach ($deliveryMethods as $method):
                ?>
                <option value=<? echo $method["id"] ?>><?
                    echo $method["name"] . ". " . "cena: " . $method["price"]
                    ?></option>
            <? endforeach; ?>
        </select>

        <h3>Výběr způsobu platby</h3>
        <select name="id_payment_method">
            <?php
            $paymentMethods = OrderController::getPaymentMethods();
            foreach ($paymentMethods as $method):
                ?>

                <option value=<? echo $method["id"] ?>><?
                    echo $method["name"] . ". " . "cena: " . $method["price"]

                    ?></option>
            <? endforeach; ?>
        </select>


        <? if (OrderController::canOrder()): ?>
            <h4>
                Vybráno:
            </h4>
            <p>Způsob Dopravy: <? echo \services\OrderRepository::getDeliveryMethodName($_SESSION["deliveryId"]) ?></p>
            <p>Způsob platby: <? echo \services\OrderRepository::getPaymentName($_SESSION["paymentId"]) ?></p>
        <?
        endif;
        ?>

        <div id="cena">
            <div style="align-self: flex-end; padding-bottom: 2px">Cena:</div>
            <div class="cena-s-dph "><? echo OrderController::getTotalCost() ?> Kč</div>
        </div>


        <input type="submit" value="Vyber">
    </form>
    <?
    if (OrderController::canOrder()):
        ?>
        <form method="post">
            <input type="hidden" name="continue" value="true">
            <input type="submit" value="Pokračuj">

        </form>
    <? endif; ?>

</div>