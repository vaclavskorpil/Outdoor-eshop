<link rel="stylesheet" href="css/vertical_menu.css">
<link rel="stylesheet" href="css/shop.css">
<div style="width: 100%">
    <div class="full-screen-bean" style=" ;margin: 10px 10px 0px">
        <? if (isset($_GET["category"])) {

            $names = services\ProductRepository::getCategoryNames($_GET["category"]);
            if (isset($names['parent_name'])) {
                echo $names['parent_name'] . " - " . $names["name"];;
            } else {
                echo $names["name"];
            }
        } else {
            echo "Není vybrána žádná kategorie.";
        }
        ?>
    </div>

    <div class="items-body">
        <?php

        use services\ProductRepository;

        $products = [];
        if (isset($_GET["category"])) {
            $products = ProductRepository::getAllProductsByCategory($_GET["category"]);
        } else {
            $products = ProductRepository::getRandomProducts();
        }

        foreach ($products as $product):
            ?>


            <div class="shop-item">
                <div class="detail">
                    <a href="?page=detail&productId=<? echo $product["id"] ?>">
                        <img class="product-image" src=<?php echo $product["image"] ?>>
                        <div class="title">
                            <? echo $product["name"] ?>
                        </div>
                    </a>
                </div>

                <div class="cena-bez-dph">
                    Cena bez dph: <? echo $product["price"] ?> Kč
                </div>

                <div class="cena-s-dph">
                    Cena: <? echo $product["price_tax"] ?> Kč
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