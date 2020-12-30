<?php

use services\AuthController;
use services\DeliveryRepository;
use services\OrderRepository;
use services\ProductRepository;


if (isset($_GET["orderId"])):

    if (isset($_POST["orderState"])) {
        OrderRepository::changeOrderState($_GET["orderId"], $_POST["orderState"]);
        unset($_POST["orderState"]);
    }
    if (isset($_POST["delete"])) {
        OrderRepository::deleteOrder($_GET["orderId"]);
        unset($_POST["orderState"]);
        header("Location:?page=order_control");
    }

    ?>

    <?php
    $order = OrderRepository::getOrderDetail($_GET["orderId"]);
    $deliveryInfo = DeliveryRepository::getById($order["delivery_info"]);
    $paymentMethod = OrderRepository::getPaymentMethodForOrder($order["id"]);
    $deliveryMethod = OrderRepository::getDeliveryMethodForOrder($order["id"]);
    ?>
    <link rel="stylesheet" href="css/order_recap.css">
    <link rel="stylesheet" href="css/basic_table.css">
    <link rel="stylesheet" href="css/order_form.css">
    <section class="main">
        <h2>
            Detail objednávky č. <? echo $_GET["orderId"] ?>
        </h2>
        <div class="state">Stav: <? echo $order["status"] ?></div>
        <? if (AuthController::isAdmin()): ?>
            <div>
                <form method="post">
                    <select name="orderState">
                        <?php
                        $orderStates = OrderRepository::getAllOrderStates();
                        foreach ($orderStates as $state):
                            ?>

                            <option value=<? echo $state["id"] ?>><?
                                echo $state["name"];
                                ?></option>
                        <? endforeach; ?>
                    </select>
                    <input type="submit" value="Změň stav objednávky" style="width: 300px">
                </form>
                <form method="post">
                    <input type="hidden" value="delete" name="delete">
                    <input type="submit" value="Zmaž objednávku">
                </form>
            </div>
        <? endif; ?>
        <h3> Doručovací údaje</h3>
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
        <h3>
            Objednané produkty
        </h3>


        <table class="basic-table">

            <thead>
            <tr>
                <th> Název</th>
                <th> Cena za kus</th>
                <th> Počet kusů</th>
                <th> Celková cena</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <? $products = ProductRepository::getAllOrderProducts($_GET["orderId"]);
            foreach ($products as $product):
                ?>


                <tr>
                    <td class="cell-padd">
                        <? echo $product["name"] ?>
                    </td>
                    <td class="cell-padd">
                        <? echo $product["price"] ?> Kč
                    </td>


                    <td class="cell-padd">
                        <? echo $product["quantity"] ?> Ks
                    </td>

                    <td class="cell-padd">
                        <? echo($product["quantity"] * $product["price"]) ?> Kč
                    </td>
                </tr>


            <? endforeach; ?>

            <tr>
                <td class="cell-padd">
                    <? echo $deliveryMethod["name"] ?>
                </td>
                <td class="cell-padd">
                    <? echo $deliveryMethod["price"] ?> Kč
                </td>


                <td class="cell-padd">
                    1 Ks
                </td>

                <td class="cell-padd">
                    <? echo $deliveryMethod["price"] ?> Kč
                </td>
            </tr>

            <tr>
                <td class="cell-padd">
                    <? echo $paymentMethod["name"] ?>
                </td>
                <td class="cell-padd">
                    <? echo $paymentMethod["price"] ?> Kč
                </td>


                <td class="cell-padd">
                    1 Ks
                </td>

                <td class="cell-padd">
                    <? echo $paymentMethod["price"] ?> Kč
                </td>
            </tr>


            <tr class="total">
                <td class="cell-padd"> Součet</td>
                <td class="cell-padd"></td>
                <td class="cell-padd"></td>
                <td class="cell-padd"><? echo $order["price"] ?> Kč</td>
            </tr>
            </tbody>

        </table>
    </section>
<?php endif; ?>

