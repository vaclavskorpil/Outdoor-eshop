<link rel="stylesheet" href="css/product_detail.css">
<link rel="stylesheet" href="css/vertical_menu.css">
<link rel="stylesheet" href="css/shop.css">
<link rel="stylesheet" href="css/order_form.css">


<?php

use services\ProductRepository;


if (isset($_GET["productId"])): ?>
    <div style="padding: 25px">
        <div id="detail-body">
            <?
            $product = ProductRepository::getProductById($_GET["productId"]);
            if ($product):
                ?>
                <div id="image-wrapper">
                    <img id="detail-image" src=<? echo $product["image"] ?>>
                </div>
                <div id="product-meta">
                    <div class="title"><? echo $product["name"] ?></div>

                    <div class="product-meta-inner">
                        <div class="atr-column">
                            <div class="attributes">
                                <b>Vlastosti:</b>

                                <?
                                if (isset($product["width"])) {
                                    echo "<div>Šířka: {$product['width']} cm</div>";
                                }
                                if (isset($product["height"])) {
                                    echo "<div>Výška: {$product['height']} cm</div>";
                                }
                                if (isset($product["depth"])) {
                                    echo "<div>Hloubka: {$product['depth']} cm</div>";
                                }
                                if (isset($product["temperature_max"])) {
                                    echo "<div>Minimální teplota: {$product['tempereture_max']} °C</div>";
                                }
                                if (isset($product["temperature_min"])) {
                                    echo "<div>Komfortní teplota: {$product['temperature_min']} °C</div>";
                                }
                                if (isset($product["volume"])) {
                                    echo "<div>Obsah: {$product['volume']} l</div>";
                                }
                                if (isset($product["amount_of_people"])) {
                                    echo "<div>Počet osob: {$product['amount_of_people']}</div>";
                                }

                                if (isset($product["weight"])) {
                                    echo "<div>Váha: {$product['weight']} g</div>";
                                }
                                ?>
                            </div>

                            <div class="cena-bez-dph">
                                Cena bez dph: <? echo $product["price"] ?>
                            </div>

                            <div class="cena-s-dph">
                                Cena: <? echo $product["price_tax"] ?>
                            </div>
                        </div>
                        <div>
                            <div class="descripiton"><b>Popis produktu:</b>
                                <br>
                                <div>
                                    <? echo $product["description"] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post">
                        <input name="pid" type="hidden" value=<? echo $product["id"] ?>>
                        <input name="action" type="hidden" value="add">
                        <input type="submit" value="Přidej do košíku"/>
                    </form>

                </div>
            <?php endif; ?>
        </div>
        <div class="full-screen-bean">
            Mohlo by vás také zajímat
        </div>
        <?
        $additionalItems = ProductRepository::getNRandomProductsExcept(3, $_GET["productId"]); ?>
        <div class="additional-items">
            <? foreach ($additionalItems as $product): ?>
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
            <? endforeach; ?>
        </div>
    </div>
<?php endif ?>