<link rel="stylesheet" href="css/order_form.css">
<link rel="stylesheet" href="css/basic_table.css">
<link rel="stylesheet" href="css/cart.css">
<link rel="stylesheet" href="css/product.css">


<section class="cart">
    <h2 id="cart-title"> Nákupní košík </h2>

    <?

    use services\AuthController;
    use services\CartController;
    use services\ProductRepository;


    if (isset($_GET["action"])) {
        switch ($_GET["action"]) {
            case "add":
                CartController::addToCart($_GET["pid"]);
                break;
            case "remove":
                CartController::removeFromCart($_GET["pid"]);
                break;
            case "removeAll":
                CartController::removeAllFromCart($_GET["pid"]);
                break;
        }
        header("Location: ?page=cart");

    }

    $totalPrice = 0;
    $totalPriceDph = 0;
    ?>

    <table class="basic-table">

        <thead>
        <tr>
            <th></th>
            <th> Název</th>
            <th> Množství</th>
            <th> Jednotková cena</th>
            <th> Celková cena</th>
            <th></th>

        </tr>
        </thead>
        <tbody>
        <?
        foreach ($_SESSION["cart"] as $pid => $value):

            $info = ProductRepository::getNormalById($pid);
            $totalPrice += $info["price"] * $value["quantity"];
            $totalPriceDph += $info["price_tax"] * $value["quantity"];
            ?>
            <tr class="cart-item">
                <td class="img-column">
                    <a
                            href="?page=detail&productId=<? echo $pid ?>">
                        <img class="img-tiny" src=<?php echo $info["image"] ?>>
                    </a>

                </td>
                <td>
                    <a href="?page=detail&productId=<? echo $pid ?>"> <? echo $info["name"] ?></a>
                </td>

                <td>
                    <div class="quantity">
                        <a href="?page=cart&action=remove&pid=<? echo $pid ?>">-</a>
                        <div><? echo $value["quantity"] ?></div>
                        <a href="?page=cart&action=add&pid=<? echo $pid ?>">+</a>
                    </div>
                </td>
                <td>
                    <div>
                        <? echo $info["price_tax"] ?> Kč/ks
                    </div>
                </td>
                <td>
                    <div>
                        <? echo($info["price_tax"] * $value["quantity"]) ?> Kč
                    </div>
                </td>

                <td>
                    <a href="?page=cart&action=removeAll&pid=<? echo $pid ?>" class="rem">
                        <button class="remove">
                            Odeber
                        </button>
                    </a>
                </td>

            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <div class="price-row">
        <div class="price">
            <div class="cena-bez-dph">
                Celkem bez dph: <?
                echo $totalPrice ?> Kč
            </div>
            <div class="cena-s-dph">
                Celkem: <? echo $totalPriceDph ?> Kč
            </div>
        </div>
        <a href="?page=choose_delivery" class="continue">
            <button>
                Pokračuj v objednávce
            </button>
        </a>

    </div>
</section>

