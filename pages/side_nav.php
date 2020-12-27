<div class="sidenav">
    <?php

    use entities\Category;
    use services\CartController;
    use services\ProductRepository;

    $rootCats = ProductRepository::getAllRootCategories();
    foreach ($rootCats as $root):
        $children = ProductRepository::getCategoriesOneLevelBellow($root["id"]);
        ?>
        <button class='root-btn'>
            <a href=?page=shop&category=<? echo $root["id"] ?>><? echo $root["name"] ?></a>
            <img class="dropdown" src="images/dropdown.png">
        </button>
        <div id=<? echo $root["id"] ?> class="dropdown-container">
            <? foreach ($children as $child): ?>
                <a href=?page=shop&category=<? echo $child["id"] ?>><? echo $child["name"] ?></a>
            <? endforeach; ?>
        </div>
    <? endforeach; ?>

    <div class="cart">
        <a href="?page=cart" id="cart-title">
            Košík
        </a>
        <div class="cart-body">
            <?
            $totalPrice = 0;
            foreach ($_SESSION["cart"] as $pid => $value):
                $nameAndPrice = ProductRepository::getTinyById($pid);
                $totalPrice += $nameAndPrice["price"] * $value["quantity"]

                ?>
                <a href="#detail=<? echo $pid ?>" class="side-cart-item">
                    <div><? echo $nameAndPrice["name"] ?>    <? echo $value["quantity"] ?> Ks</div>
                </a>


            <? endforeach; ?>
        </div>
        <a href="?page=cart">
            <div class="cena-s-dph">
                Celkem: <? echo $totalPrice ?>
            </div>
        </a>
    </div>
    <script>
        var dropdown = document.getElementsByClassName("root-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");

                var dropdownContent = this.nextElementSibling;
                console.log(dropdownContent);
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>

</div>