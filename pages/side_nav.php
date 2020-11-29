<div class="sidenav">
    <?php

    use entities\Category;
    use services\CartController;
    use services\ProductRepository;

    function loadCategory(Category $category)
    {

        if (count($category->getChildren()) == 0) {
            echo "<a href=#category={$category->getId()}>{$category->getName()} </a>";
        } else {
            echo "<button class='dropdown-btn'>{$category ->getName()}";
            echo " </button>";
            echo "<div class='dropdown-container'>";
            foreach ($category->getChildren() as $cat) {
                echo "<a href=#category={$cat->getId()}>{$cat->getName()} </a>";
            }
            echo "</div>";
        }

    }


    $categories = Category::getAll();

    foreach ($categories as $category) {
        loadCategory($category);
    }
    ?>

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
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>

</div>