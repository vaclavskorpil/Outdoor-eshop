<link rel="stylesheet" href="css/cart.css">

<section class="cart">
    <h2 id="cart-title"> Nákupní košík </h2>

    <div class="cart-body">

        <?

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
        foreach ($_SESSION["cart"] as $pid => $value):
            $info = ProductRepository::getNormalById($pid);
            $totalPrice += $info["price"] * $value["quantity"];
            $totalPriceDph += $info["price_tax"] * $value["quantity"];
            ?>
            <div class="cart-item">
                <a href="?page=detail=<? echo $pid ?>">
                    <img src=<? echo $info["image"] ?>>
                </a>
                <a href="?page=detail=<? echo $pid ?>" class="product-title">
                    <div><? echo $info["name"] ?></div>
                </a>
                <div class="quantity"
                >
                    <a href="?page=cart&action=remove&pid=<? echo $pid ?>">-</a>
                    <div><? echo $value["quantity"] ?></div>
                    <a href="?page=cart&action=add&pid=<? echo $pid ?>">+</a>
                </div>
                <div>
                    <? echo $info["price_tax"] ?> Kč/ks
                </div>
                <div>
                    <? echo($info["price_tax"] * $value["quantity"]) ?> Kč
                </div>


                <a href="?page=cart&action=removeAll&pid=<? echo $pid ?>" class="rem">
                    <button class="remove">
                        Odeber
                    </button>
                </a>

            </div>
        <? endforeach; ?>
    </div>
    <div class="price-row">
        <div class="price">
            <div class="cena-bez-dph">

                Celkem bez dph: <? echo $totalPrice ?> Kč
            </div>
            <div class="cena-s-dph">
                Celkem: <? echo $totalPriceDph ?> Kč
            </div>
        </div>
        <a href="?page=order_info" class="continue">
            <button>

                Pokračuj v objednávce

            </button>
        </a>
    </div>
</section>