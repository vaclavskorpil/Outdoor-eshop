<link rel="stylesheet" href="css/basic_table.css">

<section class="main">
    <h2>Mé objednávky</h2>
    <?php

    use services\OrderRepository;

    if (isset($_SESSION[USER_ID])):
        $orders = OrderRepository::getUserOrders($_SESSION[USER_ID]);
        ?>
        <? if (sizeof($orders) != 0): ?>
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
        </div>;
    <?php else: ?>

        <h3>
            Nemáte žádné objednávky.
        </h3>
    <?php endif; ?>
    <?php else: ?>
        <h3>
            Nejste přihlášen. Objednávky může vidět pouze přihlášený uživatel.
        </h3>

    <?php endif; ?>


</section>
