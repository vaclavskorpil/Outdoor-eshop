<?php use services\AuthController;
use services\OrderRepository;
use services\ProductRepository;

if (AuthController::isAdmin()): ?>

    <?php
    $products = ProductRepository::getAllProducts()

    ?>
    <link rel="stylesheet" href="css/basic_table.css">
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/order_form.css">
    <section class="main">

        <form action="" method="get">
            <input type="hidden" name="page" value="add_product">
            <input id="add-product" type="submit" value="Přidej nový produkt">
        </form>
        <div class="overflow">
            <table class="basic-table">

                <thead>
                <tr>
                    <th></th>
                    <th> Název</th>
                    <th> Kategorie</th>
                    <th> Cena</th>
                    <th> Dph</th>

                </tr>
                </thead>
                <tbody>
                <? foreach ($products as $product): ?>

                    <?php
                    $category = ProductRepository::getCategoryNames($product["id_category"]);
                    ?>
                    <tr>
                        <td class="img-column">
                            <a
                                    href="?page=product_detail&productId=<? echo $product["id"] ?>">
                                <img class="img-tiny" src=<?php echo $product["image"] ?>>
                            </a>

                        </td>
                        <td>
                            <a href="?page=product_detail&productId=<? echo $product["id"] ?>">   <? echo $product["name"] ?> </a>
                        </td>
                        <td>
                            <a href="?page=product_detail&productId=<? echo $product["id"] ?>"> <? echo $category["parent_name"] . " " . $category["name"] ?></a>
                        </td>
                        <td>
                            <a href="?page=product_detail&productId=<? echo $product["price"] ?>">
                                <? echo $product["price"] ?> Kč
                            </a>
                        </td>

                        <td>
                            <a href="?page=product_detail&productId=<? echo $product["price"] ?>">
                                <? echo $product["tax"] ?> %
                            </a>
                        </td>
                    </tr>


                <? endforeach; ?>
                </tbody>

            </table>
        </div>
    </section>
<?php endif; ?>