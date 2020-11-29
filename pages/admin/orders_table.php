<?php use services\AuthController;
use services\OrderRepository;

if (AuthController::isAdmin()): ?>

    <?php
    $orders = OrderRepository::getAllOrders()
    ?>
    <link rel="stylesheet" href="css/basic_table.css">
    <section class="main">
        <div class="overflow">
            <table class="basic-table">

                <thead>
                <tr>
                    <th> Číslo objednávky</th>
                    <th> Stav objednávky</th>
                    <th> Datum objednání</th>
                    <th> Celková cena</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($orders as $order): ?>


                    <tr>
                        <td><a href="?page=order_detail&orderId=<? echo $order["id"] ?>">   <? echo $order["id"] ?> </a>
                        </td>
                        <td><a href="?page=order_detail&orderId=<? echo $order["id"] ?>"><? echo $order["status"] ?></a>
                        </td>
                        <td>
                            <a href="?page=order_detail&orderId=<? echo $order["id"] ?>"><? echo $order["order_datetime"] ?></a>
                        </td>
                        <td><a href="?page=order_detail&orderId=<? echo $order["id"] ?>"><? echo $order["price"] ?>
                                Kč</a></td>

                    </tr>


                <? endforeach; ?>
                </tbody>

            </table>
        </div>
    </section>
<?php endif; ?>