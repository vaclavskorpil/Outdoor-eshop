<link rel="stylesheet" href="css/vertical_menu.css">
<link rel="stylesheet" href="css/shop.css">

<div class="shop-body">

    <?php use services\CartController;
    use services\ProductRepository;

    include_once "pages/side_nav.php" ?>

    <div class="items-body">
        <?php
        $products = ProductRepository::getAllProductsByCategory(4);
        if (isset($_POST["action"]) && $_POST["action"] == "add") {
            CartController::addToCart($_POST["pid"]);
            unset($_POST["action"]);
            unset($_POST["pid"]);

        }

        foreach ($products as $product):
            ?>
            <div class="shop-item">
                <div class="detail">
                    <a href="">
                        <img src=<?php echo $product["image"] ?>>
                        <div class="title">
                            <? echo $product["name"] ?>
                        </div>
                    </a>
                </div>

                <div class="cena-bez-dph">
                    Cena bez dph: <? echo $product["price"] ?>
                </div>

                <div class="cena-s-dph">
                    Cena: <? echo $product["price_tax"] ?>
                </div>

                <form method="post">
                    <input name="pid" type="hidden" value=<? echo $product["id"] ?>>
                    <input name="action" type="hidden" value="add">
                    <input type="submit" value="Přidej do košíku"/>
                </form>

            </div>
        <?php endforeach; ?>
    </div>


</div>