<?php

use services\DeliveryRepository;
use services\OrderRepository;
use services\ProductRepository;


if (isset($_GET["orderId"])):
    ?>

    <?php
    $order = OrderRepository::getOrderDetail($_GET["orderId"]);
    $deliveryInfo = DeliveryRepository::getById($order["delivery_info"]);
    ?>
    <link rel="stylesheet" href="css/order_recap.css">
    <link rel="stylesheet" href="css/basic_table.css">
    <section class="main">
        <h2>
            Detail objednávky č. <? echo $_GET["orderId"] ?>
        </h2>

        <h3> Doručivací údaje</h3>
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

